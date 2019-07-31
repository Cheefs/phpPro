<?php
use app\main\App;
include $_SERVER['DOCUMENT_ROOT'] .'/../common/Constants.php';
include AUTOLOAD;
include TRANSLATE;

$config = include(ROOT.'main/config.php');

App::call()->run($config);
