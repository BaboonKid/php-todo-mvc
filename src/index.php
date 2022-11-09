<?php

const __PROJECT_ROOT__ = __DIR__;

require_once __PROJECT_ROOT__ . "/Common/SingletonTrait.php";
require_once __PROJECT_ROOT__ . "/Common/functions.php";

require_once __PROJECT_ROOT__ . "/Entities/TaskEntity.php";
require_once __PROJECT_ROOT__ . "/Entities/Database.php";

require_once __PROJECT_ROOT__ . "/Services/TaskServiceInterface.php";
require_once __PROJECT_ROOT__ . "/Services/MemoryTaskService.php";
require_once __PROJECT_ROOT__ . "/Services/DatabaseTaskService.php";

require_once __PROJECT_ROOT__ . "/Controllers/AbstractController.php";
require_once __PROJECT_ROOT__ . "/Controllers/TaskSingleController.php";
require_once __PROJECT_ROOT__ . "/Controllers/TaskListController.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );


switch ($uri[1]) :
  // List/Home view
  case "":
  case "home":
    (new TaskListController( DatabaseTaskService::getInstance() ))->render();
    break;
    
  // Create/Edit/Delete view
  case "task":
    // Extraction de l'id de la tâche depuis l'URI /task/{id}
    $task_id = isset($uri[2])
      ? intval($uri[2])
      : null;
    (new TaskSingleController( DatabaseTaskService::getInstance(), $task_id ))->render();
    break;
  
  // Default 404
  default:
    echo get_404();
    exit();
endswitch;