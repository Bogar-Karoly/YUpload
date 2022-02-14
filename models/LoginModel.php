<?php

class LoginModel {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function emailExist($data) {
        $sql = 'SELECT * FROM user WHERE Email = ?;';

        $array = [];
        array_push($array, $data['email']);

        $this->db->query($sql);
        $this->db->bind($array);
        $this->db->execute();

        if($this->db->result()) {
            return true;
        } else {
            return false;
        }
    }

    public function userNameExist($data) {
        $sql = 'SELECT * FROM user WHERE Username = ?;';

        $array = [];
        array_push($array, $data['username']);

        $this->db->query($sql);
        $this->db->bind($array);

        $this->db->execute();

        if($this->db->result()) {
            return true;
        } else {
            return false;
        }
    }

    public function registration($data) {
        $sql = 'INSERT INTO user (Username,Email,Password,Authority) VALUES (?,?,?,1)';

        $array = [];
        array_push($array, $data['username'], $data['email'], $data['password']);

        $this->db->query($sql);
        $this->db->bind($array);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($data) {
        $sql = 'SELECT * FROM user WHERE Email = ?;';

        $array = [];
        array_push($array, $data['email']);

        $this->db->query($sql);
        $this->db->bind($array);

        $this->db->execute();

        if($result = $this->db->result()) {
            if(password_verify($data['password'],$result['Password'])) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

?>