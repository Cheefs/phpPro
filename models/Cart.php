<?php

namespace app\models;
/**
 * @property int $count
 * @property int $user_id
 * @property int $product_id
 * @property int $is_guest
 *
*/
class Cart extends Model {
    public $count;
    public $user_id;
    public $product_id;
    public $is_guest;

    public static function tableName() {
        return 'cart';
    }

    public function getProduct(int $id) {
        return Product::find($id);
    }
}