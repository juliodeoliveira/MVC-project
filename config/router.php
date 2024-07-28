<?php
require "../bootstrap.php";

use App\Controllers\ClientController;
use App\Controllers\ContainerController;
use App\Models\Client;
// mudar o nome da pasta blog

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

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

    // $list = new ClientController();
    // $list->showClients();
}
// $uri == "/editing")
elseif (str_contains($uri, "/editing")) {
    $display = new ContainerController();
    $display->edition();
}
//$uri == "/edit"
elseif(str_contains($uri, "/edit")) {
    $edition = new ClientController();
    $model = new Client($_POST["enterpriseName"], $_POST["email"]);

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uriExplode = explode("/", "$uri");
    
    $model->setId($uriExplode[sizeof($uriExplode)-1]);
    $model->setPhoneNumber($_POST["phone_number"]);
    $model->setCep($_POST["cep"]);
    $model->setStreet($_POST["street"]);
    $model->setHouseNumber($_POST["nHouse"]);
    $model->setNeighbor($_POST["neighbor"]);
    $model->setCity($_POST["city"]);
    $model->setState($_POST["state"]);
    $model->setComplement($_POST["complement"]);

    // TODO: Esse formulário aqui ta estranho

    $update = new ClientController();
    $update->updateClient($model);

    $success = new ContainerController();
    $success->success();

}
elseif ($uri == "/") {
    require_once "../views/portal/home.php";
} else {
    require_once "../views/portal/notfound.php";
}