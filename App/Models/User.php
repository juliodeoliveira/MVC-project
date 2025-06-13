<?php

namespace App\Models;

class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    // Todo: role precisa receber uma string e adicionar um array que vai ter todas as permissoes
    //! $roles nao vai mais usar array...
    private string $role;
    private array $permissions = [];

    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function getPassword(): string 
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }

    public function addPermission(string $permission): void {
        if (!in_array($permission, $this->permissions)) {
            $this->permissions[] = $permission;
        }
    }
}