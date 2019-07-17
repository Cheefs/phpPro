<?php

namespace app\models;

class Product extends Model {

    public $name;
    public $photo;
    public $price;
    public $brand;
    public $material;
    public $desc;

    /**
     * Функция для установки названия таблици базы данных для класса
     * @return mixed
     */
    public static function tableName() {
        return 'products';
    }

    /**
     * Получение цены товара, нужна дороботка, либо добавление в корзине поля с ценой, так как при подсчете цены корзины
     * прийдется дергать базу для каждого товара
     * @return mixed
     */
    public function getPrice() {
        $product = static::find(['id' => $this->id]);
        return $product['price'];
    }
}