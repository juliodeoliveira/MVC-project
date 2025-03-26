<?php

namespace App\Models;

use DateTimeImmutable;

class Projects
{
    private string $title;
    private string $startDate;
    private string $endDate;
    private string $service;
    private string $status;
    
    private int $id;
    
    private ?string $description;
    private string $clientId;

    private DateTimeImmutable $createdAt;

    public function __construct(string $title, string $startDate, string $endDate, string $service)
    {
        $this->title = $title;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->service = $service;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string | null
    {
        return $this->description;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function setService(string $service): void
    {
        $this->service = $service;
    }

    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

}