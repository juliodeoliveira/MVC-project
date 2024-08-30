<?php

namespace App\Controllers;

use App\Repositories\ProjectsRepository;

use App\Models\Projects;

class ProjectController
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
}