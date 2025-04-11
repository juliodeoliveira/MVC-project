<?php

namespace App\Middleware;

use App\Functions\LoadEnv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    public static function verifyAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["jwt"])) {
            if ($_SERVER['REQUEST_URI'] !== "/") {
                header("Location: /");
                exit();
            }
            return null;
        }

        try {
            $decoded = JWT::decode($_SESSION["jwt"], new Key(LoadEnv::fetchEnv("JWT_SECRET"), 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            session_destroy();
            header("Location: /");
            exit();
        }

    }
}