<?php

namespace app\services;

use PDO;
use app\services\interfaces\IDB;
use app\traits\TSingleton;

/**
 * @property PDO $connect
 * @property array $config
 *
*/
class DB implements IDB {

    use TSingleton;

    private $connect = null;
    private $config = [
        'userName' => 'root',
        'password' => '',
        'dbName' => 'shop',
        'dbHost' => 'localhost',
        'driver' => 'mysql',
        'charset' => 'utf8'
    ];

    /**
     * @return PDO
     */
    public function getConnect() {
        if (is_null($this->connect)) {
            $this->connect = new PDO(
              $this->getDsn(),
              $this->config['userName'],
              $this->config['password']
            );

            $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return $this->connect;
    }

    /**
     * @return string
     */
    private function getDsn() {
        return sprintf('%s:host=%s;dbname=%s;charset=%s',
            $this->config['driver'],
            $this->config['dbHost'],
            $this->config['dbName'],
            $this->config['charset']
        );
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $class
     * @return \PDOStatement
     */
    private function query(string $class, string $sql, array $params = []) {
        $PDOStatement = $this->getConnect()->prepare($sql);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class );
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $class
     * @return mixed
     */
    public function find(string $class, string $sql, array $params = []) {
        return $this->query($class, $sql, $params)->fetch()?? null;
    }

    /**
     * @param string $sql
     * @param string $class
     * @param array $params
     * @return array
     */
    public function findAll(string $class, string $sql, array $params = []) {
        return $this->query($class, $sql, $params)->fetchAll()?? [];
    }

    /**
     * @param string $sql
     * @param string $class
     * @param array $params
     */
    public function execute(string $class, string $sql, array $params = []) {
        $this->query($class, $sql, $params);
    }
}
