<?php

namespace app\models\repositories;

use app\models\entities\Order;

class OrderRepository extends Repository
{
    public static function tableName() {
        return 'orders';
    }
    protected function getEntityName() {
        return Order::class;
    }

    public function prepareOrders(&$orders) {
        foreach ($orders as $order) {
            $arr = [];
            $count = 0;
            $products = json_decode($order->products_json);

            foreach ($products as $product) {
                $arr[] = $product;
                $count += (int)$product->count;
            }
            $order->products = $arr;
            $order->count = $count;
        }
        return $orders;
    }
}