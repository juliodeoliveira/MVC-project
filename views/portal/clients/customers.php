<?php
    use App\Controllers\ClientController;
    use App\Controllers\ProjectsController;
    use App\Controllers\UserController;

    $project = new ProjectsController();
    
    $listingClients = new ClientController();
    $allClients = $listingClients->allClients();
    // dump($allClients);

    // TODO: pesquisar pelo nome de usuario, ja que nao repete (detalhe que eu tenho que modificar la no banco de dados), no banco de dados e retorna id para verificar suas permissoes...
    // dump($_SESSION["usernameLogged"]);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/pages/clients.css">

    <link rel="shortcut icon" href="./assets/images/favicon/openfolder.png" type="image/x-icon">
</head>

<body>
    <a href="/" class="back-btn">🏠 Voltar</a>
    <div class="search-bar">
        <form action="/search-clients/" method="GET" class="search-form">
            <input type="text" name="s" placeholder="Pesquise por clientes">
            <input type="submit" value="Pesquisar">
        </form>
    </div>

    <div class="clients-container">
        <?php foreach ($allClients as $client): ?>
            <div class="card">
                <h2><?= $client->getEnterpriseName() ?></h2>
                <p>Email: <?= $client->getEmail() ?></p>
                <ul>
                    <li>N° de telefone: <?= $client->getPhoneNumber() ?: "N/A" ?></li>
                    <li>CEP: <?= $client->getCep() ?: "N/A" ?></li>
                    <li>Rua: <?= $client->getStreet() ?: "N/A" ?></li>
                    <li>N° da casa: <?= $client->getHouseNumber() ?: "N/A" ?></li>
                    <li>Complemento: <?= $client->getComplement() ? $client->getComplement() : "N/A" ?></li>
                    <li>Bairro: <?= $client->getNeighborhood() ? $client->getNeighborhood() : "N/A" ?></li>
                    <li>Cidade: <?= $client->getCity() ? $client->getCity() : "N/A" ?></li>
                    <li>Estado: <?= $client->getState() ? $client->getState() : "N/A" ?></li>
                </ul>
                <a class="btn small" href="/editing/<?= $client->getId() ?>">✏️ Editar informações</a>
                <a class="btn small" href="/project/<?= $client->getId() ?>">👁️ Ver <?= $project->countProjects($client->getId()) ?> projetos</a>
                <a class="btn small" href="/client-report/<?= $client->getId() ?>">📄 Gerar relatório</a>
            </div>
        <?php endforeach ?>
    </div>
</body>

</html>
