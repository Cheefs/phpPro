<?php

namespace app\controllers;

use app\helpers\Helper;
use app\services\interfaces\IRenderService;
use Translate;

/**
 * Базоый контроллер который будет хранить общее поведение для всех контроллеров
 * @property IRenderService $renderer
*/
abstract class Controller {
    const ACTION = 'action';
    const CONTROLLER = 'Controller';
    protected $default = 'default';
    protected $renderer;

    public function __construct($renderer) {
        $this->renderer = $renderer;
    }

    public function run(string $action = null, int $id = null) {
        if ($action) {
            $action = self::ACTION.ucfirst($action);
            if (method_exists($this, $action)) {
                $this->beforeAction();
                return $this->$action($id);
            } else {
                return $this->notFound();
            }
        }
        return $this->notFound();
    }

    /**
     * @return mixed
     */
    public function getClassName() {
        return Helper::getClassName(get_called_class());
    }

    /**
     * @return string
     */
    public function getControllerName() {
        $className = $this->getClassName();
        $folder = str_replace(CONTROLLER,'', $className);
        return  strtolower($folder);
    }

    /**
     * @param string $view
     * @param array $params
     * @return false|string
     */
    protected function render(string $view, array $params = []) {
        $viewFolder = $this->getControllerName();
        return $this->renderTemplate(
            $viewFolder.DIRECTORY_SEPARATOR.$view,
            $params
        );
    }

    /**
     * @param string $template
     * @param array $params
     */
    protected function renderTemplate(string $template, array $params = []) {
       return $this->renderer->renderTmpl($template, $params);
    }

    /**
     * @param $action
     */
    public function redirect($action) {
        $controllerName = $this->getControllerName();
        header("Location: /?c=$controllerName&a=$action");
        return;
    }

    /**
     * @return false|string
     */
    protected function notFound() {
      return $this->render('../common/error',[
          'message' => '404 Not Found',
          'translate' => new Translate()
      ]);
    }

    /**
     * Если нам нужно будет выполнять чтото перед экшенами
     */
    protected function beforeAction() {
    }
}