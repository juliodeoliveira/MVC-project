<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;

class UserController
{
    public function registerUser(): void
    {
        session_start();
       
        $userName = $_POST["userName"];
        $userEmail = $_POST["userName"];
        $userPasskey = $_POST["userPasskey"];
        
        $userRepository = new UserRepository();
        $user = new User($userName, $userEmail, $userPasskey);

        $errors = [];
        $_SESSION['old'] = $_POST;

        if (empty($userName)) {
            $errors[] = "Nome obrigatório";
        }
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email inválido";
        }
        if (strlen($userPasskey) < 8) {
            $errors[] = "A senha deve conter pelo menos 8 caracteres";
        } 

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

        unset($_SESSION['errors'], $_SESSION["old"]);

        $userRepository->insert($user);
        header("Location: /");
    }
}