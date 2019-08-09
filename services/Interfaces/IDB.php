<?php

namespace app\services\interfaces;

interface IDB {
    public function find($sql, $class = null, $params = []);
    public function findAll($sql, $class = null, $params = []);
}