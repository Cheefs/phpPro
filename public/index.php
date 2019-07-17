<?php

use app\models\User;
use app\models\Product;
include $_SERVER['DOCUMENT_ROOT'] .'/../services/Autoload.php';
spl_autoload_register([new Autoload(), 'loadClass']);


//$user = new User();
//$user->first_name = 'TEST';
//$user->last_name = 'TESTOVI4';
//$user->second_name = 'TESTOV';
//$user->email = 'test';
//$user->phone = 'none';
//$user->setUserName('test');
//$user->setPassword('test');
//$user->save();

//$tmpUser = $user->find(5);
//$tmpUser->setUserName('update_test');
//$tmpUser->second_name= 'SECOND   NAME';
//$tmpUser->setPassword('update_test');
//$tmpUser->save();
//$tmpUser->delete();

$product = new Product();
$product = $product->find(11);
$product->name = 'UPDATE';
$product->price = 50;
$product->material = 'UPDATE';
$product->brand = 'UPDATE';
$product->photo = 'UPDATE';
$product->desc = 'UPDATE';
$product->save();

?>