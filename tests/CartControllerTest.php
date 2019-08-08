<?php

namespace app\tests;

use app\controllers\CartController;
use app\models\repositories\CartRepository;
use PHPUnit\Framework\TestCase;

class CartControllerTest extends TestCase {

    /**
     * @param $session
     * @dataProvider indexProvider
     */
    public function testActionIndex($session) {
        $cartItems = $session[CartController::PRODUCT];
        $cartTotal = (new CartRepository())->getTotalCartPrice($cartItems?? []);
        $this->assertIsArray($cartTotal);
        $this->assertArrayHasKey('count', $cartTotal);
        $this->assertIsNumeric($cartTotal['count']);
        $user_id = $session['user_id'];

        if ($user_id) {
            $this->assertNotNull($user_id);
        }
    }

    public function indexProvider() {
        return [
            [
                [
                    'user_id' => 1,
                    CartController::PRODUCT => [ ]
                ]
            ],
            [ CartController::PRODUCT => [ ['count' => 1 ], ['count' => 55 ]  ] ],
        ];
    }

    /**
     * @param $id
     * @param $items
     * @dataProvider deleteProvider
     */
    public function testActionDelete($id, $items ) {
        $cartItems = $items;
        $this->assertIsArray($cartItems);

        if (isset($cartItems[$id])) {
            $this->assertArrayHasKey($id, $cartItems);
            $item = $cartItems[$id];
            $this->assertNotNull($item);

            if ($item['count'] > 1) {
                $this->assertGreaterThanOrEqual(1, $item['count']);
                $item['count']--;
                $cartItems[$id] = $item;
            } else {
                $this->assertEquals(1, $item['count']);
                $cartItems = array_filter($cartItems, function ($el) use ($item) {
                    return $el['id'] != $item['id'];
                });
                $this->assertArrayNotHasKey($id, $cartItems);
            }
        }
        $this->assertArrayNotHasKey($id, $cartItems);
    }

    public function deleteProvider() {
        return [
            [ 55, [ 1, ['count' => 2 ]] ],
            [ 1, [ 1, [ 'count' => 1 ] ]],
            [ 4, [ 4, ['count' => 2 ]] ],
        ];
    }
}