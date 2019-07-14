<?php

namespace app\models;

class User extends Model {

    protected $userName;
    protected $password;
    protected $isGuest = true;

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
        $this->userName = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password) {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isGuest() {
        return $this->isGuest;
    }

    /**
     * @return bool
     */
    private function auth() {
        $isGuest = false;
        $userName = htmlspecialchars(strip_tags($this->userName));
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