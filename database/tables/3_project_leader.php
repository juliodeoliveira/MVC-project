<?php

return [
    "name" => "project_leader", 
    "columns" => [
        "id" => "BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY",
        "project_id" => "BIGINT NOT NULL",
        "user_id" => "BIGINT NOT NULL",

    ],
    "foreign_keys" => [
        "project_id" => "REFERENCES projects(id) ON DELETE CASCADE",
        "user_id" => "REFERENCES users(id) ON DELETE CASCADE"
    ]
];
