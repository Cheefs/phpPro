<?php

namespace app\models;

use app\services\DB;
use app\helpers\StringConvertHelper;

abstract class Model {
    protected $id;
    private $db;

    const HTML_SPACE = '&nbsp;';
    const MODE_INSERT = 0;
    const MODE_UPDATE = 1;

    public function getUserId() {
        return $this->id;
    }

    public function __construct() {
        $this->db = DB::getInstance();
    }

    /**
     * Функция для установки названия таблици базы данных для класса
     * @return mixed
     */
    public abstract function tableName();

    /**
     * @param int $id
     * @return self
     */
    public function find(int $id) {
        $table = $this->tableName();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return $this->db->find(static::class, $sql, [':id' => $id]);
    }

    /**
     * Поиск всех записей в таблице
     * @return array
     */
    public function findAll() {
        $table = $this->tableName();
        $sql = "SELECT * FROM {$table}";
        return $this->db->findAll(static::class, $sql);
    }

    /**
     * Удаление обьекта данных из базы
     */
    public function delete() {
        if (!is_null($this->id)) {
            $table = $this->tableName();
            $sql = "DELETE FROM {$table} WHERE id=:id";
            $this->db->execute(static::class, $sql, [':id' => $this->id]);
        }
    }

    /**
     * Сохранение данных в базу
     */
    public function save() {
        $table = $this->tableName();
        $fields = $this->getFieldLists();
        $params = $this->prepareData();
        $values = $params['values'];

        if (is_null($this->id)) {
            $keys = implode(',', $params['keys']);
            $fields = implode(',', $fields);
            $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$keys})";
        } else {
            $keys = $this->getKeysToUpdate($fields);
            $sql = "UPDATE $table SET {$keys} WHERE id={$this->id}";
        }

        $this->db->execute(static::class, $sql, $values);
    }

    /**
     * Подготовка полей для более удобного insert или update
     * @return array
     */
    private function prepareData() {
        $fields = $this->getFieldLists();
        $exitParams = [];
        foreach ($fields as $k) {
            $exitParams['keys'][] = ":$k";
            $exitParams['values']["$k"] = $this->$k;
        }
        return $exitParams;
    }

    /**
     * Подготовка строки запороса для update
     * @param $params
     * @return string
     */
    private function getKeysToUpdate($params) {
        $fields = [];
        foreach ($params as $k=>$v) {
            $fields [] = "$v=:$v";
        }
        return implode(',', $fields);
    }

    /**
     * Получение всех свойств класса
     * @return array
     */
    private function getFieldLists() {
        $result = [];
        $fields = get_object_vars($this);
        foreach ($fields as $k=>$v) {
            if ($k !== 'id' && $k !== 'db') {
                $result [] = $k;
            }
        }
        return $result;
    }

    /**
     * Если мы захотим заполнить наш обьект данными которые достали с базы,
     * например нашли пользователя, и заполнили обьект его полями
     * @param $data array Массив параметров которые пришли с базы данных
     */
    public function load($data) {
        if ($data) {
            $fields = $this->getFieldLists();
            $data = StringConvertHelper::snakeCaseToCamelCase($data);
            foreach ($fields as $k => $v) {
                $this->$k = $data[$k] ?? null;
            }
        }
    }

    /**
     * Название класса
     * @return mixed
     */
    public static function className() {
        $class = explode( '\\', static::class);
        return $class[count($class) - 1];
    }
}