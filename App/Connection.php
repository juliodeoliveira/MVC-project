<?php

namespace App;
use PDO;

class Connection 
{
    public function connect(): PDO
    {
        $pdo = new PDO("mysql:host=localhost;dbname=projectmanager;charset=utf8", "root", "DBdojulio");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $pdo;
    }
}