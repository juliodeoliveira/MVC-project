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
    <form action="/sign-client" method="POST">
        <input type="text"  name="enterpriseName" require id="enterprisename" placeholder="Nome da empresa *">
        <input type="email" name="email" require id="email" placeholder="Email *">
        <input type="text" name="phone_number" id="telephone" placeholder="Telefone">
        <input type="text" name="cep" id="cep" placeholder="CEP">
        <input type="text" name="street" id="street" placeholder="Rua">
        <input type="text" name="nHouse" id="house" placeholder="Número da casa">
        <input type="text" name="neighbor" id="neightborhood" placeholder="Bairro">
        <input type="text" name="city" id="city" placeholder="Cidade">
        <input type="text" name="state" id="state" placeholder="Estado (UF)">
        <textarea name="complement" id="complement" placeholder="Complemento"></textarea>
        
        <input type="submit" value="Enviar">
    </form>
    
    <script>
        window.onload = () => {
            return false;
        }
    
    </script>
</body>
</html>