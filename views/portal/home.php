<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="shortcut icon" href="./assets/images/favicon/closedfolder.png" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Bem-vindo à Home Page</h1>
    </header>
    <main>
        <?php
            $loggedUser = $_SESSION["usernameLogged"] ?? "Convidado";
        ?>
        <p>Logado como: <?=$loggedUser?></p>
        <h1>Olá, Mundo!</h1>
        <p>Esta é uma página inicial simples criada com HTML e CSS. Ela tem um layout básico com um cabeçalho, um corpo principal e um rodapé.</p>
        <a href="/signin-client">Clique aqui para cadastrar um novo cliente!</a>
        <a href="/list-customers">Clique aqui para ver os clientes!</a>
        
        <?php 
            if (!empty($_SESSION["usernameLogged"])) {
                echo "<a href='/logout'>Fazer logout</a>";
            } else {
                echo "<a href='/login'>Logar em uma conta existente</a>";
                echo "<a href='/sign-in'>Criar usuário</a>";
            }
        ?>

    </main>
    <footer>
        <p>&copy; 2024 Minha Página Simples</p>
    </footer>
</body>
</html>