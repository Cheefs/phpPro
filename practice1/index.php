<?php
/**
 *       1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.
 *       2. Описать свойства класса из п.1 (состояние).
 *       3. Описать поведение класса из п.1 (методы).
 *
 * @property int $id;
 * @property string $userName;
 * @property string $password;
*/
class User {
    const HTML_SPACE = '&nbsp;';

    protected $id;
    private $userName = 'asd';
    private $password;
    private $guest = true;

    public function getUserId() {
        return $this->id;
    }
    public function setUserName(string $username) {
        $this->userName = $username;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function isGuest() {
        return $this->guest;
    }

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

    private function getPasswordHash(string $password) {
        return md5($password);
    }

    public function login (string $username, string $password) {
       $this->setUserName($username);
       $this->setPassword($password);

       return $this->auth();
    }
}


/**
 *  4. Придумать наследников класса из п.1. Чем они будут отличаться?
 *
 * @property string $firstName
 * @property string $lastName
 * @property string $secondName
*/
class Customer extends User {

    private $firstName;
    private $lastName;
    private $secondName;
    private $email;
    private $phone;

    public function getFullName () {
        return $this->lastName.self::HTML_SPACE.$this->firstName.self::HTML_SPACE.$this->secondName;
    }

    private function getPersonalData(int $id) {
        /// Снова запрос в какуюто базу за данными пользователя
        /// Select * from customer Where user_id = $id
        /// и если данные были найденны просто заполняем, в противном случае можнео кинуть исключение
    }

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


/**  5. Дан код:
 *      Что он выведет на каждом шаге? Почему?
 */
  class A {
      public function foo() {
          static $x = 0;
          echo ++$x; // В вызове делаем ПреИнкримент( тоесть изменяем значение переменной до операции над ней)
      }
  }
  $a1 = new A();
  $a2 = new A();
  $a1->foo(); // на выходе получаем 1
// Статические переменные, они устроенны таким образом, что они инициализируются единожды, а далее смотрят
// если в переменной уже есть значение, он подставить то что уже существует
// да мы создаем новый обьект класса, но метод остается не имзенным, и используем его же, в котором уже есть значение переменной
// которое равное 1, и исходя из этого получаем вывод 1234
  $a2->foo(); // 2
  $a1->foo(); // 3
  $a2->foo(); // 4

echo '<hr>';
/**      Немного изменим п.5:
 *  6. Объясните результаты в этом случае.
 */
  class newA {
      public function foo() {
          static $x = 0;
          echo ++$x;
      }
  }
  class B extends newA {
      // наша foo eще не инициализированна, и статическая пеерменная небыла создана для этого обьекта
  }
  /// В данном случае мы унаследовали все с класса newA и его все методы НО
  /// теперь, метод foo класса newA  и класса B являются разными сущьностями, и у каждого будет своя статическая переменная
  /// т.е. мы создали новый Чистый обьект B на основании класса newA, и в этом обьекте мы еще не вызывали эту функцию, она была вызвана только в обьекте A
  /// в результате получим 1122
  $newA = new newA();
  $b = new B();
  $newA->foo(); // 1
  $b->foo(); // 1
  $newA->foo(); // 2
  $b->foo(); // 2

echo '<hr>';

/** 7. *Дан код:
 * Что он выведет на каждом шаге? Почему?
 *
 * Вывод будет аналогичен 6му пункту, так как различия между new newA() и  new lastA лиш в вызове конструктора,
 * ( который у нас не реализован ) в первом случае он бы вызвался и инициализировал свойства обьекта так как мы бы задали в конструкторе,
 * а во втором случае этого не произошло бы, и все свойства остались бы неинициализированы ( останутся пустыми )
 *
 * Тоесть на выходе получаем все теже 1122
 *
 */
  class lastA {
      public function foo() {
          static $x = 0;
          echo ++$x;
      }
  }
  class lastB extends lastA {
  }
  $lastA = new lastA;
  $lastB = new lastB;
  $lastA->foo(); // 1
  $lastB->foo(); // 1
  $lastA->foo(); // 2
  $lastB->foo(); // 2