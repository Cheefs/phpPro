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
 * @property string $status
*/
class Order extends Entity {

    const STATUS_PROCESS = 0;
    const STATUS_SEND = 1;
    const STATUS_DELIVERED = 2;
    const STATUS_CANCEL = 3;

    public $user_id;
    public $fio;
    public $price;
    public $email;
    public $phone;
    public $address;
    public $products_json;
    public $status;

    public function __construct(array $params = []) {
        foreach ($params as $k=>$v) {
            $this->$k = $v;
        }
    }
}