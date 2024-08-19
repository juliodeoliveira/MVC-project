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

        <?php 
            // TODO: Essa função deve estar em uma daquelas classes na pasta /Functions/
            
        ?>

        <select name="state" id="state">
            <option value="<?=$client->getState()?>"><?=StateValidation::replaceState($client->getState())?></option>
            <option value="AC">Acre - AC</option>
            <option value="AL">Alagoas - AL</option>
            <option value="AP">Amapá - AP</option>
            <option value="AM">Amazonas - AM</option>
            <option value="BA">Bahia - BA</option>
            <option value="CE">Ceará - CE</option>
            <option value="ES">Espírito Santo - ES</option>
            <option value="GO">Goiás - GO</option>
            <option value="MA">Maranhão - MA</option>
            <option value="MT">Mato Grosso - MT</option>
            <option value="MS">Mato Grosso do Sul - MS</option>
            <option value="MG">Minas Gerais - MG</option>
            <option value="PA">Pará - PA</option>
            <option value="PE">Pernambuco - PE</option>
            <option value="PI">Piauí - PI</option>
            <option value="RJ">Rio de Janeiro - RJ</option>
            <option value="RN">Rio Grande do Norte - RN</option>
            <option value="RS">Rio Grande do Sul - RS</option>
            <option value="RO">Rondônia - RO</option>
            <option value="RR">Roraima - RR</option>
            <option value="SC">Santa Catarina - SC</option>
            <option value="SP">São Paulo - SP</option>
            <option value="SE">Sergipe - SE</option>
            <option value="TO">Tocantins - TO</option>
        </select>
        
        <br>

        <label for="complement">Complemento:</label>
        <textarea name="complement" id="complement" placeholder="Complemento"><?=$client->getComplement()?></textarea>
        
        <input type="submit" value="Editar">
    </form>  
     
    <script>
        const phoneNumberInput = document.getElementById("telephone");
        phoneNumberInput.addEventListener('input', function(event) {
            let phoneNumber = phoneNumberInput.value.replace(/\D/g, '');
            let formattedNumber = "";

            if (phoneNumber.length > 0) {
                formattedNumber += "(" + phoneNumber.substring(0, 2);
            }

            if (phoneNumber.length >= 3) {
                formattedNumber += ") " + phoneNumber.substring(2, 7);
            }

            if (phoneNumber.length >= 8) {
                formattedNumber += "-" + phoneNumber.substring(7, 11);
            }

            phoneNumberInput.value = formattedNumber;
        });

        const cepInput = document.getElementById("cep");
        cepInput.addEventListener("input", function(event) {
            let cepValue = cepInput.value.replace(/\D/g, '');
            let formattedCep = "";
            
            if (cepValue.length > 5) {
                formattedCep += cepValue.substring(0, 5) + "-" + cepValue.substring(5, 8);
            } else {
                formattedCep = cepValue;
            }

            cepInput.value = formattedCep;
        });

        function sanitizeInput(input) {
            return input.replace(/[`~!@#$%*()_|+\=?;:'"<>\{\}\[\]\\\/]/gi, '');
        }

        const enterpriseNameInput = document.getElementById("enterprisename");
        enterpriseNameInput.addEventListener('input', function(event) {
            enterpriseNameInput.value = sanitizeInput(enterpriseNameInput.value);
        });

        const emailInput = document.getElementById("email");
        emailInput.addEventListener('input', function(event) {
            emailInput.value = emailInput.value.replace(/[`~!#$%*()\[\]_|+\=?;:'"<>\{\}\[\]\\\/]/gi, '');
        });

        const streetInput = document.getElementById("street");
        streetInput.addEventListener('input', function(event) {
            streetInput.value = sanitizeInput(streetInput.value);
        });

        const houseNumberInput = document.getElementById("house");
        houseNumberInput.addEventListener('input', function(event) {
            houseNumberInput.value = sanitizeInput(houseNumberInput.value);
        });

        const neighInput = document.getElementById("neightborhood");
        neighInput.addEventListener('input', function(event){
            neighInput.value = sanitizeInput(neighInput.value);
        });

        const cityInput = document.getElementById("city");
        cityInput.addEventListener('input', function(event) {
            cityInput.value = sanitizeInput(cityInput.value);
        });

        const complementInput = document.getElementById("complement");
        complementInput.addEventListener('input', function(event) {
            complementInput.value = sanitizeInput(complementInput.value);
        });   
    </script>
</body>
</html>