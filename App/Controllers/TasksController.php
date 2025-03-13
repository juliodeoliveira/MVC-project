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
        $test = new TasksController();
        $tasks = $test->arrayMaker($projectId, $toDoList);

        foreach ($tasks as $task) {
            $insert = new TasksRepository();
            $insert->insertTask($task);
        }

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