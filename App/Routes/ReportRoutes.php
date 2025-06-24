<?php
namespace App\Routes;

use App\Controllers\ReportController;
use App\Controllers\UserController;
use App\Functions\Router;
use App\Middleware\AuthMiddleware;

class ReportRoutes
{
    public function register(Router $router)
    {        
        $router->add('GET', '/project-report', function() { 
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "download_reports")) {
                $createReport = new ReportController();
                $createReport->createProjectReport();
            } else {
                $returnPage = $_SERVER["HTTP_REFERER"] ?? "/";
                header("Location: " . $returnPage);
                exit();
            }
        });
        
        $router->add("GET", "/client-report", function() {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "download_reports")) {
                $createReport = new ReportController();
                $createReport->createClientReport();
            } else {
                header("Location: /list-customers");
                exit();
            }
        });
    }
}