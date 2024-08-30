<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="shortcut icon" href="./assets/images/favicon/openfolder.png" type="image/x-icon">
</head>
<body>
    <h1>Lista de clientes cadastrados</h1>
    <a href="/">Voltar para a tela inicial</a>
    <ul>
        <?php
            use App\Controllers\ClientController;
            
            $listingClients = new ClientController();
            $allClients = $listingClients->allClients();
            dump($allClients);
            
            foreach ($allClients as $clients) {
                dump($clients->getId());

                ?>
                <h1>Nome da empresa: <?=$clients->getEnterpriseName()?></h1>
                <h1>Email: <?=$clients->getEmail()?></h1>
                <ul>
                    <li>N° de telefone: <?=$clients->getPhoneNumber()?></li>
                    <li>CEP: <?=$clients->getCep()?></li>
                    <li>Rua: <?=$clients->getStreet()?></li>
                    <li>N° da casa: <?=$clients->getHouseNumber()?></li>
                    <li>Complemento: <?=$clients->getComplement()?></li>
                    <li>Bairro: <?=$clients->getNeighborhood()?></li>
                    <li>Cidade: <?=$clients->getCity()?></li>
                    <li>Estado: <?=$clients->getState()?></li>
                    <a href="/editing/<?=$clients->getId()?>">Editar informações</a>
                    <br>
                    <a href="/project/<?=$clients->getId()?>">Ver projetos</a>
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