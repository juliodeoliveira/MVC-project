<?php
namespace App\Routes;

use App\Controllers\TasksController;
use App\Controllers\UserController;
use App\Controllers\ContainerController;
use App\Functions\Router;
use App\Middleware\AuthMiddleware;

class TasksRoutes
{
    public function register(Router $router)
    {
        $router->add('GET', '/to-do-list', function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "edit_project")) {
                $display = new ContainerController();
                $display->toDoList();
            } else {
                $returnPage = $_SERVER["HTTP_REFERER"] ?? "/";
                header("Location: " . $returnPage);
                exit();
            }
        });
        
        $router->add('POST', '/save-todo', function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "edit_project")) {
                $uriExplodes = explode('/', $_SERVER['REQUEST_URI']);
        
                // $projectId = end($uriExplodes);
                $toDoList = json_decode($_POST['valor'], true);
        
                $addToDo = new TasksController();
                $addToDo->saveToDoList($uriExplodes[sizeof($uriExplodes)-1], $toDoList); 
            } else {
                $returnPage = $_SERVER["HTTP_REFERER"] ?? "/";
                header("Location: " . $returnPage);
                exit();
            }
        });
    }
}
//TODO: separar todo's