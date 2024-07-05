<?php

use App\Repositories\ClientRepository;
use App\Models\Client;
require "../bootstrap.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// use core\Controller;
// use core\Method;
// use core\Parameters;

try {
    // $controller = new Controller;
    // $controller = $controller -> load();
    
    // $method = new Method;
    // $method = $method->load($controller);

    // $parameters = new Parameters;
    // $parameters = $parameters->load();

    // $controller -> $method($parameters);
    $rep = new ClientRepository();
    
    
    $newClient = new Client("Pepsico", "pepsico@gmail.com");
    
    $id = $rep->insert($newClient);
    $client = $rep->show($id);
    

    dd($client);
} catch (\Exception $e) {
    dd($e -> getMessage());
}


// $method = new Method;
// $method = $method -> getMethod();

// $parameters = new Parameters;
// $parameters -> getParamethers();

// $controller -> $method($parameters);