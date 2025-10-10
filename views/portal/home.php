<?php
use App\Controllers\ClientController;

session_start();
$loggedUser = $_SESSION["usernameLogged"] ?? "Convidado";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/pages/home.css">

    <link rel="shortcut icon" href="/assets/images/favicon/closedfolder.png" type="image/x-icon">
</head>
<body>
    <nav class="navbar">
        <h2 class="logo">📁 Project Explorer</h2>

        <button class="menu-toggle" aria-label="Abrir menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="nav-links">
            <a href="/signin-client">Cadastrar Cliente</a>
            <a href="/list-customers">Listar Clientes</a>
            <a href="/reports">Relatórios</a>
            <a href="/settings">Configurações</a>
            <?php if (!empty($_SESSION["usernameLogged"])) : ?>
                <a href="/admin">Administração</a>
                <a href="/logout" class="logout">Sair</a>
            <?php else : ?>
                <a href="/login">Login</a>
                <a href="/sign-in">Criar Conta</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- overlay escuro -->
    <div class="overlay"></div>


    <div class="main-wrapper">
        <main class="home-content">
        <h1>Bem-vindo de volta, <?= htmlspecialchars($loggedUser) ?>!</h1>
        <p>Veja um resumo das suas atividades recentes e acesse rapidamente as principais funções.</p>

        <section class="dashboard-cards">
            <div class="card">
                <h2>👥 Clientes</h2>
                <p><?=ClientController::countClients()?> cadastrados</p>
                <a href="/list-customers" class="btn small">Ver lista</a>
            </div>

            <!-- TODO: Adicionar o método de contar os projetos, projetos prontos, projetos sendo feitos e projetos finalizados e nao iniciados -->

            <!-- TODO: Adicioar o metodo de ver qual foi a ultima vez que o usuário logou -->
            <div class="card">
                <h2>🕒 Último acesso</h2>
                <p>Hoje às 10h32</p>
            </div>

            <div class="card">
                <h2>📊 Relatórios</h2>
                <p>Gere relatórios detalhados de clientes</p>
                <a href="/reports" class="btn small">Gerar</a>
            </div>
        </section>
    </main>
    </div>
    
    <script>
        const menuBtn = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.nav-links');
        const overlay = document.querySelector('.overlay');

        menuBtn.addEventListener('click', () => {
            nav.classList.toggle('active');
            overlay.classList.toggle('show');
            menuBtn.classList.toggle('open');
        });

        overlay.addEventListener('click', () => {
            nav.classList.remove('active');
            overlay.classList.remove('show');
            menuBtn.classList.remove('open');
        });

        window.addEventListener('resize', () => {
            const MOBILE_BREAKPOINT = 768
            if (window.innerWidth > MOBILE_BREAKPOINT) { // breakpoint do mobile
                nav.classList.remove('active');
                overlay.classList.remove('show');
                menuBtn.classList.remove('open');
            }
        });

    </script>

</body>
</html>
