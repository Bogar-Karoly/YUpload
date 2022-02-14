<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\core\Response;

class PageController extends Controller {
    public function profile() {
        $params = [
            'asd' => "sadeg"
        ];
        return $this->render('profile', $params);
    }
    public function home() {
        $params = [
            'page' => "home"
        ];
        return $this->render('home', $params);
    }
    public function contact() {
        return $this->render('contact');
    }
    public function contactHandler(Request $request) {
        $body = $request->getBody();
        echo '<pre>';
        var_dump($body);
        echo '</pre>';

        return 'Handling submited data!';
    }
}

?>