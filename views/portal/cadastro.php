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
    <form action="/sign-client" method="POST">
        <input type="text"  name="enterpriseName" required id="enterprisename" placeholder="Nome da empresa *">
        <input type="email" name="email" required id="email" placeholder="Email *">
        <input type="text" name="phone_number" id="telephone" placeholder="Telefone">
        <input type="text" name="cep" id="cep" placeholder="CEP">
        <input type="text" name="street" id="street" placeholder="Rua">
        <input type="text" name="nHouse" id="house" placeholder="Número da casa">
        <input type="text" name="neighbor" id="neightborhood" placeholder="Bairro">
        <input type="text" name="city" id="city" placeholder="Cidade">
        <!-- <input type="text" name="state" id="state" placeholder="Estado (UF)"> -->
        <select name="state" id="state" placeholde="Selecione o estado">
            <option value="">Selecione o estado: </option>
            <option value="Acre">Acre - AC</option>
            <option value="Alagoas">Alagoas - AL</option>
            <option value="Amapá">Amapá - AP</option>
            <option value="Amazonas">Amazonas - AM</option>
            <option value="Bahia">Bahia - BA</option>
            <option value="Ceará">Ceará - CE</option>
            <option value="Espírito Santo">Espírito Santo - ES</option>
            <option value="Goiás">Goiás - GO</option>
            <option value="Maranhão">Maranhão - MA</option>
            <option value="Mato Grosso">Mato Grosso - MT</option>
            <option value="Mato Grosso do Sul">Mato Grosso do Sul - MS</option>
            <option value="Minas Gerais">Minas Gerais - MG</option>
            <option value="Pará">Pará - PA</option>
            <option value="Pernambuco">Pernambuco - PE</option>
            <option value="Piauí">Piauí - PI</option>
            <option value="Rio de Janeiro">Rio de Janeiro - RJ</option>
            <option value="Rio Grande do Norte">Rio Grande do Norte - RN</option>
            <option value="Rio Grande do Sul">Rio Grande do Sul - RS</option>
            <option value="Rondônia">Rondônia - RO</option>
            <option value="Roraima">Roraima - RR</option>
            <option value="Santa Catarina">Santa Catarina - SC</option>
            <option value="São Paulo">São Paulo - SP</option>
            <option value="Sergipe">Sergipe - SE</option>
            <option value="Tocantins">Tocantins - TO</option>
        </select>
        <textarea name="complement" id="complement" placeholder="Complemento"></textarea>
        
        <input type="submit" value="Enviar">
    </form>
</body>
</html>