<?php

namespace core;

use app\classes\Uri;
use app\exceptions\ControllerNotExistException;

class Controller {
    private $uri;
    private $namespace;
    private $controller;
    private $folders = [
        'app\controllers\portal', 
        'app\controllers\admin'
    ];
    
    public function __construct() {
        $this->uri = Uri::uri();
    }

    public function load() {
        if ($this->isHome()) {
            return $this->controllerHome();
        }
        return $this->controllerNotHome();
    }

    private function controllerHome() {
        if (!$this->controllerExist('HomeController')) {
            throw new ControllerNotExistException("Esse controller não existe");
        }
        echo "You are at home!";
        return $this->instantiateController();
    }

    private function controllerNotHome() {
        echo "You are not at home!";
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
        echo "You are at home! XD";
        return new $controller;
    }   
}