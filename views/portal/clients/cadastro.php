<!DOCTYPE html>
<html lang="pt-BR">
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
    <link rel="shortcut icon" href="./assets/images/favicon/closedfolder.png" type="image/x-icon">
</head>
<body>

<!-- //! Estado deve ser select, depois implementação de API dos correios para preencher campos com base no CEP --> 
    <form action="/sign-client" method="POST" id="signForm">
        <!-- //TODO: Aqui, para melhorar a usabilidade, deve ser feito com que cada input seja mostrado por vez na tela,
                preencheu um, próximo input como se fosse uma troca de página, um input por vez -->
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
            <?php
                $states = json_decode(file_get_contents("./../config/json/states.json"), true);
                foreach ($states as $options) {
                    echo "<option value='$options[UF]'>$options[Nome] - $options[UF]</option>";
                }
            ?>
        </select>
        <textarea name="complement" id="complement" placeholder="Complemento"></textarea>
        <input type="submit" value="Enviar">
    </form>

  <script src="./assets/js/validateCaracters.js"></script>
</body>
</html>
