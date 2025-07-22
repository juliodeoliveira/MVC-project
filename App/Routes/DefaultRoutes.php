<?php
namespace App\Routes;

use App\Controllers\ContainerController;

use App\Middleware\AuthMiddleware;

use App\Functions\Router;

class DefaultRoutes
{
    public function register(Router $router)
    {
        $router->add('GET', '/', function () {
            $verifyAuth = AuthMiddleware::verifyAuth();
            $_SESSION["usernameLogged"] = $verifyAuth->name ?? null;

            require_once "../views/portal/home.php";
        });

        $router->add('GET', '/success', function () { // Testado
            // ? pq tem q ter autenticacao na tela de sucesso?
            AuthMiddleware::verifyAuth();
            $success = new ContainerController();
            $success->success();
        });
    }
}