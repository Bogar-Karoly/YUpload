<?php

class Database {

    private $conn;
    private $stmt;
    private $error;

    public function __construct() {
        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $name = DB_NAME;

        $this->conn = new mysqli($host,$user,$pass,$name) or $this->error ='The {$this->name} database does not exists!';
    }

    public function result() {
        return mysqli_fetch_assoc($this->stmt->get_result());
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function bind($data) {
        $param = '';
        foreach ($data as $key => $value) {
            switch($value) {
                //case is_bool($value): $param = PDO::PARAM_BOOL; break;
                case is_double($value): $param .= 'd'; break;
                case is_int($value): $param .= 'i'; break;
                //case is_null($value): $param .= PDO::PARAM_NULL; break;
                default: $param .= 's'; break;
            }
        }
        $this->stmt->bind_param($param, ...$data);
    }

    public function query($sql) {
        $this->stmt = $this->conn->prepare($sql);
    }

    /*
    public function query($sql,$array) {

        $types = $this->bindType($array);

        $stmt = $this->conn->stmt_init();
        $stmt->prepare($sql);

        $stmt->bind_param($types, ...$array);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();
        $this->conn->close();

        return $data;
    }
    
    public function execute() {
        return $this->command->execute();
    }
    */
}

?>