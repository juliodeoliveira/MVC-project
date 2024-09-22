<?php

namespace App;
use PDO;
                          
require "../bootstrap.php";
class Connection 
{
    public function connect(): PDO
    {
        loadEnv("../.env");
        $pdo = new PDO("mysql:host=" . getenv("DB_HOST") . ";dbname=" . getenv("DB_NAME") . ";charset=utf8", getenv("DB_USER"), getenv("DB_PASSWORD"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $pdo;
    }
}