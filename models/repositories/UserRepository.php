<?php

namespace app\models\repositories;

use app\models\entities\User;

class UserRepository extends Repository {

    /**
     * @return mixed|string
     */
    public static function tableName() {
        return 'users';
    }
    protected function getEntityName() {
       return User::class;
    }

    /**
     * @param $id
     * @return \PDOStatement
     */
    public function isAdmin($id) {
        $table = self::tableName();
        $admin = User::ADMIN;
        $sql = "SELECT * FROM {$table} WHERE id = :id AND is_admin = :is_admin";
        return $this->db->find($sql, User::class, [':id' => $id, 'is_admin' => $admin]);
    }
}