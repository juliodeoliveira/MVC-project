<?php

namespace app\models;
use PDO;

class Connection {
    public function connect() {
        $pdo = new PDO("mysql:host=localhost;dbname=", "root", "root");
    }
}