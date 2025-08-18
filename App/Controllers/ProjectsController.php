<?php

namespace App\Controllers;

use App\Repositories\ProjectsRepository;
use App\Repositories\TasksRepository;

use App\Models\Projects;

class ProjectsController
{
     public function findProject(int $id): Projects | null
     {
          $project = new ProjectsRepository();
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

          // TODO: Aqui tem que adicionar a funcao para escrever na tabela de project_leaders

          $newProject = new Projects($_POST['title'], $_POST["startDate"], $_POST["endDate"], $_POST["service"]);
          $newProject->setDescription($_POST["description"]);
          $newProject->setClientId($customerId);
          $newProject->setStatus("Não iniciado");
            
          $repository = new ProjectsRepository();
          $lastId = $repository->insert($newProject);
          $newProject->setId($lastId);
          
          // $userId = new ();
          //? acredito que seja melhor criar um método apenas para pegar informacoes de usuário
          // $userId = AuthMiddleware::verifyAuth();
          
          foreach ($_POST["project_leaders"] as $leader) {
              $repository->addLeader($newProject->getId(), (int) $leader);
          }
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

     public function checkProjectStatus(Projects $project)
     {
          //TODO: escrever quando ele foi concluido, no arquivo log, mas acho que seria interessante para o relatorio
          // ia ser muito foda tambem se eu retornasse algo como se um aviso, "olha, voce nao adicionou uma lista de tarefas!", nao só para as tarefas
          $getMarked = new TasksRepository();

          $ratio = $getMarked->tasksRatio($project->getId());

          $updateStatus = new ProjectsRepository();

          if ($ratio["total_tasks"] > $ratio["done_tasks"] && $ratio["done_tasks"] > 0) {
               $updateStatus->projectStatusOngoing($project->getId());
               $project->setStatus("Em andamento");
          } else if ($ratio["total_tasks"] == $ratio["done_tasks"] && $ratio && $ratio["total_tasks"] > 0) {
               $updateStatus->projectStatusDone($project->getId());
               $project->setStatus("Concluído");
          } else {
               $updateStatus->projectStatusNotStarted($project->getId());
               $project->setStatus("Não iniciado");
          }
     }

     public function updateProject(Projects $project): void
     {
          //! Aqui eu tenho que tomar cuidado pra nao apagar informacoes que nao devem ser apagadas, como as obriogatorias aqui desses argumentos
          // TODO: instanciar o Projects la na view, antes de ser editado é uma solucao para ter os dados antigos ainda
          // dd(empty($_POST["title"]));
          $newProject = new Projects(
               empty($_POST["title"]) ? $project->getTitle() : $_POST["title"],
               empty($_POST["startDate"]) ? $project->getStartDate() : $_POST["startDate"],
               empty($_POST["endDate"]) ? $project->getEndDate() : $_POST["endDate"],
               empty($_POST["service"]) ? $project->getService() : $_POST["service"],
          );

          $uriExplodes = explode('/', $_SERVER['REQUEST_URI']);
          $getIdbyURI = end($uriExplodes);

          
          $newProject->setId($getIdbyURI);
          $newProject->setLeaders($_POST["project_leaders"] ?? []);
          $newProject->setDescription($_POST["description"]);

          $updateProject = new ProjectsRepository();
          $updateProject->update($newProject);

          $updateProject->clearLeaders($getIdbyURI);

          if (!empty($_POST["project_leaders"])) {
               foreach ($_POST["project_leaders"] as $leader) {
                   $updateProject->addLeader($newProject->getId(), (int) $leader);
               }
          }

     }
}
