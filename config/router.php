<?php

require "../bootstrap.php";

use App\Controllers\ClientController;
use App\Controllers\ContainerController;
use App\Controllers\ProjectsController;
use App\Controllers\TasksController;
use App\Controllers\PhotosController;

use App\Models\Client;

use App\Functions\Router;

// Instancia o roteador
$router = new Router();

// Define as rotas
$router->add('GET', '/', function () {
    require_once "../views/portal/home.php";
});

$router->add('GET', '/signin-client', function () {
    $newClient = new ContainerController();
    $newClient->signinClient();
});

$router->add('POST', '/write-client', function () {
    $write = new ClientController();
    $write->signClient();
    header("Location: /success");
});

$router->add('GET', '/success', function () {
    $success = new ContainerController();
    $success->success();
});

$router->add('GET', '/list-customers', function () {
    $display = new ContainerController();
    $display->listCustomers();
});

$router->add('GET', '/editing', function () {
    $display = new ContainerController();
    $display->edition();
});

$router->add('POST', '/edit', function () {
    $model = new Client($_POST["enterpriseName"], $_POST["email"]);

    $update = new ClientController();
    $update->updateClient($model);

    $success = new ContainerController();
    $success->success();
});

$router->add('GET', '/project', function () {
    $display = new ContainerController();
    $display->listProjects();
});

$router->add('GET', '/create-project', function () {
    $display = new ContainerController();
    $display->createProject();
});

$router->add('POST', '/create', function () {
    $uriExplodes = explode('/', $_SERVER['REQUEST_URI']);

    $id = end($uriExplodes);

    $creation = new ProjectsController();
    $creation->createProject($id);

    header("Location: /success");
});

$router->add('POST', '/search-projects', function () {
    $display = new ContainerController();
    $display->findProject();
});

$router->add('POST', '/search-clients', function () {
    $display = new ContainerController();
    $display->findClients();
});

$router->add('GET', '/to-do-list', function () {
    $display = new ContainerController();
    $display->toDoList();
});

$router->add('POST', '/save-todo', function () {
    $uriExplodes = explode('/', $_SERVER['REQUEST_URI']);

    $projectId = end($uriExplodes);

    $addToDo = new TasksController();

    $toDoList = json_decode($_POST['valor'], true);
    $addToDo->saveToDoList($uriExplodes[sizeof($uriExplodes)-1], $toDoList); 
});

$router->add('POST', '/process-photo', function () {
    $managePhoto = new PhotosController();
    
    if ($_POST["job"] == "insert") {
        $managePhoto->processPhoto();
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } elseif ($_POST["job"] == "delete") {
        $managePhoto->deletePhoto($_POST["imageSrc"]);
    } else {
        header("Location: /");
    }
});

$router->dispatch();
