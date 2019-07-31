<?php


namespace app\models\entities;

/**
 * @property int $user_id
 * @property string $fio
 * @property string $price
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $products_json
*/
class Order extends Entity {
    public $user_id;
    public $fio;
    public $price;
    public $email;
    public $phone;
    public $address;
    public $products_json;

    public function __construct(array $params = []) {
        foreach ($params as $k=>$v) {
            $this->$k = $v;
        }
    }
}