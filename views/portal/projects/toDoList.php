<?php

use App\Functions\URI;
$uri = URI::uriExplode();
$projectID = $uri[sizeof($uri)-1];

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
    </div>

    <script>
        var tarefas = [];
        $(".addTask").click(function(event) {
            var taskName = $(".taskName").val();
            $(".tasks").append(`<input type='checkbox' value='${taskName}' class='goal'>${taskName}`);
            $(".taskName").val("");

            var newObject = {};
            $("input[type=checkbox]").each(function(index) {
                if ($(this).is(':checked')) {
                   newObject = {name: taskName, checked: true};
                    
                    // console.log(`checkbox marcado ${index}: `, $(this).val());
                } else {
                    newObject = {name: taskName, checked: false};
                    // console.log('checkbox não marcado', $(this).val());
                }
            });

            tarefas.push(newObject);

        });

        // var marked = 0
        $(".tasks").click(function(index) {

            $(".tasks > input[type=checkbox]").each(function(index) {
                if ($(this).is(":checked")) {
                    // console.log(`i; ${index}, v: ${$(this).val()} [marked]`);
                    tarefas[index].checked = true;
                }
                else {
                    // console.log(`i; ${index}, v: ${$(this).val()}`);
                    tarefas[index].checked = false;
                }
            });

            // console.log("Tarefas marcadas: ", marked);
        });
    </script>

    <script>
        // TODO: descomentar depois
        $(".sendInfo").click(function() {
            //console.log(JSON.stringify(tarefas));
            // TODO: Caso não se torne uma boa opção escrever tudo em um campo da tabela em JSON, só crie outra tabela com clunas: id, id_projeto(FK) e tarefas (JSON)

            // $.ajax({
            //     url: '/save-todo/<?=$projectID?>', // enviar para a página que salva
            //     type: "POST", 
            //     data: {tasks: tarefas},
            //     success: function(response) {
            //         console.log("Response: ", response);
            //     },
            //     error: function (xhr, status, error) {
            //         console.error("Error: ", status, error);
            //     }
            // });

            $.ajax({
                url: 'http://localhost:5500/save-todo/<?=$projectID?>', // Verifique se o URL está correto
                type: 'POST',
                data: { valor: JSON.stringify(tarefas) }, // Verifique os dados enviados
                success: function(response) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', status, error);
                }
            });


        });
    </script>
</body>
</html>