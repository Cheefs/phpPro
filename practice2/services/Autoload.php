<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/..');

class Autoload {
    const APP_NAME = 'app';
    const FILE_EXT = '.php';

    /**
     * Подключение файла
     * @param $className
     */
    public function loadClass($className) {
        $file = $this->setPath($className).$this::FILE_EXT;
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
        $nameSpace = $this->replaceDirSeparator($nameSpace);
        return str_replace($this::APP_NAME, ROOT, $nameSpace);
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