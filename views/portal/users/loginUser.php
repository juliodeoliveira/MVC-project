<?php 
session_start(); 
$oldValues = $_SESSION["old"] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Entrar em uma conta</h1>
    <form action="/login-user" method="POST">
        <input type="email" value="<?=$oldValues["userEmail"] ?? "" ?>" placeholder="E-mail" name="userEmail" id="user-email">
        <input type="password" value="<?=$oldValues["userPasskey"] ?? "" ?>" placeholder="Senha" name="userPasskey" id="user-password">

        <input type="submit" value="Login">

        <?php if (!empty($_SESSION['errors'])) {?>
            <ul style="color: red;">
                <?php foreach ($_SESSION["errors"] as $error) {?>
                    <li><?=$error?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        
        <?php unset($_SESSION['errors'], $_SESSION['old']) ?>
    </form>
</body>
</html>