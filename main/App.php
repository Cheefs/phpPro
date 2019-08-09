<?php

namespace app\main;

use app\common\traits\TSingleton;
use app\services\Request;
use app\services\Session;
use app\services\TwigRenderService;

class App {
    use TSingleton;

    const COMPONENTS = 'components';
    private $config;
    private $componentsData;
    private $components = [];

    public static function call() : App {
        return static::getInstance();
    }

    public function run(array $config) {
        $this->config = $config;
        $this->componentsData = $config['components'];
        $this->runController();
    }

    public function getConfig(string $key) {
        return (isset($this->config[$key]) && $key !== self::COMPONENTS)?
            $this->config[$key] : [];
    }

    private function runController() {
        $request = new Request();
        $session = new Session();
        $renderer = new TwigRenderService();

        $defaultController = $this->config['defaultController'];
        $defaultAction = $this->config['defaultAction'];

        $controller = $request->getControllerName()?: $defaultController;
        $action = $request->getActionName()?: $defaultAction;

        $controllerClass = CONTROLLERS_PATH.ucfirst($controller).CONTROLLER;

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($renderer, $request, $session);
            echo  $controller->run($action, $_GET['id']);
        } else {
            header('Location: /');
        }
    }

    public function __get(string $name) {
       if (isset($this->components['name'])) {
           return $this->components[$name];
       }

       if (isset($this->componentsData[$name])) {
           $class = $this->componentsData[$name]['class'];
           if (!class_exists($class)) {
               return null;
           }
           if (array_key_exists('config', $this->componentsData[$name])) {
               $config = $this->componentsData[$name]['config'];
               $component = new $class($config);
           } else {
               $component = new $class();
           }
           $this->components[$name] = $component;
           return $component;
       }
       return null;
    }


}