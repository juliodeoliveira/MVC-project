<?php

return [
    "name" => "project_documents",
    "columns" => [
        "docs_id" => "BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY",
        "document_project_id" => "BIGINT NOT NULL",
        "document_name" => "LONGTEXT NOT NULL",
        "document_type" => "TEXT",
        "document_path" => "LONGTEXT",
    ],
    "foreign_keys" => [
        "document_project_id" => "REFERENCES projects(id) ON DELETE CASCADE"
    ]
];