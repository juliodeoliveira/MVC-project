<?php
namespace App\Routes;

use App\Controllers\UserController;
use App\Controllers\ContainerController;
use App\Functions\Router;
use App\Middleware\AuthMiddleware;

class AdminRoutes
{
    public function register(Router $router) {
        // * USER
        $router->add("GET", "/admin", function() {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
        
            if ($userController->checkPermission($middle->userId, "manage_permissions")) {
                $display = new ContainerController();
                $display->admin();
            } else {
                header("Location: /");
                exit();
            }
        });
        
        $router->add("POST", "/update-user", function() {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
        
            if ($userController->checkPermission($middle->userId, "manage_permissions")) {
                $userController->updatePermissions($_POST["user_id"], $_POST["permissions"]);
            }
        
            header("Location: ". $_SERVER['HTTP_REFERER']);
            exit();
        });
    }
}