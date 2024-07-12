<?php

namespace App\Models;

use DateTimeImmutable;

class Client
{
    private int $id;
    private string $enterpriseName;
    private string $email;
    private ?string $phoneNumber;
    
    private ?string $cep;
    private ?string $street;
    private ?string $houseNumber;
    private ?string $complement;
    private ?string $neighborhood;
    private ?string $city;
    private ?string $state;

    // ? isso vai ser trocado por um set?
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

    public function getPhoneNumber(): string | null
    {
        return $this->phoneNumber ?? null;
    }

    public function getCep(): string | null
    {
        return $this->cep ?? null;
    }

    public function getStreet(): string | null
    {
        return $this->street ?? null;
    }

    public function getHouseNumber(): string | null
    {
        return $this->houseNumber ?? null;
    }

    public function getComplement(): string | null
    {
        return $this->complement ?? null;
    }  

    public function getNeighborhood(): string | null
    {
        return $this->neighborhood ?? null;
    }

    public function getCity(): string | null
    {
        return $this->city ?? null;
    }

    public function getState(): string | null
    {
        return $this->state ?? null;
    }


    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setEnterpriseName(string $enterpriseName): void
    {
        $this->enterpriseName = $enterpriseName;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->$phoneNumber = $phoneNumber;
    }

    public function setCep(string $cep): void
    {
        $this->cep = $cep;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function setHouseNumber(string $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }

    public function setComplement(string $complement): void
    {
        $this->complement = $complement;
    }

    public function setNeighbor(string $neighborhood): void
    {
        $this->neighborhood = $neighborhood;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }
    
    public function setState(string $state): void
    {
        $this->state = $state;
    }
}   