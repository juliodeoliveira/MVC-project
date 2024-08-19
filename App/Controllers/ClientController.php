<?php

namespace App\Controllers;

use App\Functions\SigninValidation;
use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Functions\StateValidation;

class ClientController
{

    public function signClient(): void 
    {
        $newClient = new Client($_POST['enterpriseName'], $_POST['email']);
        $newClient->setPhoneNumber($_POST["phone_number"]);
        $newClient->setCep($_POST["cep"]);
        $newClient->setStreet($_POST["street"]);
        $newClient->setHouseNumber($_POST["nHouse"]);
        $newClient->setNeighbor($_POST["neighbor"]);
        $newClient->setCity($_POST["city"]);
        $newClient->setComplement($_POST["complement"]);
        
        SigninValidation::validate($newClient);

        if (StateValidation::validate($_POST["state"])) {
            $newClient->setState($_POST["state"]);
        } else {
            $newClient->setState("");
        }

        $repository = new ClientRepository();
        $repository->insert($newClient);
    }

    public function updateClient(Client $client): void 
    {
        $newClient = new Client(
            $_POST["enterpriseName"] ?? $client->getEnterpriseName(), 
            $_POST["email"] ?? $client->getEmail()
        );

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uriExplode = explode("/", "$uri");

        $newClient->setId($uriExplode[sizeof($uriExplode)-1]);
        $newClient->setPhoneNumber($_POST["phone_number"]);
        $newClient->setCep($_POST["cep"]);
        $newClient->setStreet($_POST["street"]);
        $newClient->setHouseNumber($_POST["nHouse"]);
        $newClient->setNeighbor($_POST["neighbor"]);
        $newClient->setCity($_POST["city"]);
        $newClient->setState($_POST["state"]);
        $newClient->setComplement($_POST["complement"]);
        
        $model = new ClientRepository();
        $update = $model->update($newClient);
    }

    public function allClients(): array
    {
        $showClients = new ClientRepository();
        $clientsObject = $showClients->all();
        return $clientsObject;
    }

    public function findClients($id): Client | null
    {
        $getClient = new ClientRepository();
        $clients = $getClient->show($id);

        return $clients;
    }
}
