<?php
namespace App\Routes;

//* PHOTOS
use App\Controllers\PhotosController;
use App\Controllers\UserController;
use App\Functions\Router;
use App\Middleware\AuthMiddleware;

class PhotoRoutes
{
    public function register(Router $router)
    {
        $router->add('POST', '/process-photo', function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            
            if ($userController->checkPermission($middle->userId, "edit_project")) {
                $managePhoto = new PhotosController();
                
                if ($_POST["job"] == "insert") {
                    $managePhoto->processPhoto();
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                } elseif ($_POST["job"] == "delete") {
                    $managePhoto->deletePhoto($_POST["imageSrc"]);
                } 
                // else {
                //     header("Location: /");
                // }
            } else {
                $returnPage = $_SERVER["HTTP_REFERER"] ?? "/";
                header("Location: " . $returnPage);
                exit();
            }
        });
    }
}
