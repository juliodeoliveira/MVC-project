<?php

use App\Controllers\ProjectsController;
use App\Functions\URI;
use App\Repositories\ProjectsRepository;
$uri = URI::uriExplode();
$projectID = $uri[sizeof($uri)-1];

// TODO: tem um erro quando eu marco uma tarefa como feita e quando ela volta, nao mostra a tarefa marcada e duplica 

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
            $currentTasks = new ProjectsRepository();
            $currentTasks = $currentTasks->showAllTasks($projectID);

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

            dump($tasksToJson);
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
            var id = 1;
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

            // console.log("Tarefas marcadas: ", marked);
        });
    </script>

    <script>
        $(".sendInfo").click(function() {
            // TODO: Caso não se torne uma boa opção escrever tudo em um campo da tabela em JSON, só crie outra tabela com clunas: id, id_projeto(FK) e tarefas (JSON)

            $.ajax({
                url: 'http://localhost:5500/save-todo/<?=$projectID?>', // Verifique se o URL está correto
                type: 'POST',
                data: { valor: JSON.stringify(tarefas) }, // Verifique os dados enviados
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', status, error, tarefas);
                }
            });


        });
    </script>
</body>
</html>