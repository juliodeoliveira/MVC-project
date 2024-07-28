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
        use App\Models\Client;
        use App\Repositories\ClientRepository;

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uriExplode = explode("/", "$uri");

        // Acredito que seja melhor usar um método do clontroller
        $selectClient = new ClientRepository();
        $clientInfo = $selectClient->show($uriExplode[sizeof($uriExplode)-1]);
        dump($clientInfo);
    ?>

    <form action="/edit/<?=$uriExplode[sizeof($uriExplode)-1]?>" method="POST">

        <label for="enterprisename">Nome da empresa:</label>
        <input value="<?=$clientInfo["enterprise_name"]?>" type="text" name="enterpriseName" required id="enterprisename" placeholder="Nome da empresa *">

        <label for="email">E-mail:</label>
        <input value="<?=$clientInfo["email"]?>" type="email" name="email" required id="email" placeholder="Email *">

        <label for="telephone">Telefone:</label>
        <input value="<?=$clientInfo["phone_number"]?>" type="text" name="phone_number" id="telephone" placeholder="Telefone">

        <label for="cep">CEP:</label>
        <input value="<?=$clientInfo["cep"]?>" type="text" name="cep" id="cep" placeholder="CEP">

        <label for="street">Rua:</label>
        <input value="<?=$clientInfo["street"]?>" type="text" name="street" id="street" placeholder="Rua">

        <label for="house">Número da casa:</label>
        <input value="<?=$clientInfo["house_number"]?>" type="text" name="nHouse" id="house" placeholder="Número da casa">

        <label for="neighborhood">Bairro:</label>
        <input value="<?=$clientInfo["neighborhood"]?>" type="text" name="neighbor" id="neightborhood" placeholder="Bairro">

        <label for="city">Cidade:</label>
        <input value="<?=$clientInfo["city"]?>" type="text" name="city" id="city" placeholder="Cidade">

        <label for="state">Estado:</label>
        <input value="<?=$clientInfo["state"]?>" type="text" name="state" id="state" placeholder="Estado (UF)">

        <label for="complement">Complemento:</label>
        <textarea name="complement" id="complement" placeholder="Complemento"><?=$clientInfo["complement"]?></textarea>
        
        <input type="submit" value="Editar">
    </form>
    <!-- // todo: Passar os atributos aqui e atualizar por meio da classe
        new Controleller(nome email)    
        setState(state)
        ... 
    -->
   
</body>
</html>