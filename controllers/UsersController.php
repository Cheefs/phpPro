<?php

namespace app\controllers;

use app\models\entities\User;
use app\models\repositories\UserRepository;

class UsersController extends Controller {

    /**
     * Переход в личный кабинет
     * @return false|string
     */
    public function actionIndex() {
        $user_id = $this->session->get('user_id');
        if (!$user_id) {
            return $this->returnToLastPage();
        }
        /** @var $user User */
        $user = (new UserRepository)->find($user_id);

        if (!$user) {
            return $this->returnToLastPage();
        }

        if (!$user->is_admin) {
            return $this->render('index', [
                'user' => $user,
            ]);
        } else {
            return $this->redirect('admin');
        }
    }

    /**
     * Просмотр иинформации о пользователе
     * @param $id
     * @return false|string
     */
    public function actionView($id) {
        if (!is_null($id) && is_numeric($id)) {
            $user = (new UserRepository)->find($id);
            if ($user) {
                return $this->render('view', [
                    'user' => $user,
                ]);
            }
        }
        return $this->notFound();
    }

    /**
     * Удаление пользователя из базы
     * @param $id
     * @return string
     */
    public function actionDelete($id) {
        $repository = new UserRepository();
        $user = $repository->find($id);
        if ($user) {
            $repository->delete($user);
        }
        return $this->returnToLastPage();
    }

    /**
     * Сохранение и обновление пользователя
     * @param null $id
     * @return false|string
     */
    public function actionSave($id = null) {
        $repository = new UserRepository();
        $user = $id? $repository->find($id): new User();

        if ($_SERVER['REQUEST_METHOD'] == POST && count($_POST)) {
            $user->load($_POST);
            $repository->save($user);
            return $this->returnToLastPage();
        }

        return $this->render('form', [
            'user' => $user,
        ]);
    }
}
