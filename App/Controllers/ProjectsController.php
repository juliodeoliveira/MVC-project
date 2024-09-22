<?php

namespace App\Controllers;

use App\Repositories\ProjectsRepository;

use App\Models\Projects;
use App\Models\ToDolist;

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

     public function saveToDoList(int $projectId, array $toDoList) {
          echo "Reached the controller!";

          $project = new ToDolist();

          
          // $project = new ProjectsRepository();
          
     }
}