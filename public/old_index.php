<?php
    //phpinfo();
    session_start();
    require_once __DIR__.'/vendor/autoload.php';
    
    
    $router = new Router();
    print_r($router);
    
    //require_once '../lib/require.php';

?>