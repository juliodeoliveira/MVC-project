<?php

namespace App\Repositories;

namespace App\Repositories;
use App\Connection;
use App\Models\Photos;
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

    public function insertTask(ToDoList $list): void
    {
        //! Preciso de pegar os id e os status de cada, mas tem como fazer isso sem que volte um objeto e sem precisar criar um array aqui?
        // select com where id = id, ja que assim ve se existe id e se o status desse id é diferente.
        $selectID = $this->connection->prepare("SELECT id, task_status FROM project_tasks");
        $selectID->execute();
        $result = $selectID->fetchAll(PDO::FETCH_ASSOC);

        $idOnly = array_column($result, "id");

        // TODO: O problema disso é que vai "atualizar" tudo, já que se eu apenas marcar uma tarefa como feita, todas as outras ainda vao existir, REFATORAR DEPOIS

        //! preciso pegar um id diferente, já que projetos diferentes vao ter um id comecando com 0 aí da problema la na hora de escrever na tabela
        if (in_array($list->getId(), $idOnly)) {
            $updateTask = $this->connection->prepare("UPDATE project_tasks SET task_status = :isMarked WHERE id = :taskId");
            $updateTask->bindValue(":isMarked", $list->getTaskMarked() ? 1 : 0);
            $updateTask->bindValue(":taskId", $list->getId());
            $updateTask->execute();
            
        } else {
            $insert = $this->connection->prepare("INSERT INTO project_tasks VALUES (:taskId, :projectId, :taskDescription, :taskStatus)");
            $insert->bindValue(":taskId", $list->getId());
            $insert->bindValue(":projectId", $list->getTaskProjectId());
            $insert->bindValue(":taskDescription", $list->getTaskDescription());

            // suposed to be temporary
            $insert->bindValue(":taskStatus", $list->getTaskMarked() ? 1 : 0);
            $insert->execute();
        }
    }

    public function showAllTasks(int $projectId): array
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

    public function lastTaskId() 
    {
        $lastId = $this->connection->prepare("SELECT id FROM project_tasks ORDER BY id DESC LIMIT 1");
        $lastId->execute();
        $result = $lastId->fetchColumn();
        return $result;
    }

    public function addProjectPhoto(Photos $photos): void 
    {   
        $add = $this->connection->prepare("INSERT INTO project_pictures VALUES (0, :projectId, :photoName, :photoDescription, :photoPath);");
        $add->bindValue(":projectId", $photos->getProjectId());
        $add->bindValue(":photoName", $photos->getPhotoName());
        $add->bindValue(":photoDescription", $photos->getPhotoName());
        $add->bindValue(":photoPath", $photos->getNewPhotoPath());
        $add->execute();
    }

    public function showProjectPhotos(int $projectId)
    {
        $search = $this->connection->prepare("SELECT photo_path, photo_name FROM project_pictures WHERE project_id = :projectId");
        $search->bindValue(":projectId", $projectId);
        $search->execute();
        $result = $search->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}