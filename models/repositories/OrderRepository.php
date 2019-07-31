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
}