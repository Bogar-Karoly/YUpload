<?php 

namespace app\controllers;

use app\core\Controller;

class ProfileController extends Controller {
    public function onStart() {
        $param = ["text" => "hello world"];
        return $param;
    }
}

?>