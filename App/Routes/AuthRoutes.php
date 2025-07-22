<?php
namespace App\Routes;

use App\Controllers\ContainerController;
use App\Controllers\UserController;
use App\Functions\Router;
// ?  talvez inútil?
use App\Middleware\AuthMiddleware;

class AuthRoutes
{
    public function register(Router $router) 
    {

        // * AUTH
        $router->add("GET", "/sign-in", function() {
            $display = new ContainerController();
            $display->registerUser();
        });
        
        $router->add("POST", "/sign-user", function() {
            $register = new UserController();
            $register->registerUser();
            
            AuthMiddleware::verifyAuth();
        });
        
        $router->add("GET", "/login", function() {
            $display = new ContainerController();
            $display->login();
        });
        
        $router->add("POST", "/login-user", function() {
            $userController = new UserController();
            $userController->loginUser();
        
            AuthMiddleware::verifyAuth();
        
            header("Location: /");
            exit();
        });
        
        $router->add("GET", "/logout", function() {
            session_start();
            session_unset();
            session_destroy();
            header("Location: /");
            exit();
        });
    }
}
