<?php
namespace App\Models;

class ToDolist 
{
    private int $id;
    private int $taskProjectId;
    private string $taskDescription;
    private bool $taskMarked;

    public function __construct()
    {
        
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setTaskProjectId(int $projectId)
    {
        $this->taskProjectId = $projectId;
    }

    public function setTaskDescription(string $description)
    {
        $this->taskDescription = $description;
    }

    public function setTaskMarked(bool $marked)
    {
        $this->taskMarked = $marked;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getTaskProjectId()
    {
        return $this->taskProjectId;
    }

    public function getTaskDescription()
    {
        return $this->taskDescription;
    }

    public function getTaskMarked()
    {
        return $this->taskMarked;
    }
}