<?php

return [
    "name" => "user_permission",
    "columns" => [
        "user_id" => "BIGINT(20) NOT NULL",
        "permission_id" => "INT(11) NOT NULL"
    ],
    "primary_key" => ["user_id", "permission_id"],
    "indexes" => [
        "permission_id"
    ],
    "foreign_keys" => [
        "user_id" => "REFERENCES users(id) ON DELETE CASCADE",
        "permission_id" => "REFERENCES permissions(id) ON DELETE CASCADE"
    ]
];
