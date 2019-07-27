<?php

namespace app\controllers;

use app\models\User;
use Translate;

class UsersController extends Controller {

    /**
     * Список пользователей
     * @return false|string
     */
    public function actionIndex() {
        $users = User::findAll();
        return $this->render('index', [
            'users' => $users,
            'translate' => new Translate(),
            'controller' => $this->getControllerName()
        ]);
    }

    /**
     * Просмотр иинформации о пользователе
     * @param $id
     * @return false|string
     */
    public function actionView($id) {
        if (!is_null($id) && is_numeric($id)) {
            $user = User::find($id);
            if ($user) {
                $cart = $user->getCart();
                return $this->render('view', [
                    'user' => $user,
                    'cart' => $cart,
                    'controller' => $this->getControllerName(),
                    'translate' => new Translate(),
                ]);
            }
        }
        return $this->notFound();
    }

    /**
     * Удаление пользователя из базы
     * @param $id
     */
    public function actionDelete($id) {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        $this->redirect('index');
    }

    /**
     * Сохранение и обновление пользователя
     * @param null $id
     * @return false|string
     */
    public function actionSave($id = null) {
        $user = $id? User::find($id) : new User();


        if ($_SERVER['REQUEST_METHOD'] == POST && count($_POST)) {
//            var_dump($_POST); die();
            $user->load($_POST);
            $user->save();
            $this->redirect('index');
        }

        return $this->render('form', [
            'user' => $user,
            'translate' => new Translate(),
            'controller' => $this->getControllerName(),
        ]);
    }
}
