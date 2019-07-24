<?php

namespace app\services;

use app\services\interfaces\IRenderService;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigRenderService implements IRenderService {

    public function renderTmpl(string $template, array $params = []) {
        $loader = new FilesystemLoader(ROOT.'views');
        $twig = new Environment($loader);
        echo $twig->render($template.'.twig', $params);
    }
}