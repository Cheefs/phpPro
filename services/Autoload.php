<?php

class Autoload {
    /**
     * Подключение файла
     * @param $className
     */
    public function loadClass($className) {
        $file = $this->setPath($className).FILE_EXT;
        if (file_exists($file)) {
            include $file;
        }
    }

    /**
     * Получение пути к файлу
     * @param $nameSpace
     * @return mixed
     */
    protected function setPath($nameSpace) {
        $root = $_SERVER['DOCUMENT_ROOT'] .'/..';
        $nameSpace = $this->replaceDirSeparator($nameSpace);
        return str_replace(APP_NAME, $root, $nameSpace);
    }

    /**
     * Замена слешей
     * @param $nameSpace string строка пространства имен
     * @return mixed
     */
    protected function replaceDirSeparator($nameSpace) {
        return str_replace('\\','/',$nameSpace);
    }
}