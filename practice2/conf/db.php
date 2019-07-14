<?php

namespace app\conf;

class DB {
    protected static $userName = 'root';
    protected static $password = '';
    protected static $dbName = 'shop';
    protected static$dbHost = 'localhost';

    /**
     * Параметры коннекта к базе данных
     * @return false|\mysqli
     */
    protected static function dbConnect() {
        $mysqli = mysqli_connect(
            self::$dbHost,
            self::$userName,
            self::$password,
            self::$dbName
        );
        return $mysqli;
    }

    /**
     * @param string $sql
     * @return bool|\mysqli_result|null
     */
    public function getData(string $sql) {
        $connect = $this::dbConnect();
        if ($connect) {
            $result = mysqli_query($connect, $sql);
            mysqli_close($connect);
        }
        return $result ?? null;
    }
}
