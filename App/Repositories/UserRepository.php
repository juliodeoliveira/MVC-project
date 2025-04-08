<?php

namespace App\Repositories;

use App\Connection;
use PDO;
use App\Models\User;

class UserRepository
{
    private $connection;
    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
    }

    public function insert(User $user): void
    {
        $insert = $this->connection->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $insert->bindValue(":username", $user->getUsername());
        $insert->bindValue(":email", $user->getEmail());
        $insert->bindValue(":password", $user->getPassword());
        // $insert->bindValue(":role", $user->getRole());
        $insert->execute();
    }

    public function usernameExists(User $user): bool
    {
        $search = $this->connection->prepare("SELECT username FROM users WHERE username = :username");
        $search->bindValue(":username", $user->getUsername());
        $search->execute();
        
        $registeredUser = $search->fetchColumn();

        if (strtolower($registeredUser) == strtolower($user->getUsername())) {
            return true;
        } else {
            return false;
        }
    }

    public function emailExists(User $user) 
    {
        $search = $this->connection->prepare("SELECT email FROM users WHERE email = :email");
        $search->bindValue(":email", $user->getEmail());
        $search->execute();
        
        $registeredUser = $search->fetchColumn();

        if (strtolower($registeredUser) == strtolower($user->getEmail())) {
            return true;
        } else {
            return false;
        }
    }
}