<?php

namespace App\Controllers;

use App\Repositories\ProjectsRepository;

use App\Models\Projects;
use App\Models\ToDoList;
use App\Models\Photos;

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

     public function checkProjectDeadline(Projects $project)
     {
          
          $actualDate = new \DateTime(date('Y-m-d'));
          $finalDate = new \DateTime($project->getEndDate());
          
          // TODO: Trocar essas chaves de arrays por Interfaces
          if ($project->getEndDate() < date('Y-m-d')) {
               $lateDays = $actualDate->diff($finalDate)->days;
               if ($lateDays > 15) {
                    $projectRepository = new ProjectsRepository();
                    $projectRepository->delete($project);

                    $projectDocuments = new DocumentController();
                    $projectDocuments->deleteAllDocuments($project->getId());

                    $projectPhoto = new PhotosController();
                    $projectPhoto->deleteAllPhotos($project->getId());
                    
                    return ["days" => "", "deadline" => "deleted"];
               }

               return ["days" => $lateDays, "deadline" => "late"];

          } else {               
               $days = $actualDate->diff($finalDate)->days;
               return ["days" => $days, "deadline" => "early"];
          }
     }

     public function countProjects(int $clientId): int
     {
          $projects = $this->allProjects($clientId);
          $counter = 0;

          foreach ($projects as $project) {
               //! Needs to update in realtime, so the number appears correclty and delete a project
               $deadline = $this->checkProjectDeadline($project);
               if ($deadline["deadline"] != "deleted") {
                    $counter += 1;
               }
          }
          
          return $counter;
     }
}