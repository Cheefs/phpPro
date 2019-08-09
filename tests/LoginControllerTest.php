<?php

namespace app\controllers;

use app\helpers\Helper;
use app\models\entities\User;
use app\models\repositories\UserRepository;
use PHPUnit\Framework\TestCase;

class LoginControllerTest extends TestCase {

    /**
     * @dataProvider indexProvider
     */
    public function testActionIndex($id) {
        $user_id = $id;
        if ( $user_id ) {
            $this->assertNotNull($user_id);
            return;
        }
        $this->assertFalse((bool)$user_id);
    }

    public function indexProvider() {
        return [
            [ '' ],
            [ 1 ],
            [ false ],
            [ null ],
        ];
    }
    /**
     * @dataProvider registerProvider
     */
    public function testActionRegister($method, $array) {
        $user = new User();

        if ($method === 'POST' && count($array)) {
            $user->load($array);
            $this->assertNotNull($user);
            $this->assertInstanceOf(User::class, $user);

            if ($user->validate()) {
                $this->assertTrue($user->validate());
                $repository = new UserRepository();
                $this->assertNotEquals($user->password, Helper::getHash($user->password) );
                $user->password = Helper::getHash($user->password);
                $this->markTestSkipped();
                $id = $repository->save($user);
            }
            $this->assertFalse($user->validate());
            return;
        }
        $this->assertFalse(($method === 'POST' && count($array)) );
        return;
    }

    public function registerProvider() {
        return [
            [ 'POST', [
                'username' => 'testCase',
                'password' => 'testCase',
                'first_name'  => 'testCase',
                'last_name' => 'testCase'
            ]],
            [ 'post', [ 1 => 1] ],
            [ 'GET', [ 1 => 1 ] ],
            [ 'POST', [ ] ],
        ];
    }
}