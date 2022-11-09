<?php


/**
 * Defines the common way of using a task service implementation
 */
interface TaskServiceInterface {
  
  /**
   * Retrieve a TaskEntity instance using its ID
   *
   * @param int $id
   *
   * @return TaskEntity|null
   */
  public function get ( int $id ) : ?TaskEntity;
  
  
  /**
   * Retrieve multiple TaskEntities that complies to optional parameters that can be passed in $args.
   *
   * @param array{
   *  orderBy: string,
   *  order: string,
   *  search: string,
   *  perPage: int,
   *  page: int,
   *  hideCompleted: bool
   * } $args
   *
   * @return TaskEntity[]
   */
  public function list ( array $args = [] ) : array;
  
  
  /**
   * Persist a new TaskEntity to the storage
   *
   * @param TaskEntity $task
   *
   * @return TaskEntity
   */
  public function create ( TaskEntity $task ) : TaskEntity;
  
  
  /**
   * Apply modifications to the TaskEntity record
   *
   * @param TaskEntity $task
   *
   * @return TaskEntity
   */
  public function update ( TaskEntity $task ) : TaskEntity;
  
  
  /**
   * Deletes a TaskEntity from the storage
   *
   * @param int $id
   *
   * @return void
   */
  public function delete ( int $id ) : void;
  
}