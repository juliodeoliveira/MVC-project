<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="shortcut icon" href="./assets/images/favicon/openfolder.png" type="image/x-icon">
</head>
<body>
    <h1>Lista de clientes cadastrados</h1>
    <form action="/search-clients/" method="GET">
        <input type="text" name="s" id="searchClients" placeholder="Pesquise por clientes">
        <input type="submit" value="Pesquisar">
    </form>

    <br>
    <a href="/">Voltar para a tela inicial</a>
    <ul>
        <?php
            use App\Controllers\ClientController;
            use App\Controllers\ProjectsController;
            use App\Controllers\UserController;

            $project = new ProjectsController();
            
            $listingClients = new ClientController();
            $allClients = $listingClients->allClients();
            dump($allClients);

            // TODO: pesquisar pelo nome de usuario, ja que nao repete (detalhe que eu tenho que modificar la no banco de dados), no banco de dados e retorna id para verificar suas permissoes...
            dump($_SESSION["usernameLogged"]);


            
            foreach ($allClients as $client) {
                dump($client->getId());

                ?>
                <h1>Nome da empresa: <?=$client->getEnterpriseName()?></h1>
                <h1>Email: <?=$client->getEmail()?></h1>
                <ul>
                    <li>N° de telefone: <?=$client->getPhoneNumber()?></li>
                    <li>CEP: <?=$client->getCep()?></li>
                    <li>Rua: <?=$client->getStreet()?></li>
                    <li>N° da casa: <?=$client->getHouseNumber()?></li>
                    <li>Complemento: <?=$client->getComplement()?></li>
                    <li>Bairro: <?=$client->getNeighborhood()?></li>
                    <li>Cidade: <?=$client->getCity()?></li>
                    <li>Estado: <?=$client->getState()?></li>
                    <a href="/editing/<?=$client->getId()?>">Editar informações</a>
                    <br>
                    <a href="/project/<?=$client->getId()?>">Ver <?=$project->countProjects($client->getId())?> projetos</a>
                    <br>
                    <a href="/client-report/<?=$client->getId()?>">Gerar relatório</a>
                </ul>
                
                <br>
                <hr>
                <br>
                <br>
                <br>
            <?php
            }
        ?>
    </ul>
</body>
</html>