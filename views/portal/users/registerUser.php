<?php 
session_start(); 
$oldValues = $_SESSION["old"] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se cadastrar</title>
</head>
<body>
    <h1>Cadastrar um usuário!</h1>
    <form action="/sign-user" method="POST">
        <input type="text" value="<?=$oldValues["userName"] ?? ""?>" name="userName" id="user-name" placeholder="Nome de usuário:" required>
        <input type="email" value="<?=$oldValues["userEmail"] ?? ""?>" name="userEmail" id="user-email" placeholder="Email:" required>
        <input type="password" value="<?=$oldValues["userPasskey"] ?? ""?>" name="userPasskey" id="user-passkey" placeholder="Senha:" required>

        <input type="submit" value="Cadastrar">

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