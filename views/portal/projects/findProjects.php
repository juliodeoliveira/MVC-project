<?php

use App\Models\Projects;

use App\Functions\URI;
$getClientIdByURI = URI::uriExplode();

use App\Controllers\ProjectsController;
$projectController = new ProjectsController();

use App\Controllers\PhotosController;
$photosController = new PhotosController();

use App\Functions\LoadEnv;

$ID_POSITION = 2;
$clientId = $getClientIdByURI[sizeof($getClientIdByURI)-$ID_POSITION];

$getProjects = $projectController->allProjects($clientId);

function searchProjects(Projects $project, $haystack) {
    if (str_contains($project->getTitle(), $haystack) || str_contains($project->getStartDate(), $haystack) || str_contains($project->getEndDate(), $haystack) || str_contains($project->getService(), $haystack) || str_contains($project->getClientId(), $haystack) || str_contains($project->getDescription(), $haystack)) {
        return true;
    }
    return false;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encontre seus projetos aqui!</title>
    <link rel="stylesheet" href="http://<?=LoadEnv::fetchEnv('HOST')?>/assets/css/carroussel.css">
</head>
<body>
    <h1>Resultado da busca por: <?=$_GET["s"]?></h1>

    <form action="/search-projects/<?=$clientId?>/" method="GET" id="searchForm">
        <input type="text" name="s" id="searchProject" placeholder="Pesquise seus projetos" value="<?=$_GET['s']?>">
        <input type="submit" value="Pesquisar">
    </form>

    <a href="/project/<?=$clientId?>">Voltar</a>

    <hr>
    <?php

        $search = $_GET["s"];
        $results = array_filter($getProjects, function ($project) use ($search) {
            return searchProjects($project, $search);
        });

        if (!empty($results)) {
            foreach ($results as $project) {
                $checkDays = $projectController->checkProjectDeadline($project);
                ?>                
                    <h1>Título do projeto: <?=$project->getTitle()?></h1>
                    <ul>
                    <li>Descrição: <?=$project->getDescription()?></li>
                    <li>Data de início: <?=$project->getStartDate()?></li>
                    <li>Data de término: <?=$project->getEndDate()?></li>
                    <li>Serviço: <?=$project->getService()?></li>
                    <li>Status: <?=$projectController->checkProjectStatus($project)?></li>
                    <li>Prazo: <?=$checkDays["deadline"] == "late" ? $checkDays["days"]. " dias atrasados" : $checkDays["days"] . " dias"?></li>

                    <h2>Fotos do projeto:</h2>

                    <?php
                        $allPhotos = $photosController->showPhotos($project->getId());
                        if (count($allPhotos) == 0) {
                            echo "<p>O projeto ainda não tem nenhuma foto!</p>";
                        } else {
                            $carouselId = "carousel-" . $project->getId();
                            echo "<div class='carousel' id='$carouselId'>
                                    <div class='carousel-images'>";
                            foreach ($allPhotos as $photo) {
                                // Remove the dot from the original path
                                $treatedPath = "http://" . LoadEnv::fetchEnv("HOST") . substr($photo["photo_path"], 1);
                                echo "<img src='$treatedPath' alt='$photo[photo_name]'>";
                            }
                            echo "</div>
                                    <button class='prev'>&#10094;</button>
                                    <button class='next'>&#10095;</button>
                                </div>";
                        }
                    ?>
                    
                    <form id="imageSubmit" action="/process-photo" method="POST" enctype="multipart/form-data">
                        <label for="file-upload" class="custom-upload">
                            Adicione uma foto para o projeto!
                        </label>

                        <!-- // TODO: Para maior seguranca, adicionar um js que quando o formulario for enviado ele troca o valor do input para o que precisa ser, o valor padrao e em js e valor que deve ser vem em php -->
                        <input type="hidden" name="projectIdPhoto" value="<?=$project->getId()?>">

                        <input type="hidden" name="job" value="insert">

                        <input type="file" id="file-upload" name="projectPhoto" accept=".jpg, .jpeg, .png, .gif">
                        <button type="submit">Enviar</button>
                    </form>

                    <a href="/to-do-list/<?=$project->getId()?>">Lista de tarefas</a>

                    </ul>
                    <hr>
                <?php
            }
        } else {
            ?>
                <h2>Não foi encontrado nenhum resultado relacionado à pesquisa!</h2>
            <?php
        }
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://<?=LoadEnv::fetchEnv('HOST')?>/assets/js/loadCarousel.js"/></script>

    <script>
        window.addEventListener("pageshow", function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>