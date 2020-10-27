<?php

class writeErrors
{
    public $err;

    public function __construct()
    {
        $this->err = fopen('errors.txt','w');
    }
}
?>