<?php

namespace app\core;

class Page {
    public Array $slugs = [];
    public Array $param = [];

    function __construct($content, $filename) {
        $this->filename = explode('.',$filename)[0];
        if(!empty($content)) {
            foreach($content as $param) {
                list($key, $value) = explode('=', $param);
                $key = str_replace('"','',trim($key));
                $value = str_replace('"','',trim($value));
                $this->param[$key] = $value;
            }
        }
        if(isset($this->param['functions'])) {
            $controller = 'app\controllers\\'.$this->param['functions'];
            Application::$controller = new $controller;
        }

    }
    public function setSlugs(Array $slugs) {
        $this->slugs = $slugs;
    }
    public function getPathAsArray() { return array_values(array_filter(explode('/',rtrim($this->url,'/')))); }
    public function setBody($param) { $this->body = $param; }
}

?>