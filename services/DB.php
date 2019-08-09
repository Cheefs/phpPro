<?php

namespace app\services;

use PDO;
use app\services\interfaces\IDB;
use app\common\traits\TSingleton;

/**
 * @property PDO $connect
 * @property array $config
 *
*/
class DB implements IDB{
    use TSingleton;

    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

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

            $this->connect->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );
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
    private function query(string $sql, array $params = [], string $class = 'Model') {
        $PDOStatement = $this->getConnect()->prepare($sql);
        $PDOStatement->setFetchMode(
            PDO::FETCH_CLASS,
            $class
        );
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $class
     * @return \PDOStatement
     */
    public function find($sql, $class = null, $params = []) {
        $PDOStatement = $this->query($sql, $params, $class);
        return $PDOStatement->fetch();
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $class
     * @return array
     */
    public function findAll($sql, $class = null, $params = []) {
        $PDOStatement = $this->query($sql, $params, $class);
        return $PDOStatement->fetchAll();
    }

    /**
     * @param string $sql
     * @param array $params
     */
    public function execute(string $sql, array $params = []) {
         $this->query($sql, $params);

    }

    /**
     * @return string
     */
    public function lastInsertId(){
        return $this->getConnect()->lastInsertId();
    }
}