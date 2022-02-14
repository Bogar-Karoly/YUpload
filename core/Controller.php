<?php

namespace app\core;

class Controller {
    public string $layout = 'default';

    public function setLayout(string $layout) {
        $this->layout = $layout;
    }
    public function render($view, $params = []) {
        return Application::$app->router->renderView($view, $params);
    }
}

?>