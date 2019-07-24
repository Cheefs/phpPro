<?php

include $_SERVER['DOCUMENT_ROOT'] .'/../common/Constants.php';
include AUTOLOAD;
include TRANSLATE;

spl_autoload_register([new Autoload(), 'loadClass']);

$controller = $_GET['c']?? 'default';
$action = $_GET['a']?? 'index';

$controllerClass = CONTROLLERS_PATH.ucfirst($controller).CONTROLLER;

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    $page = $controller->run($action, $_GET['id']);

    echo $page;
} else {
    header('Location: /');
}

?>