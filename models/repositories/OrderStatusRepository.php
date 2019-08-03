<?php


namespace app\models\repositories;

use app\models\entities\OrderStatus;

class OrderStatusRepository extends Repository {

    /**
     * Функция для установки названия таблици базы данных для класса
     * @return mixed
     */
    public static function tableName() {
        return 'order_statuses';
    }

    protected function getEntityName() {
        return OrderStatus::class;
    }

    public function getStatusesArr() {
        $orderStatuses = $this->findAll();
        $res = [];
        foreach ($orderStatuses as $v) {
            $res [$v->id] = $v->name;
        }
        return $res;
    }
}