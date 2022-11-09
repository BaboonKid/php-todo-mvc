<?php
class TaskListController extends AbstractController {
  
  public function render () : void {
   echo get_template( __PROJECT_ROOT__ . "/Views/list.php", [
     'tasks' => $this->taskService->list(
      [
        'orderBy' => $_GET['order-by'] ?? 'createdAt',
        'search' => $_GET['search'] ?? null,
        'hideCompleted' => (isset($_GET['only-show-completed']) && $_GET['only-show-completed'] == 'on') ?? false,
        'page' => $_GET['page'] ?? 1
        ]
     )
   ] );
  }
  
}