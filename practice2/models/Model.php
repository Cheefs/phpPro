<?php

namespace app\models;

use app\conf\DB;
use app\helpers\StringConvertHelper;

abstract class Model {
    const HTML_SPACE = '&nbsp;';
    const MODE_INSERT = 0;
    const MODE_UPDATE = 1;

    protected $id;

    public function getUserId() {
        return $this->id;
    }

    /**
     * Получение всех свойств класса
     * @return array
     */
    private function getFieldLists() {
        return get_class_vars(static::class);
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
     * Функция для установки названия таблици базы данных для класса
     * @return mixed
     */
    public abstract static function tableName();

    /**
     * Название класса
     * @return mixed
     */
    public static function className() {
        $class = explode( '\\', static::class);
        return $class[count($class) - 1];
    }

    /**
     * Выполнение SQL запроса
     * @param $sql
     * @return bool|\mysqli_result
     */
    protected static function sqlQuery($sql) {
        $dbConnect = new DB();
        return $dbConnect->getData($sql);
    }

    /**
     * Поиск в базе по id записи
     * @param int $id
     * @return array|null
     */
    public static function findById(int $id) {
        $table = static::tableName();
        $sql = "SELECT * FROM {$table} WHERE id = {$id}";
        $data = static::sqlQuery($sql);

        return $data ? mysqli_fetch_assoc($data) : null;
    }

    /**
     * Поиск всех записей в таблице
     * @return array
     */
    public static function findAll() {
       $table = static::tableName();
       $sql = "SELECT * FROM {$table}";
       $data = static::sqlQuery($sql);

       if ($data) {
           while ($row = mysqli_fetch_assoc($data)) {
               $rows[] = $row;
           }
       }
       return $rows?? [];
    }

    /**
     * Функция которая принимает на вход массив типа Key => Value и строит запрос на основании переданных параметров
     * @param array $params
     * @return array|null
     */
    public static function find(array $params) {
        if (count($params)) {
           $sqlParams = static::prepareParamsToSql($params);
            $table = static::tableName();
            $sql = "SELECT * FROM {$table}{$sqlParams}";
            $data = static::sqlQuery($sql);
        }
        return $data ? mysqli_fetch_assoc($data) : null;
    }

    /**
     * Сохранение или обновление записи в базе данных
     * @return bool|\mysqli_result
     */
    public function save() {
        $table = static::tableName();
        if (is_null($this->id)) {
            $params = $this->prepareData(self::MODE_INSERT);
            $keys = implode(',',$params['keys']);
            $values = implode(',',$params['values']);
            $sql = "INSERT INTO $table ({$keys}) VALUES ({$values})";
        } else {
            $params = $this->prepareData(self::MODE_UPDATE);
            $sql = "UPDATE $table SET {$params} WHERE id = {$this->id}";
        }

        return static::sqlQuery($sql);
    }

    /**
     * Подготовка полей для более удобного insert или update
     * @param $mode int
     * @return array
     */
    private function prepareData($mode) {
      $fields = $this->getFieldLists();

      $exitParams = [];
      if ($mode == self::MODE_INSERT) {
          foreach ($fields as $k => $v) {
              if ($k !== 'id') {
                  $exitParams['keys'][] = StringConvertHelper::camelCaseToSnakeCase($k);
                  $exitParams['values'][] = $this->$k;
              }
          }
      } else {
          foreach ($fields as $k => $v) {
              if ($k !== 'id') {
                  $exitParams[] = StringConvertHelper::camelCaseToSnakeCase($k) .' = '. $this->$k;
              }
          }
          $exitParams = implode(',', $exitParams);
      }

      return $exitParams;
    }

    /**
     * Подготовка запроса по параметрам
     * @param array $params
     * @return string
     */
    private static function prepareParamsToSql(array $params) {
        $sql = ' WHERE ';
        $count = 0;
        foreach ($params as $k => $v) {
            $count ++;
            $prefix = $count < count($params)? ' AND ' : '';
            $sql .= $k . ' = ' . $v . $prefix;
        }
        return $sql;
    }
}