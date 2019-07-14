<?php

namespace app\models;

/**
 * @property string $firstName
 * @property string $lastName
 * @property string $secondName
 * @property string $email
 * @property string $phone
 */
class Customer extends User {

    public $firstName;
    public $lastName;
    public $secondName;
    public $email;
    public $phone;

    /**
     * @return mixed|string
     */
    public static function tableName() {
        return 'customer';
    }

    /**
     * @return string
     */
    public function getFullName () {
        return $this->lastName.self::HTML_SPACE.$this->firstName.self::HTML_SPACE.$this->secondName;
    }

    /**
     * @param int $id
     * @return array|null
     */
    public static function findById(int $id) {
        $table = static::tableName();
        $parentTable = parent::tableName();
        $sql = "SELECT * FROM {$table} t inner join {$parentTable} pt WHERE pt.id = {$id}";
        $data = static::sqlQuery($sql);

        return $data ? mysqli_fetch_assoc($data) : null;
    }

    /**
     *
     */
    public function getCart() {
        $id = $this->getUserId();
        /// Select * from cart Where user_id = $id
    }

    /**
     * Переопределим метот login, но используем стандартный сценарий родительского класса
     * чтобы не повторятся, и если родительский метод вернет истину, мы заполним нашего Клиента его персональными данными
     * @param string $username
     * @param string $password
     * @return bool|void
     */
    public function login(string $username, string $password){
        if ( parent::login($username, $password) ) {
            $this->getPersonalData($this->id);
        }
    }
}
