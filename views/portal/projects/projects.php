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

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Projetos</title>
    <style>
        .carousel {
            position: relative;
            width: 600px;
            height: 400px;
            overflow: hidden;
            background-color: #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .carousel-images {
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel-images img {
            max-width: 100%;
            max-height: 100%;
            margin: auto;
            object-fit: contain;
            background-color: #eee;
            flex-shrink: 0;
            margin-left: 20px;
        }

        .carousel button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .carousel button:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .carousel button.prev {
            left: 10px;
        }

        .carousel button.next {
            right: 10px;
        }
    </style>
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
            dump($project);
            ?>
                <h1>Título do projeto: <?=$project->getTitle()?></h1>
                <li>Descrição: <?=$project->getDescription()?></li>
                <li>Data de início: <?=$project->getStartDate()?></li>
                <li>Data de término: <?=$project->getEndDate()?></li>
                <li>Serviço: <?=$project->getService()?></li>

                <h2>Fotos do projeto:</h2>
                <?php
                    
                    $allPhotos = $projectController->showPhotos($project->getId());
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

                <form action="/processPhoto" method="POST" enctype="multipart/form-data">
                    <label for="file-upload" class="custom-upload">
                        Adicione uma foto para o projeto!
                    </label>
                    <input type="hidden" name="projectIdPhoto" value="<?=$project->getId()?>">

                    <input type="file" id="file-upload" name="projectPhoto" accept=".jpg, .jpeg, .png, .gif">
                    <button type="submit">Enviar</button>
                </form>

                <a href="/to-do-list/<?=$project->getId()?>">Lista de tarefas</a>
                <hr>
            <?php
        }
        ?>
    </ul>

    <a href="/create-project/<?=$client->getId()?>">Criar projeto</a>

    //TODO: Colocar um hover e quando o mouse passar em cima ele mostra o botao de apagar a foto
    <script>
        // Function to initialize a carousel
        function initCarousel(carousel) {
            const imagesContainer = carousel.querySelector('.carousel-images');
            const images = imagesContainer.querySelectorAll('img');
            const prevButton = carousel.querySelector('.prev');
            const nextButton = carousel.querySelector('.next');

            let currentIndex = 0;

            function updateCarousel() {
                const offset = -currentIndex * 45;
                imagesContainer.style.transform = `translateX(${offset}%)`;
            }

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
                updateCarousel();
            });

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
                updateCarousel();
            });
        }

        // Inicializar todos os carrosséis na página
        document.querySelectorAll('.carousel').forEach(initCarousel);
    </script>
</body>
</html>