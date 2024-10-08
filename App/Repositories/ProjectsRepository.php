<?php

namespace App\Repositories;

namespace App\Repositories;
use App\Connection;
use App\Models\Projects;
use App\Models\ToDoList;
use PDO;

class ProjectsRepository
{
    private $connection;

    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
    }

    public function insert(Projects $project): int
    {
        $insertProject = $this->connection->prepare("INSERT INTO projects (title, description, start_date, end_date, service, customer_id) VALUES (:title, :description, :startDate, :endDate, :service, :customer_id);");
        $insertProject->bindValue(":title", $project->getTitle());
        $insertProject->bindValue(":description", $project->getDescription());
        $insertProject->bindValue(":startDate", $project->getStartDate());
        $insertProject->bindValue(":endDate", $project->getEndDate());
        $insertProject->bindValue(":service", $project->getService());
        $insertProject->bindValue(":customer_id", $project->getClientId());

        $insertProject->execute();

        return $this->connection->lastInsertId();

    }

    public function update()
    {

    }

    public function show(int $id): Projects | null
    {
        $search = $this->connection->prepare("SELECT * FROM projects WHERE customer_id = :id");
        $search->bindValue(":id", $id, PDO::PARAM_INT);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        $project = new Projects($result['title'], $result['start_date'], $result['end_date'], $result['service']);
        $project->setId($result['id']);
        $project->setDescription($result['description']);
        $project->setClientId($result['customer_id']);

        return $project;
    }

    public function all(int $clientId): array
    {
        $search = $this->connection->prepare("SELECT * FROM projects WHERE customer_id = :id");
        $search->bindValue(":id", $clientId, PDO::PARAM_INT);
        $search->execute();
        $result = $search->fetchAll(PDO::FETCH_ASSOC);

        $projects = [];
        foreach ($result as $row) {
            $project = new Projects($row["title"], $row["start_date"], $row["end_date"], $row["service"]);
            $project->setId($row['id']);
            $project->setDescription($row['description']);
            $project->setClientId($row['customer_id']);
            
            $projects[] = $project;
        }

        return $projects;
    }

    public function saveToDo(int $projectId, array $toDoList) 
    {
        // if se no indice checked do arrya  ta diferente do que tava, pega o select que vai ter o valor antigo
        
        $save = $this->connection->prepare("UPDATE project_tasks SET task_description = :description, task_status = :checked WHERE task_project_id = :projectId");
        foreach ($toDoList as $todo) {
        //     $save->bindValue(":descripton", $todo["name"]);
        // //    $save->bindValue("");
        //     $save->bindValue(":checked", $todo["checked"] ? 'true' : 'false');
        //     $save->execute();
        }  
    }

    public function insertTask(ToDoList $list)
    {
        $insert = $this->connection->prepare("INSERT INTO project_tasks VALUES (0, :projectId, :taskDescription, :taskStatus)");
        $insert->bindValue(":projectId", $list->getTaskProjectId());
        $insert->bindValue(":taskDescription", $list->getTaskDescription());
        // suposed to be temporary
        $insert->bindValue(":taskStatus", $list->getTaskMarked() ? 1 : 0);
        $insert->execute();

    }

    public function showAllTasks(int $projectId)
    {
        $all = $this->connection->prepare("SELECT * FROM project_tasks WHERE task_project_id = :projectId");
        $all->bindValue(":projectId", $projectId);
        $all->execute();
        $result = $all->fetchAll(PDO::FETCH_ASSOC);

        $tasks = [];
        foreach ($result as $task) {
            $taskObject = new ToDoList();
            $taskObject->setId($task["id"]);
            $taskObject->setTaskProjectId($task["task_project_id"]);
            $taskObject->setTaskDescription($task["task_description"]);
            $taskObject->setTaskMarked($task["task_status"]);

            $tasks[] = $taskObject;
        }
        return $tasks;
    }
}