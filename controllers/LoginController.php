<?php

namespace app\controllers;

use app\helpers\Helper;
use app\models\entities\User;
use app\models\repositories\UserRepository;

class LoginController extends Controller {

    public function actionIndex() {
        $user_id = $this->session->get('user_id');
        if ($user_id ) {
            return $this->actionPersonal();
        }

        if ($_SERVER['REQUEST_METHOD'] === POST && count($_POST)) {
            /** @var $user User */
            $user = (new UserRepository())->findByParams([
                'username' => $_POST['username'],
                'password' => Helper::getHash($_POST['password'])
            ]);

            if ($user) {
                $this->session->add(['user_id' => $user->id]);
                return $this->actionPersonal();
            }
        }

        return $this->render('loginForm', [
            'controller' => self::getControllerName()
        ]);
    }

    public function actionRegister() {
        if ($_SERVER['REQUEST_METHOD'] === POST && count($_POST)) {
            $user = new User();
            $user->load($_POST);
            $repository = new UserRepository();
            $id = $repository->save($user);

            $this->session->add(['user_id' => $id]);
            return $this->actionPersonal();
        }

        return $this->render('registerForm', [
            'controller' => self::getControllerName()
        ]);
    }

    public function actionExit() {
        $this->session->remove('user_id');
        return $this->redirect('index', 'default');
    }

    public function actionPersonal() {
        // так как личный кабинет не реализован, просто не пускаем обратно на логин
       return $this->redirect('index', 'default');
    }
}