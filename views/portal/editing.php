<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de informações</title>
    <style>
        input, textarea {
            display: block;
            margin: 10px;
        }
    </style>
</head>
<body>
<h1>Edite as informações</h1>
    <?php
        use App\Controllers\ClientController;
        use App\Functions\URI;

        $uriExplode = URI::uriExplode();
        $getIdbyURI = $uriExplode[sizeof($uriExplode)-1];

        $findClient = new ClientController();
        $client = $findClient->findClients($getIdbyURI);
    ?>

    <form action="/edit/<?=$getIdbyURI?>" method="POST">

        <label for="enterprisename">Nome da empresa:</label>
        <input value="<?=$client->getEnterpriseName()?>" type="text" name="enterpriseName" required id="enterprisename" placeholder="Nome da empresa *">

        <label for="email">E-mail:</label>
        <input value="<?=$client->getEmail()?>" type="email" name="email" required id="email" placeholder="Email *">

        <label for="telephone">Telefone:</label>
        <input value="<?=$client->getPhoneNumber()?>" type="text" name="phone_number" id="telephone" placeholder="Telefone">

        <label for="cep">CEP:</label>
        <input value="<?=$client->getCep()?>" type="text" name="cep" id="cep" placeholder="CEP">

        <label for="street">Rua:</label>
        <input value="<?=$client->getStreet()?>" type="text" name="street" id="street" placeholder="Rua">

        <label for="house">Número da casa:</label>
        <input value="<?=$client->getHouseNumber()?>" type="text" name="nHouse" id="house" placeholder="Número da casa">

        <label for="neighborhood">Bairro:</label>
        <input value="<?=$client->getNeighborhood()?>" type="text" name="neighbor" id="neightborhood" placeholder="Bairro">

        <label for="city">Cidade:</label>
        <input value="<?=$client->getCity()?>" type="text" name="city" id="city" placeholder="Cidade">

        <label for="state">Estado:</label>
        <input value="<?=$client->getState()?>" type="text" name="state" id="state" placeholder="Estado (UF)">

        <label for="complement">Complemento:</label>
        <textarea name="complement" id="complement" placeholder="Complemento"><?=$client->getComplement()?></textarea>
        
        <input type="submit" value="Editar">
    </form>   
</body>
</html>