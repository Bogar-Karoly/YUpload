<?php

class Home extends Controller {

    public function index() {
        $this->view('Home', null);
    }
    public function profile() {
        $this->view('Profile', null); //or header
    }
}

?>