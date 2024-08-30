<?php

use App\Models\Projects;

use App\Functions\URI;
$getClientIdByURI = URI::uriExplode();

use App\Controllers\ProjectsController;
$findProject = new ProjectsController();

$getProjects = $findProject->allProjects($getClientIdByURI[sizeof($getClientIdByURI)-1]);

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
</head>
<body>
    <h1>Resultado da busca por: <?=$_POST["searchProject"]?></h1>

    <form action="/search-projects/<?=$getClientIdByURI[sizeof($getClientIdByURI)-1]?>" method="post">
        <input type="text" name="searchProject" id="searchProject" placeholder="Pesquise seus projetos" value="<?=$_POST['searchProject']?>">
        <input type="submit" value="Pesquisar">
    </form>

    <hr>
    <?php
        $count = 0;
        foreach ($getProjects as $project) {
            if (searchProjects($project, $_POST["searchProject"])) {
                ?>
                    <h1>Título do projeto: <?=$project->getTitle()?></h1>
                    <ul>
                        <li>Data de início: <?=$project->getStartDate()?></li>
                        <li>Data de término: <?=$project->getEndDate()?></li>
                        <li>Serviço: <?=$project->getService()?></li>
                        <li>Descrição: <?=$project->getDescription()?></li>
                    </ul>
                    <hr>
                <?php
                $count++;
            }
        }

        if ($count == 0) {
            ?>
                <h2>Não foi encontrado nenhum resultado relacionado à pesquisa!</h2>
            <?php
        }
    ?>

</body>
</html>