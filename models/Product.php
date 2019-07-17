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
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPhoto() {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getBrand() {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand): void {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getMaterial() {
        return $this->material;
    }

    /**
     * @param mixed $material
     */
    public function setMaterial($material): void {
        $this->material = $material;
    }

    /**
     * @return mixed
     */
    public function getDesc() {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc): void {
        $this->desc = $desc;
    }

    /**
     * Функция для установки названия таблици базы данных для класса
     * @return mixed
     */
    public static function tableName() {
        return 'products';
    }

}