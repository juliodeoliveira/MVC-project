<?php
// TODO: Separar as rotas de acordo com as responsabilidades. Ex.: rotas de usuario: UserRoutes.php
//? Seria interessante se um usuario tentar acessar uma página eu mostrar pra ele que a pagina nao existe ao inves de redirecionar ele?
require "../bootstrap.php";

use App\Controllers\ClientController;
use App\Controllers\ContainerController;
use App\Controllers\ProjectsController;
use App\Controllers\TasksController;
use App\Controllers\PhotosController;
use App\Controllers\DocumentController;
use App\Controllers\ReportController;
use App\Controllers\UserController;

use App\Models\Client;

use App\Functions\Router;
use App\Middleware\AuthMiddleware;

$router = new Router();

$router->add('GET', '/', function () {
    $verifyAuth = AuthMiddleware::verifyAuth();
    $_SESSION["usernameLogged"] = $verifyAuth->name ?? null;

    require_once "../views/portal/home.php";
});

$router->add('GET', '/signin-client', function () {// Testado
    $newClient = new ContainerController();
    $newClient->signinClient();
    AuthMiddleware::verifyAuth();
});

$router->add('POST', '/write-client', function () { // Testado
    AuthMiddleware::verifyAuth();
    $write = new ClientController();
    $write->signClient();
    header("Location: /success");
});

$router->add('GET', '/success', function () { // Testado
    AuthMiddleware::verifyAuth();
    $success = new ContainerController();
    $success->success();
});

$router->add('GET', '/list-customers', function () { // Testado
    AuthMiddleware::verifyAuth();
    $display = new ContainerController();
    $display->listCustomers();
});

$router->add('GET', '/editing', function () { // Testado
    AuthMiddleware::verifyAuth();
    $display = new ContainerController();
    $display->edition();
});

$router->add('POST', '/edit', function () {
    AuthMiddleware::verifyAuth();
    $model = new Client($_POST["enterpriseName"], $_POST["email"]);

    $update = new ClientController();
    $update->updateClient($model);

    $success = new ContainerController();
    $success->success();
});

$router->add('GET', '/project', function () { // Testado
    AuthMiddleware::verifyAuth();
    $display = new ContainerController();
    $display->listProjects();
});

$router->add('GET', '/create-project', function () { // Testado
    AuthMiddleware::verifyAuth();
    $display = new ContainerController();
    $display->createProject();
});

$router->add('POST', '/create', function () {
    AuthMiddleware::verifyAuth();
    $uriExplodes = explode('/', $_SERVER['REQUEST_URI']);

    $id = end($uriExplodes);

    $creation = new ProjectsController();
    $creation->createProject($id);

    header("Location: /success");
});

$router->add('GET', '/search-projects', function () { // Testado
    AuthMiddleware::verifyAuth();
    $display = new ContainerController();
    $display->findProject();
});

$router->add('GET', '/search-clients', function () { // Testado
    AuthMiddleware::verifyAuth();
    $display = new ContainerController();
    $display->findClients();
});

$router->add('GET', '/to-do-list', function () { 
    AuthMiddleware::verifyAuth();
    $display = new ContainerController();
    $display->toDoList();
});

$router->add('POST', '/save-todo', function () {
    AuthMiddleware::verifyAuth();
    $uriExplodes = explode('/', $_SERVER['REQUEST_URI']);

    // $projectId = end($uriExplodes);
    $toDoList = json_decode($_POST['valor'], true);

    $addToDo = new TasksController();
    $addToDo->saveToDoList($uriExplodes[sizeof($uriExplodes)-1], $toDoList); 
});

$router->add('POST', '/process-photo', function () {
    AuthMiddleware::verifyAuth();
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

$router->add('POST', "/process-document", function () {
    AuthMiddleware::verifyAuth();
    $manageDoc = new DocumentController();
    $manageDoc->saveDocument();

    header("Location: " . $_SERVER['HTTP_REFERER']);
});

$router->add('GET', '/download', function() {
    AuthMiddleware::verifyAuth();
    if (!isset($_GET["file"])) {
        http_response_code(400);

        $display = new ContainerController();
        $display->notFound();
        exit();
    }

    $download = new DocumentController();
    $download->downloadDocument();
});

$router->add('GET', '/project-report', function() { 
    AuthMiddleware::verifyAuth();
    $createReport = new ReportController();
    $createReport->createProjectReport();
});

$router->add("GET", "/client-report", function() {
    AuthMiddleware::verifyAuth();
    $createReport = new ReportController();
    $createReport->createClientReport();
});

$router->add("GET", "/sign-in", function() {
    $display = new ContainerController();
    $display->registerUser();
});

$router->add("POST", "/sign-user", function() {
    // AuthMiddleware::verifyAuth();
    $register = new UserController();
    $register->registerUser();
});

$router->add("GET", "/login", function() {
    $display = new ContainerController();
    $display->login();
});

$router->add("POST", "/login-user", function() {
    $userController = new UserController();
    $userController->loginUser();
    // instanciar a classe User model aqui, mas antes tem que remover o header: / do loginUser
    //TODO: Vai ser melhor se eu só redirecionar mesmo e na home.php chamar o getID, aí ele faz uma query e pega o id de tal usuario
    // $_SESSION["user_info"] = $userController->instanceUser();

    AuthMiddleware::verifyAuth();

    header("Location: /");
    exit();
});

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
        $userController->updatePermissions();
    }

    header("Location: ". $_SERVER['HTTP_REFERER']);
    exit();
});

$router->add("GET", "/logout", function() {
    session_start();
    session_unset();
    session_destroy();
    header("Location: /");
    exit();
});

$router->dispatch();
