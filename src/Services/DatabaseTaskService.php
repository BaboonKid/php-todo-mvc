<?php

class DatabaseTaskService implements TaskServiceInterface {
  
  use SingletonTrait;

  private Database $db;
  
  protected function __construct() {
    $this->init();
  }
  
  
  /**
   * Generate sample tasks
   *
   * @return void
   */
  private function init() : void {
    $this->db = Database::getInstance();
  }
  
  
  /**
   * @inheritDoc
   */
  public function get ( int $id ) : ?TaskEntity {
     $stmt = $this->db->db->prepare("SELECT * FROM tasks WHERE id = :id");
     $stmt->execute(['id' => $id]);
     $task = $stmt->fetch(PDO::FETCH_ASSOC);
     $result = new TaskEntity();
     $result->setId($task['id'])
            ->setTitle($task['title'])
            ->setDescription($task['description'])
            ->setCompleted($task['completed'])
            ->setCreatedAt($task['createdAt'])
            ->setUpdatedAt($task['updatedAt'])
            ->setCompletedAt($task['completedAt']);
    return $result;
  }

  /**
   * @inheritDoc
   */
  public function list ( array $args = [] ) : array {
    $results = [];
  
    $query = "SELECT * FROM tasks";

    $options = [];
    $stmtArgs = [];

    if ( isset( $args['search'] ) ) {
        $options[] = " title LIKE \"%:search%\"";
        $stmtArgs['search'] = $args['search'];
    }
    
    // If we only want to show uncompleted tasks
    if ( isset( $args['hideCompleted'] ) && $args['hideCompleted'] == true ) {
        $options[] = " completed = :hideCompleted";
        $stmtArgs['hideCompleted'] = $args['hideCompleted'];
    };
    
    if ( count($options) > 0 ) {
        $query .= " WHERE " . implode(" AND ", $options);
    }
  
    // Order by handling
    switch ($args['orderBy'] ?? null) :
        case "title":
            $query  .= " ORDER BY title";
            break;
        case "completedAt":
            $query .= " ORDER BY completedAt";
            break;
        case "createdAt":
            $query .= " ORDER BY createdAt";
            break;
    endswitch;

    $stmt = $this->db->db->prepare($query);
    $stmt->execute($stmtArgs);
    $results = $stmt->fetchAll(PDO::FETCH_CLASS, TaskEntity::class);
    
    return array(
      'page'=> $args['page'] ?? 1,
      'perPage' => $args['perPage'] ?? 10,
      'total' => count( $results ),
      'tasks' => $results
    );
  }
  
  
  /**
   * @inheritDoc
   */
  public function create ( TaskEntity $task ) : TaskEntity {
    $stmt = $this->db->db->prepare("INSERT INTO tasks (title, description, completed, completedAt) VALUES (:title, :description, :completed, :completedAt)");

    $stmt -> bindValue(':title', $task->getTitle());
    $stmt -> bindValue(':description', $task->getDescription());
    $stmt -> bindValue(':completed', $task->isCompleted() ? 1 : 0);
    $stmt -> bindValue(':completedAt', $task->getCompletedAt());

    $stmt->execute();
    
    return $this -> get($this->db->db->lastInsertId());
  }
  
  
  /**
   * @inheritDoc
   */
  public function update ( TaskEntity $task ) : TaskEntity {

    $stmt = $this->db->db->prepare("UPDATE tasks SET title = :title, description = :description, completed = :completed, completedAt = :completedAt WHERE id = :id");

    $stmt -> bindValue(':title', $task->getTitle());
    $stmt -> bindValue(':description', $task->getDescription());
    $stmt -> bindValue(':completed', $task->isCompleted() ? 1 : 0);
    $stmt -> bindValue(':completedAt', $task->getCompletedAt());
    $stmt -> bindValue(':id', $task->getId());

    $stmt -> execute();

    return $this -> get($task->getId());
  }
  
  
  /**
   * @inheritDoc
   */
  public function delete ( int $id ) : void {

    $stmt = $this->db->db->prepare("DELETE FROM tasks WHERE id = :id");

    $stmt -> bindValue(':id', $id);

    $stmt->execute();
  }
}