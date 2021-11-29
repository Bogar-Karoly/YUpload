<?php

class UserError extends ReadFile {
    private $_errors = [];
    private $_error_codes = [];

    // init
    function __construct() {
        self::loadErrorCodes();
    }

    // load errors from csv file
    private static function loadErrorCodes() {
        // read csv file
        $content = parent::read("user_error_codes.csv");
        foreach($content as $line) {
            $arr = explode(';',$line);
            array_push($_error_codes, [$arr[0] => $arr[1]]);
        }
    }

    // get number of found errors
    public static function getNumberOfErrors() { return count(self::$_errors); }
    public static function get() { return self::$_errors; }

    // add error by code value
    public static function addErrorCode($code = null) {
        if($code === null || empty($code) || array_key_exists($code,self::$_error_codes)) {
            // error: no passed value or code doesn't exists
            return false;
        }
        array_push(self::$_errors, self::getErrorByCode($code));
    }

    // get error value by code value
    private static function getErrorByCode($code) {
        return array_filter(self::$_error_codes, function($e) use ($code) { return $e['code'] === $code; })[0];
    }

    // add custom error message
    public static function addCustomError($text) {
        array_push(self::$_errors, [null, $text]);
    }
}

?>