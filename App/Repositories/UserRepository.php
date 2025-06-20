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
        // $insert->bindValue(":role", $user->getRoles());
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

    public function findEmail(string $userEmail): User | null
    {
        $find = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $find->bindValue(":email", $userEmail);
        $find->execute();
        $result = $find->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $foudedUser = new User($result["username"], $result["email"], $result["password"]);
        $foudedUser->setId($result["id"]);

        return $foudedUser;
    }

    public function findUserName(string $userName): User
    {
        $find = $this->connection->prepare("SELECT * FROM users WHERE username = :username");
        $find->bindValue(":username", $userName);
        $find->execute();
        $result = $find->fetch(PDO::FETCH_ASSOC);

        $foudedUser = new User($result["username"], $result["email"], $result["password"]);
        $foudedUser->setId($result["id"]);
        return $foudedUser;
    }

    public function userHasPermission($userId, $permissionName): bool 
    {
        $query = $this->connection->prepare("
            SELECT COUNT(*) AS total
            FROM user_permission up
            JOIN permissions p ON up.permission_id = p.id
            WHERE up.user_id = :userId AND p.name = :permissionName
        ");

        $query->bindValue(":userId", $userId);
        $query->bindValue(":permissionName", $permissionName);

        $query->execute();

        return $query->fetchColumn() > 0;
    }

    public function getAllUsersPermissions()
    {
        $permissions = $this->connection->prepare("
            SELECT 
                u.id AS user_id,
                u.username,
                u.email,
                p.name AS permission
            FROM users u
            LEFT JOIN user_permission up ON u.id = up.user_id
            LEFT JOIN permissions p ON up.permission_id = p.id
            ORDER BY u.id;
        ");

        $permissions->execute();
        $results = $permissions->fetchAll(PDO::FETCH_ASSOC);

        $usersList = [];
        foreach ($results as $user) {
            
            $userId = $user["user_id"];
            if (!isset($usersList[$userId])) {                
                $newUser = new User($user["username"], $user["email"], "password");
                $newUser->setId($user["user_id"]);

                $usersList[$userId] = $newUser;
            }

            if (!is_null($user['permission'])) {
                $usersList[$userId]->addPermission($user['permission']);
            }
        }

        $usersList = array_values($usersList);

        return $usersList;
    }

    public function allPermissionsNames(): array
    {
        $query = $this->connection->prepare("SELECT name FROM permissions");
        $query->execute();        

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function permissionsInfo() {
        $query = $this->connection->prepare("SELECT * FROM permissions");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUserPermissions(int $userId, array $permissionsIds)
    {
        $this->connection->beginTransaction();

        //TODO: deu problema! nao atualiza nada na pagina admin, ta editando uma tabela que n tem relacao nenhuma! a pagina de admin nao pesquisa NADA na user_permission
        try {
            $query = $this->connection->prepare("DELETE FROM user_permission WHERE user_id = :userId");
            $query->bindValue(":userId", $userId);
            $query->execute();

            $query = $this->connection->prepare("INSERT INTO user_permission (user_id, permission_id) VALUES (:userId, :permissionId)");
            foreach ($permissionsIds as $permissionId) {
                $query->bindValue(":userId", $userId);
                $query->bindValue(":permissionId", $permissionId);
                $query->execute();
            }

            $this->connection->commit();

        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}