<?php

$host = 'localhost';
$username = 'admin';
$password = 'admin';
$database = 'upload';

$conn = new mysqli($host,$username,$password,$database) or die('The {$database} database does not exists!');

?>