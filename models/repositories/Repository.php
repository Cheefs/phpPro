<?php

namespace app\models\repositories;

use app\main\App;
use app\models\entities\Entity;
use app\services\DB;

/**
 * @property $id
 * @property DB $db
*/

abstract class Repository {

    protected $db;
    /**
     * Функция для установки названия таблици базы данных для класса
     * @return mixed
     */
    public static abstract function tableName();
    abstract protected function getEntityName();

    public function __construct(){
        $this->db = App::call()->db;
    }

    /**
     * @param int $id
     * @return Entity
     */
    public function find(int $id) {
        $table = static::tableName();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return $this->db->find($sql, $this->getEntityName(), [':id' => $id]);
    }

    /**
     * Поиск всех записей в таблице
     * @param array $params
     * @return array
     */
    public function findAll(array $params = []) {
        if (count($params)) {
            $str = self::findConditions($params);
        }
        $table = static::tableName();
        $sql = "SELECT * FROM {$table}" . ( $str ?? '' );
        return $this->db->findAll($sql, $this->getEntityName(), $params);
    }

    /**
     * @param array $params
     * @return \PDOStatement
     */
    public function findByParams(array $params) {
        $table = static::tableName();
        $conditions = $this->findConditions($params);
        $sql = "SELECT * FROM {$table} {$conditions}";
        return $this->db->find($sql, $this->getEntityName(), $params);
    }

    /**
     * Поиск записей по условию
     * @param $params
     * @return string
     */
    private function findConditions($params) {
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
     * @param $entity Entity
     */
    public function delete(Entity $entity) {
        if (!is_null($entity->id)) {
            $table = $this->tableName();
            $sql = "DELETE FROM {$table} WHERE id=:id";
            $this->db->execute($sql, [':id' => $entity->id]);
        }
    }

    /**
     * Сохранение данных в базу
     * @param $entity Entity
     * @return int
     */
    public function save(Entity $entity) {
        $table = $this->tableName();
        $params = $this->prepareData($entity);

        if (is_null($entity->id)) {
            $fields = implode(',', $params['keys']);
            $keys = implode(',', array_keys($params['keys']));
            $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$keys})";
            $this->db->execute($sql, $params['values']);

            return $entity->id = $this->db->lastInsertId();
        } else {
            $keys = implode(',', $params['keys']);
            $sql = "UPDATE $table SET {$keys} WHERE id={$entity->id}";
            $this->db->execute($sql, $params['values']);

            return $entity->id;
        }
    }

    /**
     * Подготовка полей для insert или update
     * @param Entity $entity
     * @return array
     */
    private function prepareData(Entity $entity) {
        $res = [];
        $fields = get_object_vars($entity);
        $isUpdate = (bool)$entity->id;

        foreach ($fields as $k => $v) {
            if ($k == 'id') continue;
            if ( $isUpdate ) {
                $res['keys'][":$k"]= "`$k` = :$k";
            } else {
                $res['keys'][":$k"]= "`$k`";
            }
            $res['values'] ["$k"] = $entity->$k;
        }
        return $res;
    }
}