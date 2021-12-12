<?php

class Core {
    protected $currentController = 'Home';
    protected $currentMethod = 'index';
    protected $params = [];

    function __construct() {
        $url = $this->getUrl(); 

        // check if controller file exists
        if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        require_once '../app/controllers/'.$this->currentController.'.php';
        if(class_exists($this->currentController))
            $this->currentController = new $this->currentController;
        else
            //error

        if(isset($url[1])) {
            if(method_exists($this->currentController,$url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
    }
    /** 
     * get params as array from url
     *  first index is the name of the controller class
     *  second index is the name of the method of the class
     *  other indexes are the params, like product id, category id...etc
     */ 
    private function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/',$url);
            return $url;
        }
    }
}

?>