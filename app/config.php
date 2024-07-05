<?php
return [
    "database" => [
        'host' => 'localhost',
        'dbname' => 'projectmanager',
        'password' => 'root', 
        'username' => 'root',
        'charset' => 'utf8',
        'settings' => [
            PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ
        ]
    ]
];