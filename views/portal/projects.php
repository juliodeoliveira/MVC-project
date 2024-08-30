<?php

use App\Repositories\ClientRepository;
$clientRepo = new ClientRepository;

use App\Functions\URI;
$uriExplode = URI::uriExplode();
$getIdbyURI = (int) $uriExplode[sizeof($uriExplode)-1];

use App\Controllers\ClientController;
$findClient = new ClientController();
$client = $findClient->findClients($getIdbyURI);

use App\Models\Projects;

use App\Controllers\ProjectController;
$projectController = new ProjectController();

$allProjects = $projectController->allProjects($getIdbyURI);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
</head>
<body>
    <h1>Projetos de <?=$client->getEnterpriseName()?></h1>

   <ul>

   <?php
    foreach ($allProjects as $project) {
        dump($project);
        ?>
            <h1>Título do projeto: <?=$project->getTitle()?></h1>
            <li>Descrição: <?=$project->getDescription()?></li>
            <li>Data de início: <?=$project->getStartDate()?></li>
            <li>Data de término: <?=$project->getEndDate()?></li>
            <li>Serviço: <?=$project->getService()?></li>
            <hr>
        <?php
    }

    ?>

    </ul>
    <a href="/create-project/<?=$client->getId()?>">Criar projeto</a>
</body>
</html>