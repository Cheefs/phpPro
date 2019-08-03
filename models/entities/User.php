<?php


namespace app\models\entities;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $second_name
 * @property string $email
 * @property string $phone
 * @property int $is_admin
 */
class User extends Entity {

    const ADMIN = 1;

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $second_name;
    public $email;
    public $phone;
    public $is_admin;
}