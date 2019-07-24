<?php

namespace app\models;

use app\services\DB;

/**
 * @property $id
*/

abstract class Model {
    protected $id;

    public function getId() {
        return $this->id;
    }

    /**
     * Функция для установки названия таблици базы данных для класса
     * @return mixed
     */
    public static abstract function tableName();

    /**
     * Заполнение модели параметрами
     * @param array $data
     */
    public function load(array $data) {
        foreach ($data as $k=>$v) {
            if (!is_null($v) && trim($v) !== '') {
                $this->$k = $v;
            }
        }


    }
    /**
     * @param int $id
     * @return static::class
     */
    public static function find(int $id) {
        $table = static::tableName();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return DB::getInstance()->find($sql, get_called_class() , [':id' => $id]);
    }

    /**
     * Поиск всех записей в таблице
     * @param array $params
     * @return array
     */
    public static function findAll(array $params = []) {
        if (count($params)) {
            $str = self::findConditions($params);
        }
        $table = static::tableName();
        $sql = "SELECT * FROM {$table}" . ( $str ?? '' );
        return DB::getInstance()->findAll($sql, get_called_class(), $params);
    }

    /**
     * Поиск записей по условию
     * @param $params
     * @return string
     */
    private static function findConditions($params) {
        $result = ' WHERE ';
        $paramsCount = count($params);
        $counter = 0;
        foreach ($params as $k => $v) {
            $counter++;
            $prefix = $counter < $paramsCount ? ' AND ' : '';
            $result .= "`{$k}` = :{$k}{$prefix}" ;
        }

        return $result;
    }

    /**
     * Удаление обьекта данных из базы
     */
    public function delete() {
        if (!is_null($this->id)) {
            $table = $this->tableName();
            $sql = "DELETE FROM {$table} WHERE id=:id";
            DB::getInstance()->execute($sql, [':id' => $this->id]);
        }
    }

    /**
     * Сохранение данных в базу
     */
    public function save() {
        $table = $this->tableName();
        $params = $this->prepareData();
        if (is_null($this->id)) {
            $fields = implode(',', $params['keys']);
            $keys = implode(',', array_keys($params['keys']));
            $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$keys})";
            DB::getInstance()->execute($sql, $params['values']);
            $this->id = DB::getInstance()->lastInsertId();
        } else {
            $keys = implode(',', $params['keys']);

            $sql = "UPDATE $table SET {$keys} WHERE id={$this->id}";

            DB::getInstance()->execute($sql, $params['values']);
        }
    }

    /**
     * Подготовка полей для insert или update
     * @return array
     */
    private function prepareData() {
        $res = [];
        $fields = get_object_vars($this);
        $isUpdate = (bool)$this->id;

        foreach ($fields as $k => $v) {
            if ($k == 'id') continue;
            if ( $isUpdate ) {
                $res['keys'][":$k"]= "`$k` = :$k";
            } else {
                $res['keys'][":$k"]= "`$k`";
            }
            $res['values'] ["$k"] = $this->$k;
        }
        return $res;
    }
}