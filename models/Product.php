<?php

namespace app\models;
/**
 * @property string $name
 * @property string $photo
 * @property string $price
 * @property string $brand
 * @property string $material
 * @property string $desc
*/
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
}