<?php

return [
    "name" => "projects",
    "columns" => [
        "id" => "BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY",
        "title" => "TEXT NOT NULL",
        "description" => "LONGTEXT",
        "start_date" => "DATE NOT NULL",
        "end_date" => "DATE",
        "service" => "TEXT NOT NULL",
        "customer_id" => "BIGINT NOT NULL DEFAULT 0",
        "created_at" => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
    ],

    "foreign_keys" => [
        'customer_id' => "REFERENCES customers(id) ON DELETE CASCADE"
    ]
];