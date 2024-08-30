<?php

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
</head>
<body>
    <h1>Criando um projeto novo</h1>
    <form action="/create/<?=$getIdbyURI?>" method="POST" id="signForm">
        <input type="text" require name="title" required id="title" placeholder="Título do projeto *">
        <textarea name="description" id="description" placeholder="Descrição"></textarea>

        <label for="startDate">Data de início: </label>
        <input type="date" require name="startDate" id="startDate">

        <label for="startDate">Data de término: </label>
        <input type="date" require name="endDate" id="endDate">

        <input type="text" require name="service" id="service" placeholder="Serviço *">
        <input type="submit" value="Enviar">
    </form>
    <script src="./../assets/js/validateCaracters.js"></script>
</body>
</html>