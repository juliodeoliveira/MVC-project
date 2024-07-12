<?php

namespace App\Controllers\blog;

use App\Models\Client;
use App\Repositories\ClientRepository;


class ClientController
{
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