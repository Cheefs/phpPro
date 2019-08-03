<?php


namespace app\controllers;


use app\models\entities\Order;
use app\models\repositories\OrderRepository;
use app\models\repositories\ProductRepository;
use app\models\repositories\UserRepository;

class AdminController extends Controller {

    const MODE_USERS_LIST = 0;
    const MODE_ORDERS_LIST = 1;
    const MODE_PRODUCTS_LIST = 2;

    protected function beforeAction() {
        parent::beforeAction();
        $user_id = $this->session->get('user_id');
        if (!$user_id) {
            return $this->redirect('default');
        }

        $check = (new UserRepository())->isAdmin($user_id);
        if (!$check) {
            return $this->redirect('default');
        }
        return true;
    }

    /**
     * @return false|string
     */
    public function actionIndex() {
        $params = [];
//        if ($id == self::MODE_USERS_LIST ) {
//            'users' => (new UserRepository())->findAll()
//
//        } else if ($id == self::MODE_PRODUCTS_LIST) {
//            $params ['products'] = (new ProductRepository())->findAll();
//        } else if ($id == self::MODE_ORDERS_LIST) {
//            $params ['products'] = (new OrderRepository())->findAll();
//        }
//        $params['mode'] = $id;
        $params['controller'] = $this->getControllerName();
        return $this->render('index', $params);
    }

    public function actionUsers() {
        return $this->render('users', [
            'orders' => (new OrderRepository())->findAll(),
            'controller' => $this->getControllerName()
        ]);
    }

    public function actionOrders() {
        $orderStatuses = [
            0 => 'Обрабатывается',
            1 => 'Отправлен',
            2 => 'Доставлен',
            3 => 'Отклонен'
        ];

        return $this->render('order/index', [
            'model' => new Order(),
            'orders' => (new OrderRepository())->findAll(),
            'status' => $orderStatuses,
            'controller' => $this->getControllerName()
        ]);
    }

    public function actionOrder(int $id) {
        /**@var $order Order */
        $order = (new OrderRepository())->find($id);
        if (!$order) {
            return $this->notFound();
        }
        $orderProducts = json_decode($order->products_json);
        $products = [];
        foreach ($orderProducts as $k=>$v) {
            $products[] = $v;
        }

        return $this->render('order/view', [
            'order' => $order,
            'products' => $products,
            'controller' => $this->getControllerName()
        ]);
    }

    /**
     * Отмена заказа, неверные данные, или еще какието причины
     * @param $id
     * @return bool|false|string
     */
    public function actionCancelOrder($id) {
        return $this->setOrder($id, Order::STATUS_CANCEL);
    }

    /**
     * Подтвердить заказ
     * @param $id
     * @return bool|false|string
     */
    public function actionCheckOrder($id) {
        return $this->setOrder($id, Order::STATUS_SEND);
    }

    /**
     * Вспомогательная функция которая меняет статус заказа
     * @param $id
     * @param $orderValue
     * @return bool|false|string
     */
    private function setOrder($id, $orderValue) {
        /**@var $order Order */
        $repository = new OrderRepository();
        $order = $repository->find($id);
        if (!$order) {
            return $this->notFound();
        }
        $order->status = $orderValue;
        $repository->save($order);

        return $this->returnToLastPage();
    }


}