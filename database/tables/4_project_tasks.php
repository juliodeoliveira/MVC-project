<?php

return [
    "name" => "project_tasks",
    "columns" => [
        "id" => "BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY",
        "task_project_id" => "BIGINT NOT NULL",
        "task_description" => "LONGTEXT",
        "task_status" => "TEXT",

    ],
    "foreign_keys" => [
        "task_project_id" => "REFERENCES projects(id) ON DELETE CASCADE"
    ]
];