<?php
namespace App\Routes;

use App\Controllers\DocumentController;
use App\Controllers\UserController;
use App\Controllers\ContainerController;
use App\Functions\Router;
use App\Middleware\AuthMiddleware;

class DocumentRoutes
{
    public function register(Router $router)
    {
        $router->add('POST', "/process-document", function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
        
            if ($userController->checkPermission($middle->userId, "edit_project")) {
                $manageDoc = new DocumentController();
                $manageDoc->saveDocument();
            }
        
            $returnPage = $_SERVER["HTTP_REFERER"] ?? "/";
            header("Location: " . $returnPage);
            exit();
        });
        
        $router->add('GET', '/download', function() {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
        
            if ($userController->checkPermission($middle->userId, "download_document")) {
                if (!isset($_GET["file"])) {
                    http_response_code(400);
                    
                    $display = new ContainerController();
                    $display->notFound();
                    exit();
                }
        
                $download = new DocumentController();
                $download->downloadDocument();
            } else {
                $returnPage = $_SERVER["HTTP_REFERER"] ?? "/";
                header("Location: " . $returnPage);
                exit();
            }
        });
    }
}