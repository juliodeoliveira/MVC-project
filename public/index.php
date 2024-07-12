<style>
    input, textarea {
        display: block;
        margin: 10px;
    }
</style>
<form action="index.php" method="POST">
    <input type="text" name="enterpriseName" require placeholder="Nome da empresa *">
    <input type="email" name="email" require placeholder="Email *">
    <input type="tel" name="phone_number" id="telephone" placeholder="Telefone">
    <input type="text" name="cep" id="cep" placeholder="CEP">
    <input type="text" name="street" id="street" placeholder="Rua">
    <input type="text" name="nHouse" id="house" placeholder="Número da casa">
    <input type="text" name="neighbor" id="neightborhood" placeholder="Bairro">
    <input type="text" name="city" id="city" placeholder="Cidade">
    <input type="text" name="state" id="state" placeholder="Estado (UF)">
    <textarea name="complement" id="complement" placeholder="Complemento"></textarea>
    
    <input type="submit" value="Enviar">
</form>

<?php

use App\Controllers\blog\ClientController;
use App\Repositories\ClientRepository;
use App\Models\Client;

require "../bootstrap.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $rep = new ClientRepository();
    $controller = new ClientController();
    
    $newClient = new Client($_POST['enterpriseName'], $_POST['email']);
    
    $id = $rep->insert($newClient);

    $client = $rep->show($id); 

    // $controller->updateClient($newClient);

    // $update = $rep->update($newClient);

    dd($client);
} catch (\Exception $e) {
    dd($e -> getMessage());
}


// $method = new Method;
// $method = $method -> getMethod();

// $parameters = new Parameters;
// $parameters -> getParamethers();

// $controller -> $method($parameters);