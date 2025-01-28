<?php

use App\Models\Projects;

use App\Functions\URI;
$getClientIdByURI = URI::uriExplode();

use App\Controllers\ProjectsController;
$projectController = new ProjectsController();

use App\Controllers\PhotosController;
$photosController = new PhotosController();

use App\Functions\LoadEnv;

$getProjects = $projectController->allProjects($getClientIdByURI[sizeof($getClientIdByURI)-1]);

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
    <h1>Resultado da busca por: <?=$_POST["searchProject"]?></h1>

    <form action="/search-projects/<?=$getClientIdByURI[sizeof($getClientIdByURI)-1]?>" method="post" id="searchForm">
        <input type="text" name="searchProject" id="searchProject" placeholder="Pesquise seus projetos" value="<?=$_POST['searchProject']?>">
        <input type="submit" value="Pesquisar">
    </form>

    <hr>
    <?php

        $search = $_POST["searchProject"];
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

    <script src="http://<?=LoadEnv::fetchEnv('HOST')?>/assets/js/loadCarousel.js"/></script>
</body>
</html>