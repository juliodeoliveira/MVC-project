<?php
// https://devclass.com.br/curso/show/12/23
require "../bootstrap.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use core\Controller;

try {
    $controller = new Controller;
    $controller -> load();
    dd($controller);
} catch (\Exception $e) {
    dd($e -> getMessage());
}


// $method = new Method;
// $method = $method -> getMethod();

// $parameters = new Parameters;
// $parameters -> getParamethers();

// $controller -> $method($parameters);