<?php

namespace app\services\interfaces;

interface IDB {
    public function find(string $class, string $sql, array $params = []);
    public function findAll(string $class, string $sql, array  $params = []);
}