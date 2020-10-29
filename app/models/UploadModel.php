<?php

class UploadModel {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function loadImages($num) {
        $sql = 'SELECT g.Id, g.Ext, g.Name, g.Downloads, u.Username FROM gallery g RIGHT JOIN user u ON g.UserId = u.Id WHERE Visibility = "Public" ORDER BY Id DESC LIMIT ?,?';
        
        $this->db->query($sql);
        $this->db->bind($num);

        if($this->db->execute()) {
            if($result = $this->db->resultAll()) {
                return $result;
            }
        }
        return false;
    }

    public function doesTagExist($tag) {
        $sql = 'SELECT Id FROM tags WHERE tolower(Name) = tolower(?);';

        $array = [];
        array_push($array, $tag);

        $this->db->query($sql);
        $this->db->bind($array);
        $this->db->execute();

        if($this->db->result() > 1) {
            return true;
        } 
        else {
            return false;
        }
    }

    public function getTagId($tag) {
        $sql = 'SELECT Id FROM tags WHERE tolower(Name) = tolower(?);';

        $array = [];
        array_push($array, $tag);

        $this->db->query($sql);
        $this->db->bind($array);

        if($this->db->execute()) {
            return $this->db->result();
        } 
        else {
            return false;
        }
    }

    public function addNewTag($tag) {
        $sql = 'INSERT INTO tags (tagName) VALUES (?);';

        $array = [];
        array_push($array, $tag);

        $this->db->query($sql);
        $this->db->bind($array);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function addTag($tagId,$imageId) {
        $sql = 'INSERT INTO imagetag (TagId, ImageId) VALUES (?,?);';

        $array = [];
        array_push($array, $tagId);
        array_push($array, $imageId);

        $this->db->query($sql);
        $this->db->bind($array);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function upload($data) {
        $sql = 'INSERT INTO gallery (UserId, Name, Visibility, Ext) VALUES (?,?,?,?);';

        $this->db->query($sql);
        $this->db->bind($data);

        if($this->db->execute()) {
            return $this->db->lastInsert();
        }
        return false;
    }
}



?>