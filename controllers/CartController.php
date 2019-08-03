<?php

namespace app\controllers;

use app\models\entities\Order;
use app\models\entities\User;
use app\models\repositories\CartRepository;
use app\models\repositories\OrderRepository;
use app\models\repositories\UserRepository;

class CartController extends Controller {

   const PRODUCT = 'products';

   public function actionIndex() {
       $cartItems = $this->session->get(self::PRODUCT);
       $cartTotal = (new CartRepository())->getTotalCartPrice($cartItems?? []);
       $user_id = $this->session->get('user_id');

       if ($user_id) {
           $user = (new UserRepository())->find($user_id);
       }

       if ($_SERVER['REQUEST_METHOD'] === POST && count($_POST)) {
           if (isset($user) && !is_null($user) ) {
               /** @var $user User */
               $order = new Order([
                   'user_id' => $user->id,
                   'fio' => $_POST['fio'],
                   'price' => $cartTotal['price'],
                   'email' => $_POST['email'],
                   'phone' => $_POST['phone'],
                   'address' => $_POST['address'],
                   'products_json' => json_encode($cartItems),
                   'status' => Order::STATUS_PROCESS
               ]);
               (new OrderRepository())->save($order);
               $this->session->remove(self::PRODUCT);
              return $this->redirect('index', 'products');
           }
       }

       return $this->render('index', [
           'user' => $user?? null,
           'cartItems' => $cartItems ?? [],
           'cartTotal' => $cartTotal,
       ]);
   }

   public function actionDelete( $id) {
       $cartItems = $this->session->get('products');
       if(isset($cartItems[$id])) {
           $item = $cartItems[$id];
          if ($item['count'] > 1) {
              $item['count']--;
              $cartItems[$id] = $item;

          } else {
              $cartItems = array_filter($cartItems, function ($el) use ($item) {
                 return $el['id'] != $item['id'];
              });
          }
       }
       $this->session->set('products', $cartItems);
       return $this->redirect();
   }
}