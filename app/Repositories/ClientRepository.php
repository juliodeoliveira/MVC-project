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
        $insertValues = $this->connection->prepare("INSERT INTO customers (enterprise_name, email) VALUES (:enterpriseName, :email)");
        $insertValues->bindValue(":enterpriseName", $client->getEnterpriseName());
        $insertValues->bindValue(":email", $client->getEmail());
        $insertValues->execute();

        return $this->connection->lastInsertId();
    }

    public function update(Client $client)
    {
        $updateValues = $this->connection->prepare("UPDATE customers SET enterprise_name = :enterpriseName, email = :email, phone_number = :phoneNumber, cep = :cep, street = :street, house_number = :houseNumber, complement = :complement, neighborhood = :neighborhood, city = :city, state = :state");
        
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

        $updateValues->execute();
    }

    public function delete()
    {

    }

    public function show(int $id): Client
    {
        $search = $this->connection->prepare("SELECT * FROM customers WHERE id = :id");
        $search->bindValue(":id", $id);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);

        $client = new Client($result["enterprise_name"], $result["email"]);
        $client->setId($id);

        return $client;
    }

    public function all()
    {

    }
}