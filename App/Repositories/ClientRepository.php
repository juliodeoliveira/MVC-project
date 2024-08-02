<?php

namespace App\Repositories;
use App\Connection;
use App\Models\Client;
use PDO;

class ClientRepository 
{
    private $connection;

    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
    }

    public function insert(Client $client): int
    {
        $insertValues = $this->connection->prepare("INSERT INTO customers (enterprise_name, email, phone_number, cep, street, house_number, complement, neighborhood, city, state) VALUES (:enterpriseName, :email, :phone_number, :cep, :street, :house_number, :complement, :neighborhood, :city, :state)");
        $insertValues->bindValue(":enterpriseName", $client->getEnterpriseName());
        $insertValues->bindValue(":email", $client->getEmail());
        $insertValues->bindValue(":phone_number", $client->getPhoneNumber());
        $insertValues->bindValue(":cep", $client->getCep());
        $insertValues->bindValue(":street", $client->getStreet());
        $insertValues->bindValue(":house_number", $client->getHouseNumber());
        $insertValues->bindValue(":complement", $client->getComplement());
        $insertValues->bindValue(":neighborhood", $client->getNeighborhood());
        $insertValues->bindValue(":city", $client->getCity());
        $insertValues->bindValue(":state", $client->getState());

        $insertValues->execute();

        return $this->connection->lastInsertId();
    }

    public function update(Client $client): void
    {
        $updateValues = $this->connection->prepare("UPDATE customers SET enterprise_name = :enterpriseName, email = :email, phone_number = :phoneNumber, cep = :cep, street = :street, house_number = :houseNumber, complement = :complement, neighborhood = :neighborhood, city = :city, state = :state WHERE id = :id");
        
        $updateValues->bindValue(":enterpriseName", $client->getEnterpriseName());
        $updateValues->bindValue(":email", $client->getEmail());
        $updateValues->bindValue(":phoneNumber", $client->getPhoneNumber());
        $updateValues->bindValue(":cep", $client->getCep());
        $updateValues->bindValue(":street", $client->getStreet());
        $updateValues->bindValue(":houseNumber", $client->getHouseNumber());
        $updateValues->bindValue(":complement", $client->getComplement());
        $updateValues->bindValue(":neighborhood", $client->getNeighborhood());
        $updateValues->bindValue(":city", $client->getCity());
        $updateValues->bindValue(":state", $client->getState());
        $updateValues->bindValue(":id", $client->getId());
        
        $updateValues->execute();
    }

    public function show(int $id): Client
    {
        $search = $this->connection->prepare("SELECT * FROM customers WHERE id = :id");
        $search->bindValue(":id", $id, PDO::PARAM_INT);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);

        // inserir todos os campos e depois retornar $client
        $client = new Client($result["enterprise_name"], $result["email"]);
        $client->setId($id);
        $client->setPhoneNumber($result['phone_number']);
        $client->setCep($result['cep']);
        $client->setStreet($result['street']);
        $client->setHouseNumber($result['house_number']);
        $client->setComplement($result['complement']);
        $client->setNeighbor($result['neighborhood']);
        $client->setCity($result['city']);
        $client->setState($result['state']);

        return $client;
    }

    public function all(): array
    {
        $search = $this->connection->prepare("SELECT * FROM customers");
        $search->execute();
        $result = $search->fetchAll(PDO::FETCH_ASSOC);

        $clients = [];
        foreach ($result as $row) {
            $client = new Client($row["enterprise_name"], $row["email"]);
            $client -> setId($row['id']);
            $client -> setPhoneNumber($row['phone_number']);
            $client -> setCep($row['cep']);
            $client -> setStreet($row['street']);
            $client -> setHouseNumber($row['house_number']);
            $client -> setComplement($row['complement']);
            $client -> setNeighbor($row['neighborhood']);
            $client -> setCity($row['city']);
            $client -> setState($row['state']);
            
            $clients[] = $client;
        }

        return $clients;
    }
}