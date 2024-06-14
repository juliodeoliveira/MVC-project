<?php

namespace core;

class Twig 
{
    private $twig;
    private $functions = [];

    public function loadTwig()
    {
        $this->twig = new \Twig\Environment($this->loadViews(), [
            'debug' => true,

            //'cache' => "/cache",
            'auto_reload' => true
        ]);

        return $this->twig;
    }

    private function loadViews()
    {
        return new \Twig\Loader\FilesystemLoader("../app/views");
    }
}