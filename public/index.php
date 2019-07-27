<?php

include $_SERVER['DOCUMENT_ROOT'] .'/../common/Constants.php';
include AUTOLOAD;
include TRANSLATE;

use app\services\TwigRenderService;

$controller = $_GET['c']?? 'default';
$action = $_GET['a']?? 'index';

$controllerClass = CONTROLLERS_PATH.ucfirst($controller).CONTROLLER;

if (class_exists($controllerClass)) {
    $controller = new $controllerClass(new TwigRenderService());
    $page = $controller->run($action, $_GET['id']);

    echo $page;
} else {
    header('Location: /');
}
