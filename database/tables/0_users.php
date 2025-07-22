<?php

return [
    'name' => 'users',
    'columns' => [
        'id' => "bigint auto_increment not null primary key",
        'username' => "text NOT NULL",
        'email' => "VARCHAR(255) UNIQUE NOT NULL",
        'password' => "text NOT NULL",
        'created_at' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
    ]
];