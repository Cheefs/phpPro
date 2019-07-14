<?php

namespace app\models;

class Cart extends Model {
    public $userId;
    public $count;
    public $productId;

    public static function tableName() {
        return 'cart';
    }
}