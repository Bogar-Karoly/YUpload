<?php

session_start();

function isLoggedIn () {
    return isset($_SESSION['userId']) ? true : false;
}

?>