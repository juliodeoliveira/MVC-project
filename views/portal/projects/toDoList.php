<?php

use App\Controllers\ProjectsController;
use App\Controllers\TasksController;
use App\Functions\URI;

$uri = URI::uriExplode();
$projectID = $uri[sizeof($uri)-1];

session_start();
# Variable to reload the page to show the actual project status
$_SESSION["reloadPage"] = true;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tarefas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1 class="teste">lista de tarefas</h1>
    
    <input type="text" name="taskName" class="taskName">
    <button class="addTask">Adicionar tarefa</button>

    <input type="button" class="sendInfo" value="Salvar lista de tarefas">

    <div class="tasks">
        <?php

            $controller = new TasksController();

            $currentTasks = $controller->allTasks($projectID);

            $tasksToJson = [];

            foreach ($currentTasks as $tasks) {
                $description = $tasks->getTaskDescription();
                $isMarked = $tasks->getTaskMarked();
                $taskId = $tasks->getId();
                $tasksToJson[] = [
                    "id" => $taskId,
                    "description" => $description,
                    "checked" => $isMarked
                ]; 
                echo "<br>";
                if ($isMarked) {
                    echo "<input class='goal' type='checkbox' value='$description' checked>$description";
                } else {
                    echo "<input class='goal' type='checkbox' value='$description'>$description";
                }
            }

            $jsonTasks = json_encode($tasksToJson);
        ?>
    </div>

    <script>
        var tarefas = <?=$jsonTasks?> ?? [];
        $(".addTask").click(function(event) {
            var taskName = $(".taskName").val();
            $(".tasks").append(`<br><input type='checkbox' value='${taskName}' class='goal'>${taskName}<br>`);
            $(".taskName").val("");

            var newObject = {};

            <?php
                $lastId = $controller->lastTaskId();
            ?>
            var id = <?=$lastId + 1?>;
            console.log(id);
            $("input[type=checkbox]").each(function(index) {
                if ($(this).is(':checked')) {
                   newObject = {id: id, description: taskName, checked: true};
                } else {
                    newObject = {id: id, description: taskName, checked: false};
                }
                id++;
            });

            tarefas.push(newObject);

        });

        // var marked = 0
        $(".tasks").click(function(index) {

            $(".tasks > input[type=checkbox]").each(function(index) {
                if ($(this).is(":checked")) {
                    tarefas[index].checked = true;
                } else {
                    tarefas[index].checked = false;
                }
            });
        });
    </script>

    <?php 
        // Usado para pegar o valor de HOST logo abaixo
        use App\Functions\LoadEnv;
    ?>

    <script>
        $(".sendInfo").click(function() {
            $.ajax({
                url: 'http://<?=LoadEnv::fetchEnv("HOST")?>/save-todo/<?=$projectID?>',
                type: 'POST',
                data: { valor: JSON.stringify(tarefas) },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Seu trabalho foi salvo com sucesso!",
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Não foi possível salvar seu trabalho!",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    console.error('Erro na requisição:', status, error, tarefas);
                }
            });


        });
    </script>
</body>
</html>