<?php

use App\Controllers\UserController;
use App\Functions\URI;
$uriExplode = URI::uriExplode();
$getIdbyURI = (int) $uriExplode[sizeof($uriExplode)-1];

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
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
</head>
<body>
    <h1>Criando um projeto novo</h1>
    <p><strong>ATENCÃO</strong>: assim que a data de término chegar o projeto será apagado!</p>
    <form action="/create/<?=$getIdbyURI?>" method="POST" id="signForm">
        <input type="text" require name="title" required id="title" placeholder="Título do projeto *">
        <textarea name="description" id="description" placeholder="Descrição"></textarea>

        <label for="startDate">Data de início: </label>
        <input type="date" require name="startDate" id="startDate">

        <label for="startDate">Data de término: </label>
        <input type="date" require name="endDate" id="endDate">

        

        <label for="userSelect"></label>
        <select id="userSelect" name="project_leaders[]" multiple>
            <?php
                $allUsers = new UserController;
                $allUsers = $allUsers->getAllUsers();
                foreach ($allUsers as $user) {
                    $username = $user->getUsername();
                    $userId = $user->getId();
                    echo "<option value='$userId'>$username</option>";
                    //dump();
                }
            ?>
        </select>

        <input type="text" require name="service" id="service" placeholder="Serviço *">
        <input type="submit" value="Enviar">


<!-- TODO: adicionar um campo que lista todos os usuários, e atribui um responsável -->
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
