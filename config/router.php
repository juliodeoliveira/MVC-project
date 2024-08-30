<?php
require "../bootstrap.php";

use App\Controllers\ClientController;
use App\Controllers\ContainerController;
use App\Controllers\ProjectController;
use App\Models\Client;
use App\Functions\URI;
use App\Models\Projects;

$uri = URI::uri();

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
    $edition = new ClientController();
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
    $creation = new ProjectController();
    //$project = new Projects($_POST["title"], $_POST["startDate"], $_POST["endDate"], $_POST["service"]);
    // Please always consider to put the last index in this array, but this is a temporary solution
    $creation->createProject(URI::uriExplode()[2]);
    header("Location: /success");
}
elseif ($uri == "/") {
    require_once "../views/portal/home.php";
} else {
    require_once "../views/portal/notfound.php";
}
