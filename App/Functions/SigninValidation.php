<?php

namespace App\Functions;
use App\Models\Client;

class SigninValidation 
{
    public static function validate(Client $client)
    {
        $client->setEnterpriseName(preg_replace("/[^a-zA-Z0-9]+/", "", $client->getEnterpriseName()));
        $client->setEmail(preg_replace("/[^a-zA-Z0-9@.]+/", "", $client->getEmail()));
        $client->setPhoneNumber(preg_replace("/[^a-zA-Z0-9]+/", "", $client->getPhoneNumber()));
        $client->setCep(preg_replace("/[^a-zA-Z0-9-]+/", "", $client->getCep()));
        $client->setStreet(preg_replace("/[^a-zA-Z0-9.]+/", "", $client->getStreet()));
        $client->setHouseNumber(preg_replace("/[^a-zA-Z0-9]+/", "", $client->getHouseNumber()));
        $client->setComplement(preg_replace("/[^a-zA-Z0-9]+/", "", $client->getComplement()));
        $client->setNeighbor(preg_replace("/[^a-zA-Z0-9.]+/", "", $client->getNeighborhood()));
        $client->setCity(preg_replace("/[^a-zA-Z0-9]+/", "", $client->getCity()));
        $client->setState(preg_replace("/[^a-zA-Z0-9]+/", "", $client->getState()));
    }
}