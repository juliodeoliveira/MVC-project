<?php
namespace App\Routes;

//? como eu transformo isso em classes? nao seria melhor?
use App\Controllers\ClientController;
use App\Controllers\UserController;
use App\Controllers\ContainerController;
use App\Models\Client;
use App\Functions\Router;

use App\Middleware\AuthMiddleware;

class ClientRoutes
{
    public function register(Router $router) 
    {
        // * CLIENTS
        $router->add('GET', '/signin-client', function () {// Testado
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "create_client")) {
                $newClient = new ContainerController();
                $newClient->signinClient();
            } else {
                header("Location: /");
                exit();
            }
        });

        $router->add('POST', '/write-client', function () { // Testado
            $middle = AuthMiddleware::verifyAuth();
            // todo: add permissao para criar, ver e editar clientes
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "create_client")) {
                $write = new ClientController();
                $write->signClient();

                header("Location: /success");
                exit();
            } else {
                header("Location: /");
                exit();
            }
        });

        $router->add('GET', '/list-customers', function () { // Testado
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "view_clients")) {
                $display = new ContainerController();
                $display->listCustomers();
            } else {
                header("Location: /");
                exit();
            }
        });

        $router->add('GET', '/editing', function () { // Testado
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "edit_client")) {
                $display = new ContainerController();
                $display->edition();
            } else {
                header("Location: /list-customers");
                exit();
            }
        });

        $router->add('POST', '/edit', function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();

            if ($userController->checkPermission($middle->userId, "edit_client")) {
                $model = new Client($_POST["enterpriseName"], $_POST["email"]);
            
                $update = new ClientController();
                $update->updateClient($model);
            
                $success = new ContainerController();
                $success->success();
            } else {
                header("Location: /list-customers");
                exit();
            }
        });

        $router->add('GET', '/success', function () { // Testado
            // ? pq tem q ter autenticacao na tela de sucesso?
            AuthMiddleware::verifyAuth();
            $success = new ContainerController();
            $success->success();
        });

        $router->add('GET', '/search-clients', function () {
            $middle = AuthMiddleware::verifyAuth();
            $userController = new UserController();
            if ($userController->checkPermission($middle->userId, "view_clients")) {
                $display = new ContainerController();
                $display->findClients();
            } else {
                // TODO: transformar isso em uma funcao
                header("Location: /");
                exit();
            }
        });
    }
}
