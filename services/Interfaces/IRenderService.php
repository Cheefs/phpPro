<?php

namespace app\services\interfaces;

interface IRenderService {
    public function renderTmpl($template, $params = []);
}