<?php
require "../bootstrap.php";

use App\Controllers\blog\ClientController;
use App\Controllers\ContainerController;
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
elseif ($uri == "/") {
    require_once "../views/portal/home.php";
} else {
    require_once "../views/portal/notfound.php";
}