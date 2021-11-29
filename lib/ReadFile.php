<?php

class ReadFile {

    // read file, both the filename and the extension needed like: example.csv
    public static function read($file) {
        $file_path = "../storage/readables/$file";
        if(file_exists($file_path)) {
            if($file = fopen($file_path, "r")) {
                $content = [];
                while(feof($file)) {
                    array_push($content,fgets($file));
                }
                return $content;
            }
        }
        return false;
    }
}

?>