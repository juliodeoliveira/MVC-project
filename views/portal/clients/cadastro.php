<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- <style>
        input, textarea {
            display: block;
            margin: 10px;
        }
    </style> -->

    <!-- TODO: validar aqui e mostrar os erros, quando eu coloco uma informacao errada ele só para a página -->
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de cliente</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/components/_wizard.css">
    

    <link rel="shortcut icon" href="./assets/images/favicon/closedfolder.png" type="image/x-icon">
</head>
<body>

<!-- //! Estado deve ser select, depois implementação de API dos correios para preencher campos com base no CEP --> 
    <form action="/write-client" method="POST" id="wizard-form">
        <div class="wizard-nav" id="wizard-nav"></div>

        <div class="slide active"><input type="text" name="enterpriseName" required placeholder="Nome da empresa *"></div>
        <div class="slide"><input type="email" name="email" required placeholder="Email *"></div>
        <div class="slide"><input type="text" name="phone_number" placeholder="Telefone"></div>
        <div class="slide"><input type="text" name="cep" placeholder="CEP" maxlength="9"></div>
        <div class="slide"><input type="text" name="street" placeholder="Rua"></div>
        <div class="slide"><input type="text" name="nHouse" placeholder="Número da casa"></div>
        <div class="slide"><input type="text" name="neighbor" placeholder="Bairro"></div>
        <div class="slide"><input type="text" name="city" placeholder="Cidade"></div>
        <div class="slide">
            <select name="state">
                <option value="">Selecione o estado</option>
                <?php foreach ($states as $options): ?>
                    <option value='<?=$options["UF"]?>'><?=$options["Nome"]?> - <?=$options["UF"]?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="slide"><textarea name="complement" placeholder="Complemento"></textarea></div>

        <div class="wizard-buttons">
            <button type="button" id="prevBtn">Voltar</button>
            <button type="button" id="nextBtn">Avançar</button>
            <input type="submit" id="submitBtn" style="display:none;" value="Enviar">
        </div>
    </form>

    <script src="/assets/js/formWizard.js"></script>
    <script src="./assets/js/validateCaracters.js"></script>
</body>
</html>
