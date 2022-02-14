<?php

namespace app\core;

use PDO;

class Database {
    public $pdo;

    // connects to database
    public function __construct() {
        $host = "";
        $port = "";
        $dbname = "";
        $charset = "utf8";
        $username = "";
        $password = "";

        return;
        $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=$charset", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}

?>