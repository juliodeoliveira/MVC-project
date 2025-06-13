<?php
use App\Controllers\UserController;
use App\Controllers\PermissionController; // controlador de permissões, supondo que você tenha ele

$controller = new UserController();
$usersList = $controller->allPermissions();

// Buscamos todas as permissões disponíveis
$permissionController = new UserController();
$allPermissions = $permissionController->getAllPermissionsNames(); 

// este método deve retornar algo como:
// [
//   ['id' => 1, 'name' => 'editar_tarefa'],
//   ['id' => 2, 'name' => 'deletar_usuario'],
//   ...
// ]
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Editar Usuários</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 { text-align: center; margin-bottom: 40px; }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .user-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            padding: 20px;
            width: 100%;
            max-width: 400px;
            transition: transform 0.2s;
        }
        .user-card:hover { transform: translateY(-5px); }
        .username { font-size: 1.4rem; margin-bottom: 8px; }
        .email { font-size: 0.9rem; color: #777; margin-bottom: 15px; }
        .label {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            margin: 4px 4px 8px 0;
            white-space: nowrap;
        }
        .label-role { background: #28a745; color: white; }
        .label-permission { background: #ffc107; color: #333; }
        form { margin-top: 15px; }
        input[type="submit"] {
            margin-top: 10px;
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type="submit"]:hover { background: #0056b3; }
        select, label { margin-top: 5px; display: block; }
        .permissions-box { margin-top: 10px; }
    </style>
</head>
<body>

<h1>Lista de Usuários, Roles e Permissões</h1>

<div class="container">
<?php foreach ($usersList as $user): ?>
    <div class="user-card">
        <div class="username"><?= htmlspecialchars($user->getUsername()) ?></div>
        <div class="email"><?= htmlspecialchars($user->getEmail()) ?></div>

        <div><strong>Role atual:</strong>
            <?php if ($user->getRole() != "roleless"): ?>
                <span class="label label-role"><?= htmlspecialchars($user->getRole()) ?></span>
            <?php else: ?>
                <span class="label label-role">Sem cargo</span>
            <?php endif; ?>
        </div>

        <div><strong>Permissões:</strong><br>
            <?php if (!empty($user->getPermissions())): ?>
                <?php foreach ($user->getPermissions() as $perm): ?>
                    <span class="label label-permission"><?= htmlspecialchars($perm) ?></span>
                <?php endforeach; ?>
            <?php else: ?>
                <em>Sem permissões</em>
            <?php endif; ?>
        </div>

        <form action="/update-user" method="POST">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user->getId()) ?>">

            <label for="role">Alterar Role:</label>
            <select name="role">
                <option value="">Sem Cargo</option>
                <option value="admin" <?= $user->getRole() == "admin" ? "selected" : "" ?>>Admin</option>
                <option value="editor" <?= $user->getRole() == "editor" ? "selected" : "" ?>>Editor</option>
                <option value="user" <?= $user->getRole() == "user" ? "selected" : "" ?>>User</option>
            </select>

            <div class="permissions-box">
                <strong>Permissões:</strong><br>
                <?php foreach ($allPermissions as $permission): ?>
                    <label>
                        <input type="checkbox" name="permissions[]" value="<?= htmlspecialchars($permission) ?>"
                            <?= in_array($permission, $user->getPermissions()) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($permission) ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <input type="submit" value="Salvar Alterações">
        </form>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
