<?php

class Controller{
    public function model($model) {

        require_once '../app/models/'.$model.'.php';
        return new $model();
    }

    public function view($view,$data = []) {

        if(file_exists('../app/views/'.$view.'.php')) {
            require_once '../app/views/'.$view.'.php';
        }
        else {
            die('The '.$view.' view does not exists');
        }
    }
    public function image($imageId,$type) {

        if(file_exists('../app/images/'.$imageId.'.'.$type)) {
            return file_get_contents('../app/images/'.$imageId.'.'.$type);
        }
        else {
            die('The '.$imageId.'.'.$type.' image does not exists!');
        }
    }
    public function redirect($url) {
        header('Location: '.URL_ROOT.'/'.$url);
    }
}

?>