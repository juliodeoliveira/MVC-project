<?php

namespace App\Models;

use DateTimeImmutable;

class Client
{
    private int $id;
    private string $enterpriseName;
    private string $email;
    private string $phoneNumber;
    
    private string $cep;
    private string $street;
    private string $houseNumber;
    private string $complement;
    private string $neighborhood;
    private string $city;
    private string $state;

    private DateTimeImmutable $createdAt;

    public function __construct(string $enterpriseName, string $email)
    {
        $this->enterpriseName = $enterpriseName;
        $this->email = $email;
    }
    
    public function getEnterpriseName(): string
    {
        return $this->enterpriseName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    //TODO: fazer set para todos os gets
}   