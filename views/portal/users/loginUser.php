<?php 
session_start(); 
$oldValues = $_SESSION["old"] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/pages/login.css">
    <title>Login</title>
</head>
<body>
    <div class="full-login">
        <form class="login-form" action="/login-user" method="POST">
            <h1>Entrar em uma conta</h1>
            
            <input 
                type="email" 
                value="<?= htmlspecialchars($oldValues["userEmail"] ?? "") ?>" 
                placeholder="E-mail" 
                name="userEmail" 
                id="user-email"
                class="<?= !empty($_SESSION['errors']) ? 'input-error' : '' ?>"
            >

            <input 
                type="password" 
                value="<?= htmlspecialchars($oldValues["userPasskey"] ?? "") ?>" 
                placeholder="Senha" 
                name="userPasskey" 
                id="user-password"
                class="<?= !empty($_SESSION['errors']) ? 'input-error' : '' ?>"
            >

            <input  type="submit" value="Login">

            <?php if (!empty($_SESSION['errors'])): ?>
                <ul class="error-box">
                    <?php foreach ($_SESSION["errors"] as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif; ?>
            
            <?php unset($_SESSION['errors'], $_SESSION['old']) ?>
        </form>
    </div>
</body>
</html>
