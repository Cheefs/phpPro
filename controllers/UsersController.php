<?php

namespace app\controllers;

use app\models\entities\User;
use app\models\repositories\OrderRepository;
use app\models\repositories\OrderStatusRepository;
use app\models\repositories\UserRepository;

class UsersController extends Controller {

    /**
     * Переход в личный кабинет
     * @return false|string
     */
    public function actionIndex() {
        $user_id = $this->session->get('user_id');
        /** @var $user User */
        $repository = new UserRepository();
        $user = $repository->find($user_id);

        if ($_SERVER['REQUEST_METHOD'] == POST && count($_POST)) {
            $user->load($_POST);
            $repository->save($user);
        }

        if ($user) {
            return $user->is_admin? $this->redirect('admin') :
               $this->render('index', [
                  'user' => $user
            ]);

        }
        return $this->redirect('default');
    }

    public function actionOrders() {
        $user_id = $this->session->get('user_id');
        if ($user_id) {
            $repository = new OrderRepository();
            $orders = $repository->findAll(['user_id' => $user_id]);
            $repository->prepareOrders($orders);
           return $this->render('orders', [
               'orders' => $orders,
               'status' => (new OrderStatusRepository())->getStatusesArr(),
           ]);
        }
        return $this->redirect('default');
    }

    public function actionOrder($id) {
        $repository = new OrderRepository();
        $order[] = $repository->find($id);
        if ($order) {
            $repository->prepareOrders($order);
            return $this->render('order', [
                'order' => $order[0],
                'status' => (new OrderStatusRepository())->getStatusesArr(),
            ]);
        }
        return $this->redirect('default');
    }
}
