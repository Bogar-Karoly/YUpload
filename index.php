<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', TRUE); 
    ini_set('display_startup_errors', TRUE);
    //error_reporting(E_ALL ^ E_NOTICE);  

    require_once __DIR__.'/vendor/autoload.php';

    use app\core\Application;

    $app = new Application(__DIR__);
    $app->run();

    exit();
?>