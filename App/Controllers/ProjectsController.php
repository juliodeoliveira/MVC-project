<?php

namespace App\Controllers;

use App\Repositories\ProjectsRepository;

use App\Models\Projects;
use App\Models\ToDoList;

class ProjectsController
{
     public function findProject(int $id): Projects | null
     {
          $project = new ProjectsRepository;
          $find = $project->show($id);
          
          return $find;
     }

     public function allProjects(int $clientId): array | null
     {
          $project = new ProjectsRepository();
          $allProjects = $project->all($clientId);
          
          return $allProjects;
     } 

     public function createProject(int $customerId): void
     {
          if (empty($_POST['title']) || empty($_POST["startDate"]) || empty($_POST["endDate"]) || empty($_POST["service"])) {
               header('Location: /');
               exit();
          }

          $newProject = new Projects($_POST['title'], $_POST["startDate"], $_POST["endDate"], $_POST["service"]);
          $newProject->setDescription($_POST["description"]);
          $newProject->setClientId($customerId);

          $repository = new ProjectsRepository();
          $repository->insert($newProject);
     }

     // This name's supposed to be temporary
     public function arrayMaker(int $projectId, array $todolist)
     {
          $tasksObject = [];
          foreach ($todolist as $task) {
               $projectTask = new ToDolist();
               $projectTask->setId(0);
               $projectTask->setTaskProjectId($projectId);
               $projectTask->setTaskDescription($task["name"]);
               $projectTask->setTaskMarked($task["checked"]);

               $tasksObject[] = $projectTask;
          }

          return $tasksObject;
     }

     public function saveToDoList(int $projectId, array $toDoList)
     {
          // $project = new ToDoList();
          // echo "ID do projeto: $projectId\n";
          $test = new ProjectsController();
          $tasks = $test->arrayMaker($projectId, $toDoList);
          //var_dump($tasks);

          // there is no validation, not even a single one
          foreach ($tasks as $task) {
               $insert = new ProjectsRepository();
               $insert->insertTask($task);
          }

          echo "Inserted! Finally!\n";


          // First thing first add a insert method, then one to find and other other to get all task
          // I can have an array of objects
          // insert -> see -> update

          // var_dump("List de Tarefas: ");
          // var_dump($toDoList);

     }
}