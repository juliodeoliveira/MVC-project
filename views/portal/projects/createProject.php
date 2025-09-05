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
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

</head>
<body>
    <h1>Criando um projeto novo</h1>
    <p><strong>ATENCÃO</strong>: Após 15 (quinze) dias depois do prazo do projeto, o mesmo será apagado!</p>
    <form action="/create/<?=$getIdbyURI?>" method="POST" id="signForm">
        <input type="text" required name="title"  id="title" placeholder="Título do projeto *">
        <textarea name="description" id="description" placeholder="Descrição"></textarea>

        <label for="startDate">Data de início: </label>
        <input type="date" required name="startDate" id="startDate">

        <label for="startDate">Data de término: </label>
        <input type="date" required name="endDate" id="endDate">

        <label for="userSelect">Usuário responsável pelo projeto:</label>
        <select id="userSelect" name="project_leaders[]" multiple>
            
            <?php
                $allUsers = new UserController;
                $allUsers = $allUsers->getAllUsers();
            ?>

            <?php foreach ($allUsers as $user): ?>
                <option value="<?= $user->getId() ?>">
                    <?= $user->getUsername() ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" required name="service" id="service" placeholder="Serviço *">
        <input type="submit" value="Enviar">


<!-- TODO: adicionar um campo que lista todos os usuários, e atribui um responsável -->
    </form>
    <script src="./../assets/js/validateCaracters.js"></script>
    <script>
      new TomSelect('#userSelect', {
        maxItems: null,
        create: false,
        persist: false
      });
    </script>
</body>
</html>
