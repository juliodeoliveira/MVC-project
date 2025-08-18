<?php

use App\Controllers\UserController;
use App\Functions\URI;
$uriExplode = URI::uriExplode();
$getIdbyURI = (int) $uriExplode[sizeof($uriExplode)-1];

use App\Controllers\ProjectsController;
$project = new ProjectsController();
$project = $project->findProject($getIdbyURI);


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <style>
        input, textarea {
            display: block;
            margin: 10px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar novo projeto</title>
    
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
</head>
<body>
    <h1>Editando um projeto</h1>
    <p><strong>ATENCÃO</strong>: Após 15 (quinze) dias depois do prazo do projeto, o mesmo será apagado!</p>
    <form action="/project-edit/<?=$getIdbyURI?>" method="POST" id="signForm">
        <input type="text" required name="title" id="title" placeholder="Título do projeto *" value="<?=$project->getTitle()?>">
        <textarea name="description" id="description" placeholder="Descrição"><?=$project->getDescription()?></textarea>

        <label for="startDate">Data de início: </label>
        <input type="date" required name="startDate" id="startDate" value="<?=$project->getStartDate()?>">

        <label for="endDate">Data de término: </label>
        <input type="date" required name="endDate" id="endDate" value="<?=$project->getEndDate()?>">

        <label for="userSelect">Usuário responsável pelo projeto:</label>
        <select id="userSelect" name="project_leaders[]" multiple>
        <?php
            $allUsers = new UserController();
            $allUsers = $allUsers->getAllUsers();

            $selectedLeaders = $project->getLeaders(); 

            foreach ($allUsers as $user) {
                $username = $user->getUsername();
                $userId = $user->getId();

                $isSelected = in_array($username, $selectedLeaders) ? "selected" : "";

                echo "<option value='$userId' $isSelected>$username</option>";
            }
        ?>
        </select>

        <input type="text" required name="service" id="service" placeholder="Serviço *" value="<?=$project->getService()?>">
        <input type="submit" value="Enviar">
    </form>

    <script src="./../assets/js/validateCaracters.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
      new TomSelect('#userSelect', {
        maxItems: null,
        create: false,
        persist: false
      });
    </script>
</body>
</html>
