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
          $projectRepository = new ProjectsRepository();

          $teste = $projectRepository->show($project->getId());
          // dump($project->getEndDate());
          // dump("Atual: " . date('Y-m-d'));
          
          if ($project->getEndDate() < date('Y-m-d')) {
               // TODO: aqui ele vai ser deletado, mas caso nao seja desejado, adicionar um botao para que quando o prazo vencer, adicionar mais 30 dias de prazo
               $projectRepository->delete($project);
               header("Location: /project/" . $project->getClientId());
          } else {

               $actualDate = new \DateTime(date('Y-m-d'));
               $finalDate = new \DateTime($project->getEndDate());
               
               $days = $actualDate->diff($finalDate)->days;
               return $days > 1 ? $days . " dias" : $days . " dia";
          }
     }
}