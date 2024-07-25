<?php

//* Sistema de rotas, elas iniciam quando index carrega e manda pra rotas e página certa.

require_once "../config/router.php";

use App\Controllers\ClientController;
use App\Repositories\ClientRepository;
use App\Models\Client;

require "../bootstrap.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
exit();

// use core\Controller;
// use core\Method;
// use core\Parameters;
// TODO: Fazer outra página para atualizar cliente;
//* Talvez não seja uma boa ideia deixar view com esse arquivo juntos
try {
    // $controller = new Controller;
    // $controller = $controller -> load();
    
    // $method = new Method;
    // $method = $method->load($controller);

    // $parameters = new Parameters;
    // $parameters = $parameters->load();

    // $controller -> $method($parameters);

    if (empty($_POST["enterpriseName"]) || empty($_POST["email"])) {
        echo "Insira o nome e email da empresa!";
        exit();
    }

    $rep = new ClientRepository();
    $controller = new ClientController();
    
    $newClient = new Client($_POST['enterpriseName'], $_POST['email']);
    $newClient->setPhoneNumber($_POST["phone_number"]);
    $newClient->setCep($_POST["cep"]);
    $newClient->setStreet($_POST["street"]);
    $newClient->setHouseNumber($_POST["nHouse"]);
    $newClient->setNeighbor($_POST["neighbor"]);
    $newClient->setCity($_POST["city"]);
    $newClient->setState($_POST["state"]);
    $newClient->setComplement($_POST["complement"]);
    
    $id = $rep->insert($newClient);
    if ($id != null) {
        echo "Usuário cadastrado!";
    }

    $client = $rep->show($id); 

    // $controller->updateClient($newClient);

    // $update = $rep->update($newClient);
    echo "<br>";
    dd($client);
} catch (\Exception $e) {
    dd($e -> getMessage());
}


// $method = new Method;
// $method = $method -> getMethod();

// $parameters = new Parameters;
// $parameters -> getParamethers();

// $controller -> $method($parameters);