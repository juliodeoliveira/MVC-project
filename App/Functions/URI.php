<?php

namespace App\Functions;

class URI
{
    public static function uri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        return $uri;
    }

    public static function uriExplode(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uriExplode = explode("/", "$uri"); 

        return $uriExplode;
    }
}