<?php

namespace app\models;
/**
 * @property string $first_name
 * @property string $last_name
 * @property string $second_name
 * @property string $email
 * @property string $phone
 *
*/
class User extends Model {
    protected $username;
    protected $password;

    public $first_name;
    public $last_name;
    public $second_name;
    public $email;
    public $phone;

    public $is_guest = false;

    /**
     * @return mixed|string
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * @param string $username
     */
    public function setUserName(string $username) {
        $this->username = $username;
    }

    public function getUserName(){
        return $this->username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password) {
        $this->password = $this->getPasswordHash($password);
    }

    /**
     * @return bool
     */
    public function isGuest() {
        return $this->is_guest;
    }

    /**
     * Получение корзины пользователя
     * @return array
     */
    public function getCart() {
        return Cart::findAll([
            'user_id' => $this->id,
        ]);
    }

    /**
     * @return bool
     */
    private function auth() {
        $isGuest = false;
        $userName = htmlspecialchars(strip_tags($this->username));
        $password = htmlspecialchars(strip_tags($this->password));
        $password = $this->getPasswordHash($password);
        /// запрос в базу данных на авторизацию
        /// SELECT FROM users WHERE username = $username AND password = $password
        /// и после удачной выборки присваиваем  $this->id = id
        return true;
    }

    /**
     * @param string $password
     * @return string
     */
    private function getPasswordHash(string $password) {
        return md5($password);
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login (string $username, string $password) {
        $this->setUserName($username);
        $this->setPassword($password);

        return $this->auth();
    }
}