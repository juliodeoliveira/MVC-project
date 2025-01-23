<?php
namespace App\Models;

class ToDoList 
{
    private int $id;
    private int $taskProjectId;
    private string $taskDescription;
    private bool $taskMarked;

    public function __construct()
    {
        
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTaskProjectId(int $projectId): void
    {
        $this->taskProjectId = $projectId;
    }

    public function setTaskDescription(string $description): void
    {
        $this->taskDescription = $description;
    }

    public function setTaskMarked(bool $marked): void
    {
        $this->taskMarked = $marked;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getTaskProjectId(): int
    {
        return $this->taskProjectId;
    }

    public function getTaskDescription(): string
    {
        return $this->taskDescription;
    }

    public function getTaskMarked(): bool
    {
        return $this->taskMarked;
    }
}