<?php

namespace App\Repositories;

use App\Connection;
use App\Models\ToDoList;
use PDO;

class TasksRepository
{
    private $connection;

    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
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

        if (in_array($list->getId(), $idOnly)) {

            // TODO: isso pode ser a funcao saveToDo
            $updateTask = $this->connection->prepare("UPDATE project_tasks SET task_status = :isMarked WHERE id = :taskId");
            $updateTask->bindValue(":isMarked", $list->getTaskMarked() ? 1 : 0);
            $updateTask->bindValue(":taskId", $list->getId());
            $updateTask->execute();
            
        } else {
            $newId = $list->getId()+1;

            $insert = $this->connection->prepare("INSERT INTO project_tasks (id, task_project_id, task_description, task_status) VALUES (:taskId, :projectId, :taskDescription, :taskStatus)");
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
}