<?php

class Database {

    private static $conn;   // database connection
    private static $stmt;   // sql statement

    // connects to database
    function __construct() {
        self::$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die("Database doesn't exists!");
    }

    // executes sql command, also binds params when needed
    public static function execute($params = []) {
        if(!empty($params)) {
            $type = implode('',array_map(function($e) { 
                switch(gettype($e)) {
                    case "string": return "s";
                    case "integer": return "s";
                    case "double": return "d";
                    default: return 's';
                }
            },$params));
            self::$stmt->bind_param($type, ...$params);
        }
        return self::$stmt->execute();
    }

    // prepares sql command
    public static function prepare($sql) {
        self::$stmt = self::$conn->prepare($sql);
        if(self::$stmt === false)
            return false;
        return true;
    }

    // returns all rows
    public static function all() {
        $result = self::$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // get query result, like num_rows, field_count...
    public static function getResult() {
        return self::$stmt->get_result();
    }

    // get first row from query
    public static function getFirst() {
        return mysqli_fetch_assoc(self::$stmt->get_result());
    }

    // get last inserted row id
    public static function getLastId() {
        return self::$stmt->insert_id;
    }

    // closes database connection
    function __destruct() {
        self::$stmt->close();
        self::$conn->close();
    }
}

?>