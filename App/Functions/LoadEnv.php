<?php

namespace App\Functions;

class LoadEnv 
{

    private static $envPath = "./../.env";

    // Retornar do arquivo o valor que o usuario quer, por exemplo
    private static function env($filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \Exception(".env file not found.");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            // Define a variável de ambiente
            putenv("$name=$value");
        }

        self::$envPath = $filePath;
    }

    public static function fetchEnv($envValue): string
    {
        self::env(self::$envPath);
        return getenv($envValue);
    }

}