<?php

namespace App;

use PDO;
use App\Functions\LoadEnv;
                          
require "../bootstrap.php";

class Connection 
{
    public function connect(): PDO
    {        
        $pdo = new PDO("mysql:host=" . LoadEnv::fetchEnv("DB_HOST") . ";dbname=" . LoadEnv::fetchEnv("DB_NAME") . ";charset=utf8", LoadEnv::fetchEnv("DB_USER"), LoadEnv::fetchEnv("DB_PASSWORD"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $pdo;
    }
}