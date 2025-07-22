<?php

return [
    "name" => "permissions",
    "columns" => [
        "id" => "INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "name" => "VARCHAR(100) NOT NULL"
    ],
    "unique_keys" => [
        "name"
    ]
];
