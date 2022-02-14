<?php

namespace app\core;

class Application {
    public static string $APP_ROOT;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public static Controller $controller;
    public static Database $db;

    public function __construct($app_root) {
        self::$APP_ROOT = $app_root;
        self::$app = $this;
        self::$db = new Database();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request,$this->response);    
    }

    public function run() {
        echo $this->router->resolve();
    }

    public function getController(): \app\core\Controller {
        return $this->controller;
    }
    public function setController(\app\core\Controller $controller): void {
        $this->controller = $controller;
    }
}


?>