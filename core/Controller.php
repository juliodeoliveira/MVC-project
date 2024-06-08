<?php

namespace core;

// use app\classes\Uri;
use app\exceptions\ControllerNotExistException;

class Uri {
    public static function uri() {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}

class Controller {
    private $uri;
    private $namespace;

    private $controller;

    private $folders = [
        'app\controllers\portal', 
        'app\controllers\admin'
    ];
    
    public function __construct() {
        $this->uri = URI::uri();
    }

    public function load() {
        if ($this->isHome()) {
            return $this->controllerHome();
        }
        return $this->controllerNotHome();
    }

    private function controllerHome() {
        if (!$this->controllerExist('HomeController')) {
            
            throw new ControllerNotExistException("A página que você está tentando acessar não existe!");
        }
        return $this->instantiateController();
    }

    private function controllerNotHome() {
        throw new ControllerNotExistException("A página que você está tentando acessar não existe!");
    }

    private function isHome() {
        return ($this->uri == "/");
    }
 
    private function controllerExist($controller) {
        $controllerExist = false;

        foreach ($this->folders as $folder) {
            if (class_exists($folder.'\\'.$controller)) {
                $controllerExist = true;
                $this->namespace = $folder;
                $this->controller = $controller;
            }
        }

        return $controllerExist;
    }

    private function instantiateController() {
        $controller = $this->namespace."\\".$this->controller;
        echo "Você está na página inicial! <br>";
        echo "<br>";
        return new $controller;
    }   
}