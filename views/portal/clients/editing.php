<?php
    use App\Controllers\ClientController;
    use App\Functions\URI;
    use App\Functions\StateValidation;

    $uriExplode = URI::uriExplode();
    $getIdbyURI = $uriExplode[sizeof($uriExplode)-1];

    $findClient = new ClientController();
    $client = $findClient->findClients($getIdbyURI);

    if (empty($client)) {
        header("Location: /notfound :(");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
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

    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/components/_wizard.css">

    <link rel="shortcut icon" href="localhost:5500/../assets/images/favicon/closedfolder.png" type="image/x-icon">
</head>
<body>

<h1>Edite as informações</h1>
    <form action="/edit/<?=$getIdbyURI?>" method="POST" id="wizard-form">
        <!-- Bolinhas do wizard -->
        <div id="wizard-nav" class="wizard-nav"></div>
        
        <div class="slide active">
            <input type="text" name="enterpriseName" value="<?=$client->getEnterpriseName()?>" required placeholder="Nome da empresa *">
        </div>

        <div class="slide">
            <input type="email" name="email" value="<?=$client->getEmail()?>" required placeholder="E-mail *">
        </div>

        <div class="slide">
            <input type="text" name="phone_number" value="<?=$client->getPhoneNumber()?>" placeholder="Telefone">
        </div>

        <div class="slide">
            <input type="text" name="cep" value="<?=$client->getCep()?>" placeholder="CEP">
        </div>

        <div class="slide">
            <input type="text" name="street" value="<?=$client->getStreet()?>" placeholder="Rua">
        </div>

        <div class="slide">
            <input type="text" name="nHouse" value="<?=$client->getHouseNumber()?>" placeholder="Número da casa">
        </div>

        <div class="slide">
            <input type="text" name="neighbor" value="<?=$client->getNeighborhood()?>" placeholder="Bairro">
        </div>

        <div class="slide">
            <input type="text" name="city" value="<?=$client->getCity()?>" placeholder="Cidade">
        </div>

        <div class="slide">
            <select name="state">
                <option value="<?=$client->getState()?>"><?=StateValidation::replaceState($client->getState())?></option>
                <?php $states = json_decode(file_get_contents("./../config/json/states.json"), true); ?>
                <?php foreach ($states as $options): ?>
                    <option value='<?= $options["UF"] ?>'><?= $options["Nome"] ?> - <?= $options["UF"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="slide">
            <textarea name="complement" placeholder="Complemento"><?=$client->getComplement()?></textarea>
        </div>

        <!-- Botões de navegação -->
        <div class="wizard-buttons">
            <button type="button" id="prevBtn">← Anterior</button>
            <button type="button" id="nextBtn">Próximo →</button>
            <button type="submit" id="submitBtn">Salvar</button>
        </div>
    </form>



         <script src="/assets/js/formWizard.js"></script>

    <script src="./../assets/js/validateCaracters.js"></script>
</body>
</html>
