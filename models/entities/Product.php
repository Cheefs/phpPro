<?php


namespace app\models\entities;

/**
 * @property string $name
 * @property string $photo
 * @property string $price
 * @property string $brand
 * @property string $material
 * @property string $desc
 * @property int $count
 */
class Product extends Entity {
    private $id;
    public $name;
    public $photo;
    public $price;
    public $brand;
    public $material;
    public $desc;
    public $count;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }
}