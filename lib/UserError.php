<?php

class UserError {
    private static $_errors = [];
    private static $_error_codes = [];

    // init
    function __construct() {
        self::loadErrorCodes();
    }

    // load errors from csv file
    private static function loadErrorCodes() {
        // read csv file
        $fs = new FileStream("user_error_codes.csv", "r");
        if($fs === false)
            return false;
        $content = $fs::read();
        foreach($content as $line) {
            $arr = explode(';',$line);
            self::$_error_codes[$arr[0]] = $arr[1];
        }
    }

    // get number of found errors
    public static function getNumberOfErrors() { return count(self::$_errors); }

    // get errors
    public static function get() { return self::$_errors; }

    // add error by code value
    public static function addErrorCode($code = null) {
        if($code === null || empty($code) || !array_key_exists($code,self::$_error_codes)) {
            // error: no passed value or code doesn't exists
            return false;
        }
        array_push(self::$_errors, self::$_error_codes[intval($code)]);
    }

    // add custom error message
    public static function addCustomError($text) {
        array_push(self::$_errors, [null, $text]);
    }
}

?>