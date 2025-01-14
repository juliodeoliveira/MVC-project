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

          $test = new ProjectsController();
          $tasks = $test->arrayMaker($projectId, $toDoList);
          //var_dump($tasks);

          // there is no validation, not even a single one
          foreach ($tasks as $task) {
               $insert = new ProjectsRepository();
               $insert->insertTask($task);
          }

          // First things first add a insert method, then one to find and other other to get all task
          // I can have an array of objects
          // insert -> see -> update

          // var_dump("List de Tarefas: ");
          // var_dump($toDoList);

     }

     public function allTasks($projectId) {
          $currentTasks = new ProjectsRepository();
          $currentTasks = $currentTasks->showAllTasks($projectId);
          return $currentTasks;
     }

     public function lastTaskId(): int
     {
          $getLast = new ProjectsRepository();
          return $getLast->lastTaskId();
     }

     // Images
     public function processPhoto(): void
     {

          //TODO: se o nome da foto ja existe no banco de dados ela nao deve ser inserida

          // This path refers to public, the folder that you required in the command php -S localhost -t public
          $destinyFolder = "./assets/projectPhotos/$_POST[projectIdPhoto]";
          if (!file_exists($destinyFolder)) {
               mkdir($destinyFolder, 0777, true);
          }

          $getId = new ProjectsRepository();
          $lastPhotoId = $getId->lastPhotoId() + 1;
          $_FILES['projectPhoto']['name'] = $lastPhotoId. "_" . basename($_FILES['projectPhoto']['name']);

          $tempName = $_FILES['projectPhoto']['tmp_name'];
          $finalDestiny = $destinyFolder . "/" . $_FILES['projectPhoto']['name'];
          
          move_uploaded_file($tempName, $finalDestiny);

          $photos = new Photos($_FILES['projectPhoto']['name'], $finalDestiny, (int) $_POST["projectIdPhoto"]);

          $addPhoto = new ProjectsRepository();
          $addPhoto->addProjectPhoto($photos);
     }

     public function showPhotos(int $projectId): array 
     {
          $photos = new ProjectsRepository();
          return $photos->showProjectPhotos($projectId);
     }

     public function deletePhoto(string $imageSrc) 
     {
          $id = strpos(basename($imageSrc), "_");
          $photoId = (int) substr(basename($imageSrc), 0, $id);

          $deletePhoto = new ProjectsRepository();
          $deletePhoto->deletePhoto($photoId);

          unlink(str_replace("http://localhost:5500", ".", $imageSrc));
     }
}