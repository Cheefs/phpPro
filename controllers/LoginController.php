<?php

namespace app\controllers;

use app\helpers\Helper;
use app\models\entities\User;
use app\models\repositories\UserRepository;

class LoginController extends Controller {

    public function actionIndex() {
        $user_id = $this->session->get('user_id');
        if ( $user_id ) {
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

                return $user->is_admin ? $this->redirect('admin') :
                    $this->actionPersonal();
            }
            $error = true;
        }

        return $this->render('loginForm', [
            'error' => $error?? false
        ]);
    }

    public function actionRegister() {
        $user = new User();
        if ($_SERVER['REQUEST_METHOD'] === POST && count($_POST)) {
            $user->load($_POST);
            if ($user->validate()) {
                $repository = new UserRepository();
                $user->password = Helper::getHash($user->password);
                $id = $repository->save($user);
                $this->session->add(['user_id' => $id]);
                return $this->actionPersonal();
            }
            $error = true;
        }

        return $this->render('registerForm', [
            'user' => $user,
            'error' => $error?? false
        ]);
    }

    public function actionExit() {
        $this->session->remove('user_id');
        return $this->redirect('index', 'default');
    }

    public function actionPersonal() {
        // так как личный кабинет не реализован, просто не пускаем обратно на логин
       return $this->redirect('users');
    }
}