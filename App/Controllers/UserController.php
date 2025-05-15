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

        unset($_SESSION['errors'], $_SESSION["old"]);

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
        $_SESSION['old'] = $_POST;

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
        }

        if (!password_verify($userPasskey, $findEmail->getPassword())) {
            $errors[] = "Usuário e/ou senha inválidos";
        }
        
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: /login");
            exit();
        }

        $payload = [
            "sub" => $userEmail,
            "name" => $findEmail->getUsername(),
            "iat" => time(),
            "exp" => time() + 3600
        ];

        $jwt = JWT::encode($payload, LoadEnv::fetchEnv("JWT_SECRET"), 'HS256');

        $_SESSION["jwt"] = $jwt;
        header("Location: /");
        exit();
    }
}