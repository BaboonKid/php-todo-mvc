<?php

class MemoryTaskService implements TaskServiceInterface {
  
  use SingletonTrait;
  
  /**
   * @var TaskEntity[]
   */
  private array $data;
  
  protected function __construct() {
    $this->init();
  }
  
  
  /**
   * Generate sample tasks
   *
   * @return void
   */
  private function init() : void {
    $this->data = [];
    for ($i = 0; $i < 32; $i++) {
      $this->data[$i] = (new TaskEntity())
        ->setId( $i )
        ->setTitle("Tâche n°" . $i + 1 )
        ->setDescription( "Contenu de ma tâche" )
        ->setCompleted( $i % 2 === 0 )
        ->setCreatedAt( "2022-10-2" . $i % 10 . "T16:53:44" )
        ->setUpdatedAt("2022-10-24T16:53:44" )
        ->setCompleted( "2022-10-24T16:53:44" );
    }
  }
  
  
  /**
   * @inheritDoc
   */
  public function get ( int $id ) : ?TaskEntity {
    return $this->data[$id] ?? null;
  }

  /**
   * @inheritDoc
   */
  public function list ( array $args = [] ) : array {
    $results = [];
  
    // Filters results : we exclude unwanted tasks from output
    foreach ( $this->data as $task ) :
      // Search filter
      if ( isset( $args['search'] ) && ! str_contains( $task->getTitle(), $args['search'] ) )
        continue;
    
      // If we only want to show uncompleted tasks
      if ( isset( $args['hideCompleted'] ) && $args['hideCompleted'] && $task->isCompleted() )
        continue;
    
      $results[] = $task;
    endforeach;
  
    // Order by handling
    usort( $results, function ( TaskEntity $a, TaskEntity $b ) use ( $args ) {
      switch ( $args['orderBy'] ?? null ) :
        case "title":
          return strnatcmp($a->getTitle(), $b->getTitle());
      
        case "completedAt":
          $aTime = strtotime( $a->getCompletedAt() ?? 0 );
          $bTime = strtotime( $b->getCompletedAt() ?? 0 );
        
          if ( $aTime === $bTime )
            return 0;
        
          return $aTime > $bTime
            ? -1
            : 1;
      
        case "createdAt":
        default:
          $aTime = strtotime( $a->getCreatedAt() );
          $bTime = strtotime( $b->getCreatedAt() );
        
          if ( $aTime === $bTime )
            return 0;
        
          return $aTime > $bTime
            ? -1
            : 1;
      endswitch;
    } );
    
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