<?php
use App\Functions\URI;
$getClientIdByURI = URI::uriExplode();

use App\Models\Client;

use App\Controllers\ClientController;
$findClient = new ClientController();

$allClients = $findClient->allClients();

function searchClient(Client $client, $haystack) {
    if (str_contains($client->getEnterpriseName(), $haystack) || str_contains($client->getEmail(), $haystack) || str_contains($client->getPhoneNumber(), $haystack) || str_contains($client->getCep(), $haystack) || str_contains($client->getStreet(), $haystack) || str_contains($client->getHouseNumber(), $haystack) || str_contains($client->getComplement(), $haystack) || str_contains($client->getNeighborhood(), $haystack) || str_contains($client->getCity(), $haystack) || str_contains($client->getState(), $haystack)) {
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
    <title>Document</title>
</head>
<body>
    <h1>Resultados da busca: <?=$_POST["searchClients"]?></h1>

    <form action="/search-clients/<?=$getClientIdByURI[sizeof($getClientIdByURI)-1]?>" method="post">
        <input type="text" name="searchClients" id="searchProject" placeholder="Pesquise seus projetos" value="<?=$_POST['searchClients']?>">
        <input type="submit" value="Pesquisar">
    </form>
    <hr>
    <?php
        $count = 0;
        foreach ($allClients as $client) {
            if (searchClient($client, $_POST["searchClients"])) {
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
                </ul>
                <?php
                $count++;
            }
        }

        if ($count == 0) {
            ?>
                <h2>Não foi encontrado nenhum resultado para a pesquisa</h2>
            <?php
        }
        dump($allClients);
    ?>
</body>
</html>