<?php

use app\models\User;
use app\models\Cart;
use app\models\Customer;
use app\models\Product;

include $_SERVER['DOCUMENT_ROOT'] .'/../services/Autoload.php';
spl_autoload_register([new Autoload(), 'loadClass']);

$user = new User();
$customer = new Customer();
$cart = new Cart();

$customerCart = $cart::find(['user_id' => '1']);

$product = new Product();

$cart->count = 150;
$cart->productId = 1;
$cart->userId = 1;

//echo $cart->save()? 'SAVED' : 'ERROR';

$productsList = $product::findAll();

?>

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>photo</th>
            <th>price</th>
            <th>brand</th>
            <th>material</th>
            <th>desc</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($productsList as $product): ?>
        <tr>
            <td> <?= $product['id'] ?> </td>
            <td> <?= $product['name'] ?> </td>
            <td> <?= $product['photo'] ?> </td>
            <td> <?= $product['price'] ?> </td>
            <td> <?= $product['brand'] ?> </td>
            <td> <?= $product['material'] ?> </td>
            <td> <?= $product['desc'] ?> </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>