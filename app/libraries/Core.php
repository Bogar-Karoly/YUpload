<?php

class Core {
    protected $currentController = 'Home';
    protected $currentMethod = 'index';
    protected $params = [];

    function __construct() {

        $url = $this->getUrl();
        
        if ($url[0] == 'api') {
            unset($url[0]);

            if(file_exists('../app/controllers/apiControllers/'.ucwords($url[1]).'.php')) {
                $this->currentController = ucwords($url[1]);
                unset($url[1]);
            }

            require_once '../app/controllers/apiControllers/'.$this->currentController.'.php';

            $this->currentController = new $this->currentController;

            if(isset($url[2])) {
                if(method_exists($this->currentController, $url[2])) {
                    $this->currentMethod = $url[2];
                    unset($url[2]);
                }
            }

            $this->params = $url ? array_values($url) : [];

            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } 
        else
        {
            if (file_exists('../app/controllers/'.ucwords($url[0]).'.php')) {
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }

            require_once '../app/controllers/'.$this->currentController.'.php';

            $this->currentController = new $this->currentController;

            if (isset($url[1])) {
                if (method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            $this->params = $url ? array_values($url) : [];

            call_user_func_array([$this->currentController,$this->currentMethod], $this->params);
        }
    }
    private function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');

            $err = fopen('../app/config/errors.txt','w');
                fwrite($err, $url.'\n');

            fclose($err);
            


            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/',$url);

            

            return $url;
        }
        else
        {
            return $url = ['Home','index'];;
        }
    }
}

?>