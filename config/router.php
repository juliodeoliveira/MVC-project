<?php
require "../bootstrap.php";

use App\Controllers\ClientController;
use App\Controllers\ContainerController;
use App\Controllers\ProjectsController;
use App\Models\Client;
use App\Functions\URI;
use App\Models\Projects;

$uri = URI::uri();
$uriExplodes = URI::uriExplode();

if ($uri == '/signin-client') {
    $newClient = new ContainerController();
    $newClient->signinClient();
}
elseif ($uri == '/sign-client') {
    $write = new ClientController();
    $write->signClient();
    header("Location: /success");
}
elseif ($uri == "/success") {
    // dd("Hello there! Everything is quite fine here, diferent from your house, every parent went for a side and you look like kinda disolated, I am really sorry...");
    $success = new ContainerController();
    $success->success();
}
elseif ($uri == "/list-customers") {
    $display = new ContainerController();
    $display->listCustomers();
}
elseif (str_contains($uri, "/editing")) {
    $display = new ContainerController();
    $display->edition();
}
elseif(str_contains($uri, "/edit")) {
    $model = new Client($_POST["enterpriseName"], $_POST["email"]);

    $update = new ClientController();
    $update->updateClient($model);

    $success = new ContainerController();
    $success->success();
}
elseif(str_contains($uri, "/project")) {
    $display = new ContainerController();
    $display->listProjects();
}
elseif (str_contains($uri, "/create-project")) {
    $display = new ContainerController();
    $display->createProject();
}
elseif (str_contains($uri, "/create")) {
    $creation = new ProjectsController();
    $creation->createProject($uriExplodes[sizeof($uriExplodes)-1]);
    header("Location: /success");
}
elseif (str_contains($uri, "/search-projects")) {
    $display = new ContainerController();
    $display->findProject();
}
elseif (str_contains($uri, "/search-clients")) {
    $display = new ContainerController();
    $display->findClients();
}

elseif (str_contains($uri, "/to-do-list")) {
    $display = new ContainerController();
    $display->toDoList();
}
elseif (str_contains($uri, "/save-todo")) {
    $addToDo = new ProjectsController();

    $toDoList = json_decode($_POST['valor'], true);
    $addToDo->saveToDoList($uriExplodes[sizeof($uriExplodes)-1], $toDoList); 
}
elseif ($uri == "/processPhoto") {
    $addPhoto = new ProjectsController();
    $addPhoto->processPhoto();
    header("Location: " . $_SERVER['HTTP_REFERER']);

}

elseif ($uri == "/") {
    require_once "../views/portal/home.php";
} else {
    require_once "../views/portal/notfound.php";
}
