<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
</head>
<body>
    <h1>Lista de clientes cadastrados</h1>
    <a href="/">Voltar para a tela inicial</a>
    <ul>
        <?php
            use App\Controllers\ClientController;
            use App\Functions\DatabaseTreat;
            
            $listingClients = new ClientController();
            $allClients = $listingClients->showClients();
            foreach ($allClients as $clients) {
                foreach ($clients as $key => $value) {
                    echo DatabaseTreat::fieldName($key, $value);
                }
                echo "<br>";
                dump("<a href='/editing/$clients[id]'>Editar informações</a>");

                echo "<a href='/editing/$clients[id]'>Editar informações</a>";
                echo "<hr>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
            }
            
        ?>

    </ul>
</body>
</html>