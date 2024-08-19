<!DOCTYPE html>
<html lang="pt-br">
<head>
    <style>
        input, textarea {
            display: block;
            margin: 10px;
        }
    </style>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de cliente</title>
</head>
<body>

<!-- //! Estado deve ser select, depois implementação de API dos correios para preencher campos com base no CEP --> 
    <form action="/sign-client" method="POST" id="signForm">
        <input type="text"  name="enterpriseName" required id="enterprisename" placeholder="Nome da empresa *">
        <input type="email" name="email" required id="email" placeholder="Email *">
        <input type="text" name="phone_number" id="telephone" placeholder="Telefone">
        <input type="text" name="cep" id="cep" placeholder="CEP" maxlength="9">
        <input type="text" name="street" id="street" placeholder="Rua">
        <input type="text" name="nHouse" id="house" placeholder="Número da casa">
        <input type="text" name="neighbor" id="neightborhood" placeholder="Bairro">
        <input type="text" name="city" id="city" placeholder="Cidade">
        <!-- <input type="text" name="state" id="state" placeholder="Estado (UF)"> -->
        <select name="state" id="state" placeholde="Selecione o estado">
            <option value="">Selecione o estado: </option>
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
        <textarea name="complement" id="complement" placeholder="Complemento"></textarea>
        
        <input type="submit" value="Enviar">
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

        const cep = document.getElementById("cep");
        cep.addEventListener("input", function(event) {
            let cepValue = cep.value.replace(/\D/g, '');
            let formattedCep = "";
            
            if (cepValue.length > 5) {
                formattedCep += cepValue.substring(0, 5) + "-" + cepValue.substring(5, 8);
            } else {
                formattedCep = cepValue;
            }

            cep.value = formattedCep;
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
