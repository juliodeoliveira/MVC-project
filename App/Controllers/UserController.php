<?php

namespace App\Controllers;

use App\Functions\LoadEnv;
use App\Models\User;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;
class UserController
{
    public function registerUser(): void
    {
        session_start();
       
        // TODO: trim aqui, esqueci de colocar
        $userName = $_POST["userName"];
        $userEmail = $_POST["userEmail"];
        $userPasskey = $_POST["userPasskey"];

        $errors = [];
        $_SESSION['email'] = $_POST["userEmail"];

        if (empty($userName)) {
            $errors[] = "Nome obrigatório";
        }
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email inválido";
        }
        if (strlen($userPasskey) < 8) {
            $errors[] = "A senha deve conter pelo menos 8 caracteres";
        } 

        $userPasskey = password_hash($userPasskey, PASSWORD_DEFAULT);

        $userRepository = new UserRepository();

        //TODO: Validar o nome, questao dos caracteres especiais
        $user = new User($userName, $userEmail, $userPasskey);

        if ($userRepository->emailExists($user)) {
            $errors[] = "Email já cadastrado";
        }
        if ($userRepository->usernameExists($user)) {
            $errors[] = "Nome de usuário em uso";
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: /sign-in");
            exit();
        }        

        unset($_SESSION['errors'], $_SESSION["email"]);

        $userRepository->insert($user);

        $payload = [
            "sub" => $userEmail,
            "name" => $user->getUsername(),
            "iat" => time(),
            "exp" => time() + 3600
        ];

        $jwt = JWT::encode($payload, LoadEnv::fetchEnv("JWT_SECRET"), 'HS256');

        $_SESSION["jwt"] = $jwt;
        header("Location: /");
        exit();
    }

    //TODO: por enquanto qualquer usuario consegue ver qualquer coisa, tenho que fazer a verificacao do que cada usuario consegue ver em cada página!
    public function loginUser(): void
    {
        session_start();

        $userEmail = $_POST["userEmail"];
        $userPasskey = $_POST["userPasskey"];

        $errors = [];
        $_SESSION['email'] = $_POST["userEmail"];

        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email inválido";
        }
        if (strlen($userPasskey) < 8) {
            $errors[] = "A senha deve conter pelo menos 8 caracteres";
        }        

        $checkEmail = new UserRepository();
        $findEmail = $checkEmail->findEmail($userEmail);
        
        if (empty($findEmail)) {
            $errors[] = "Usuário e/ou senha inválidos";
            $_SESSION["errors"] = $errors;
            header("Location: /login");
            exit();
        }

        if (!password_verify($userPasskey, $findEmail->getPassword())) {
            $errors[] = "Usuário e/ou senha inválidos";
            $_SESSION["errors"] = $errors;
            header("Location: /login");
            exit();
        }

        $payload = [
            "sub" => $userEmail,
            "name" => $findEmail->getUsername(),
            "userId" => $findEmail->getId(),
            "iat" => time(),
            "exp" => time() + 3600
        ];

        $jwt = JWT::encode($payload, LoadEnv::fetchEnv("JWT_SECRET"), 'HS256');

        $_SESSION["jwt"] = $jwt;
    }

    public function findUser(string $userName): User
    {
        $findName = new UserRepository();
        return $findName->findUserName($userName);
    }

    // TODO: talvez seria melhor se pegasse o id pelo retorno do middleware ao inves do $_SESSION
    public function checkPermission(int $userId, string $permissionName): bool
    {
        $permission = new UserRepository();
        return $permission->userHasPermission($userId, $permissionName);
    }

    public function getAllUsers(): array
    {
        $permissions = new UserRepository();
        $allUsers = $permissions->getAllUsersPermissions();
        foreach ($allUsers as $user) {
            $user->setRole($this->roleConfigurator($user));
        }

        return $allUsers;
    }

    public function getAllPermissionsNames(): array
    {
        $allPermissions = [];

        $allNames = new UserRepository();
        $permissions = $allNames->allPermissionsNames();
        foreach ($permissions as $permission) {
            $allPermissions[] = $permission["name"];
        }
        return $allPermissions;
    }

    public function updatePermissions()
    {
        $permissionInfo = new UserRepository();
        $allPermissionInfo = $permissionInfo->permissionsInfo();

        $userId = $_POST["user_id"];
        $permissionsIds = [];

        foreach($allPermissionInfo as $permission) {
            if (in_array($permission["name"], $_POST["permissions"] ?? [])) {
                $permissionsIds[] = $permission["id"];
            }
        }

        $permissionInfo->updateUserPermissions($userId, $permissionsIds);
    }

    public function roleConfigurator(User $user): string
    {
        $newUserRole = "user";
        $roleRules = [
            'admin' => ['create_project', 'delete_project', 'edit_project', 'manage_permissions'],
            'editor' => ['create_project', 'edit_project'],
            'user'   => ['view_project'],
        ];

        foreach ($roleRules as $role => $requiredPerms) {
            if (empty(array_diff($requiredPerms, $user->getPermissions()))) {
                $newUserRole = $role;
                break;
            }
        }

        $user->setRole($newUserRole);
        return $user->getRole();
    }
}