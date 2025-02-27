<?php

return [
    "name" => "project_pictures",
    "columns" => [
        "id" => "BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY",
        "project_id" => "BIGINT NOT NULL",
        "photo_name" => "TEXT NOT NULL",
        "photo_description" => "LONGTEXT",
        "photo_path" => "LONGTEXT",
        "created_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
    ],

    "foreign_keys" => [
        "project_id" => "REFERENCES projects(id) ON DELETE CASCADE"
    ]
];