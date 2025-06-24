<?php
namespace App\Routes;

use App\Controllers\UserController;
use App\Controllers\ContainerController;
use App\Controllers\ProjectsController;
use App\Functions\Router;
use App\Middleware\AuthMiddleware;

class ProjectRoutes
{
    public function register(Router $router) 
    {

        // * PROJECT
        $router->add('GET', '/project', function () {
            $middle = AuthMiddleware::verifyAuth();
        
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "view_projects")) {
                $display = new ContainerController();
                $display->listProjects();
            } else {
                header("Location: /list-customers");
                exit();
            }
        });
        
        $router->add('GET', '/create-project', function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
        
            if ($userController->checkPermission($middle->userId, "create_project")) {
                $display = new ContainerController();
                $display->createProject();
            } else {
                // * I don't have the id to go back to exaclty page the user was
                $returnPage = $_SERVER["HTTP_REFERER"] ?? "/";
                header("Location: " . $returnPage);
                exit();
            }
        });
        
        $router->add('POST', '/create', function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
        
            if ($userController->checkPermission($middle->userId, "create_project")) {
                $uriExplodes = explode('/', $_SERVER['REQUEST_URI']);
            
                $id = end($uriExplodes);
            
                $creation = new ProjectsController();
                $creation->createProject($id);
            
                header("Location: /success");
            } else {
                header("Location: /");
                exit();
            }
        
        });
        
        $router->add('GET', '/search-projects', function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "view_projects")) {
                $display = new ContainerController();
                $display->findProject();
            } else {
                header("Location: /list-customers");
                exit();
            }
        });
    }
}

