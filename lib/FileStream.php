<?php

class FileStream {

    private static $path = "../storage/";

    private static $file;

    function __construct($file, $mode) {
        $file_path = self::$path."$file";
        if(!file_exists($file_path))
            return false;
        self::$file = fopen($file_path, $mode);
        return true;
    }
    // read file, both the filename and the extension needed like: example.csv
    public static function read() {
        if(self::$file === false)
            return false;
        $content = [];
        while(!feof(self::$file)) {
            array_push($content,fgets(self::$file));
        }
        return $content;
    }

    // extending the file content
    public static function write($data = []) {
        if(self::$file === false)
            return false;
        //
    }
    // rewriting the file content
    public static function overWrite($data = []) {
        if(self::$file === false)
            return false;
        //
    }
    // closing the file on object deletion
    function __destruct() {
        if(self::$file !== false)
            fclose(self::$file);
    }
}

?>