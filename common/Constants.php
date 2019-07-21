<?php
define('APP_NAME', 'app');
define('FILE_EXT', '.php');
define('CONTROLLER', 'Controller');
define('DEFAULT_CONTROLLER', 'default');
define('CONTROLLERS_PATH', 'app\\controllers\\');

define('ROOT', $_SERVER['DOCUMENT_ROOT'] .'/../');
define('AUTOLOAD', ROOT.'/services/Autoload.php');
define('MESSAGES', ROOT.'/services/messages/');
define('TRANSLATE', ROOT.'/services/Translate.php');
