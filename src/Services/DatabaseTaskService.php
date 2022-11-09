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
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
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
    $lastId = count($this->data);
    
    $this->data[$lastId] = $task;
    $task->setId($lastId);
    $task->setCreatedAt( date("Y-m-d H:i:s") );
    
    return $task;
  }
  
  
  /**
   * @inheritDoc
   */
  public function update ( TaskEntity $task ) : TaskEntity {
    $this->data[ $task->getId() ] = $task;
    return $task;
  }
  
  
  /**
   * @inheritDoc
   */
  public function delete ( int $id ) : void {
    unset( $this->data[ $id ] );
  }
}