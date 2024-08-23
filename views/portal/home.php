<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        header {
            background-color: #4CAF50;
            width: 100%;
            padding: 20px 0;
            text-align: center;
            color: white;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
            max-width: 600px;
            text-align: center;
        }

        footer {
            background-color: #333;
            color: white;
            width: 100%;
            padding: 10px 0;
            text-align: center;
        }

        footer > p {
            margin: auto;
            padding: 10px;
        }
    </style>
    <link rel="shortcut icon" href="./assets/images/favicon/closedfolder.png" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Bem-vindo à Home Page</h1>
    </header>
    <main>
        <h1>Olá, Mundo!</h1>
        <p>Esta é uma página inicial simples criada com HTML e CSS. Ela tem um layout básico com um cabeçalho, um corpo principal e um rodapé.</p>
        <a href="/signin-client">Clique aqui para cadastrar um novo cliente!</a>
        <a href="/list-customers">Clique aqui para ver os clientes!</a>
    </main>
    <footer>
        <p>&copy; 2024 Minha Página Simples</p>
    </footer>
</body>
</html>