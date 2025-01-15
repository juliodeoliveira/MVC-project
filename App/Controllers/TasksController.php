<?php
namespace App\Controllers;

use App\Repositories\TasksRepository;

use App\Models\Projects;
use App\Models\ToDoList;

class TasksController
{
    // This name's supposed to be temporary
    public function arrayMaker(int $projectId, array $todolist)
    {
        $tasksObject = [];
        foreach ($todolist as $task) {
            //var_dump($task);
            $projectTask = new ToDolist();
            $projectTask->setId($task["id"]);
            $projectTask->setTaskProjectId($projectId);
            $projectTask->setTaskDescription($task["description"]);
            $projectTask->setTaskMarked($task["checked"]);

            $tasksObject[] = $projectTask;
        }

        return $tasksObject;
    }

    public function saveToDoList(int $projectId, array $toDoList)
    {
        // $project = new ToDoList();
        // echo "ID do projeto: $projectId\n";

        $test = new TasksController();
        $tasks = $test->arrayMaker($projectId, $toDoList);
        //var_dump($tasks);

        // there is no validation, not even a single one
        foreach ($tasks as $task) {
            $insert = new TasksRepository();
            $insert->insertTask($task);
        }

        // First things first add a insert method, then one to find and other other to get all task
        // I can have an array of objects
        // insert -> see -> update

        // var_dump("List de Tarefas: ");
        // var_dump($toDoList);

    }

    public function allTasks($projectId) {
        $currentTasks = new TasksRepository();
        $currentTasks = $currentTasks->showAllTasks($projectId);
        return $currentTasks;
    }

    public function lastTaskId(): int
    {
        $getLast = new TasksRepository();
        return $getLast->lastTaskId();
    }
}