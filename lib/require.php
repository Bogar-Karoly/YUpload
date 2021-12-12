<?php

    $libs = scandir(__DIR__);
    if($libs === false)
        http_response_code(404);

    require_once '../config/config.php';
    $libs = array_diff($libs, [".",".."]);
    array_map(function($e) {
        require_once($e);
    }, $libs);

    $core = new Core;

?>