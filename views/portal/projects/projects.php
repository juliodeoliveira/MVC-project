<?php

use App\Functions\LoadEnv;

use App\Repositories\ClientRepository;
$clientRepo = new ClientRepository;

use App\Functions\URI;
$uriExplode = URI::uriExplode();
$getIdbyURI = (int) $uriExplode[sizeof($uriExplode)-1];

use App\Controllers\ClientController;
$findClient = new ClientController();
$client = $findClient->findClients($getIdbyURI);

use App\Models\Projects;

use App\Controllers\ProjectsController;
$projectController = new ProjectsController();
$allProjects = $projectController->allProjects($getIdbyURI);

use App\Controllers\PhotosController;
$photosController = new PhotosController();

use App\Controllers\DocumentController;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Projetos</title>
    <link rel="stylesheet" href="http://<?=LoadEnv::fetchEnv('HOST')?>/assets/css/carroussel.css">
    <link rel="stylesheet" href="http://<?=LoadEnv::fetchEnv('HOST')?>/assets/css/documentList.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Projetos de <?=$client->getEnterpriseName()?></h1>

    <form action="/search-projects/<?=$client->getId()?>" method="post">
        <input type="text" name="searchProject" id="searchProject" placeholder="Pesquise seus projetos">
        <input type="submit" value="Pesquisar">
    </form>

   <ul>
    <?php
        foreach ($allProjects as $project) {
            
            $checkDays = $projectController->checkProjectDeadline($project);
            
            ?>
                <h1>Título do projeto: <?=$project->getTitle()?></h1>
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
                            $treatedPath = "http://" . LoadEnv::fetchEnv("HOST") . substr($photo->getNewPhotoPath(), 1);
                            echo "<img src='$treatedPath' alt='$photo->getPhotoName()'>";
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
                    <button type="submit">Enviar foto</button>

                </form>

                <form action="/process-document" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="projectIdDocument" value="<?=$project->getId()?>">
                    <input type="file" accecpt=".txt, .pdf, .docx" name="projectDocument" id="project-document">
                    <button type="submit">Enviar documento</button>
                </form>

                <?php 
                    $documents = new DocumentController();
                    $documents = $documents->showDocuments($project->getId());
                    if (count($documents) > 0) {
                        ?>
                        <div class="container">
                            <ul class="lista-documentos">
                                <?php
                                foreach ($documents as $document) {
                                    ?>
                                        <li class="documento-item"><?=$document->getDocumentName()?></li>
                                        <a href="/download/?file=<?php echo urlencode($document->getNewDocumentPath()); ?>" class="botao-download">Baixar</a>
                                    <?php
                                }
                                ?>
                                <input type="hidden" name="projectIdDocument" value="<?=$project->getId()?>">
                            </ul>
                        </div>
                        <?php
                    }
                ?>
                

                <a href="/to-do-list/<?=$project->getId()?>">Lista de tarefas</a>
                <hr>
            <?php
        }
        ?>
    </ul>

    <a href="/create-project/<?=$client->getId()?>">Criar projeto</a>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://<?=LoadEnv::fetchEnv('HOST')?>/assets/js/loadCarousel.js"></script>
    
</body>
</html>