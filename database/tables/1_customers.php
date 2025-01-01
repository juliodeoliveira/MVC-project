<?php

return [
    "name" => "customers",
    "columns" => [
        "id" => "BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY",
        "enterprise_name" => "TEXT NOT NULL",
        "email" => "VARCHAR(255) UNIQUE",
        "phone_number" => "VARCHAR(20)",

        "cep" => "TEXT",
        "street" => "TEXT",
        "house_number" => "VARCHAR(20)",
        "complement" => "TEXT",
        "neighborhood" => "TEXT",
        "city" => "TEXT",
        "state" => "TEXT",
        "created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP"
    ]
];