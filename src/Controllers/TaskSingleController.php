<?php

class TaskSingleController extends AbstractController {
  
  private ?TaskEntity $task;
  private bool $editing = false;

  public function __construct($service,$task_id) {
    if ($task_id != null) {
      $this -> task = $service->get($task_id);
      if ($this -> task == null) {
        echo get_404();
        die;
      }
      $this -> editing = true;
    } else {
      $this -> task = new TaskEntity();
    }
    $this -> taskService = $service;
  }

  private function handleForm() {

    if ($this -> task -> getId() == null) {
      $this -> task -> setTitle($_POST['name']);
      $this -> task -> setDescription($_POST['content']);
      $this -> task -> setCompleted(isset($_POST['completed']));
      $this -> taskService -> create($this -> task);
    } else {
      $this -> task -> setTitle($_POST['name']);
      $this -> task -> setDescription($_POST['content']);
      $this -> task -> setCompleted(isset($_POST['completed']));
      $this -> taskService -> update($this -> task);
    }

  }
  
  public function render() : void {
    
    var_dump($_POST);
    if (isset($_POST['action'])) {
      $this -> handleForm();
    }

    echo get_template( __PROJECT_ROOT__ . "/views/single.php", [
      'task' => $this ->task,
      'editing' => $this -> editing
    ]);
  }

  

}