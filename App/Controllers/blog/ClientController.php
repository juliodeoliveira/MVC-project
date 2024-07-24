<?php

namespace App\Controllers\blog;

use App\Models\Client;
use App\Repositories\ClientRepository;


class ClientController
{

    public function signClient() {
        $newClient = new Client($_POST['enterpriseName'], $_POST['email']);
        $newClient->setPhoneNumber($_POST["phone_number"]);
        $newClient->setCep($_POST["cep"]);
        $newClient->setStreet($_POST["street"]);
        $newClient->setHouseNumber($_POST["nHouse"]);
        $newClient->setNeighbor($_POST["neighbor"]);
        $newClient->setCity($_POST["city"]);
        $newClient->setState($_POST["state"]);
        $newClient->setComplement($_POST["complement"]);

        $repository = new ClientRepository();
        $repository->insert($newClient);
    }

    public function updateClient(Client $client) {
        $newClient = new Client(
            $_POST["name"] ?? $client->getEnterpriseName(), 
            $_POST["email"] ?? $client->getEmail()
        );

        $model = new ClientRepository();
        $update = $model->update($client);

        // $client->setPhoneNumber($client->getPhoneNumber());

        //* Manda para o repositório em seguida
    }
}