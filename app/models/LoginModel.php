<?php

class LoginModel {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function setNewPassword($email,$password) {
        $sql = 'UPDATE user SET Password = ? WHERE Email = ?;';

        $array = [$password,$email];

        $this->db->query($sql);
        $this->db->bind($array);

        if($this->db->execute()) {
                return true;
        }
        return false;
    }

    public function verify($vkey) {
        $sql = 'SELECT Vkey FROM user WHERE Verified = false AND Vkey = ?;';

        $array = [];
        array_push($array, $vkey);

        $this->db->query($sql);
        $this->db->bind($array);

        if($this->db->execute()) {
            if($this->db->result()) {
                $sql = 'UPDATE user SET Verified = true WHERE Vkey = ?;';

                $this->db->query($sql);
                $this->db->bind($array);
                
                if($this->db->execute()) {
                    return true;
                }
            }
        }
        return false;
    }

    public function emailExist($data) {
        $sql = 'SELECT * FROM user WHERE Email = ?;';

        $array = [];
        array_push($array, $data);

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
        $sql = 'INSERT INTO user (Username,Email,Password,Vkey) VALUES (?,?,?,?)';

        $array = [];
        array_push($array, $data['username'], $data['email'], $data['password'], $data['vkey']);

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