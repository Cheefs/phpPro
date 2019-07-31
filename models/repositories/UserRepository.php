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

}