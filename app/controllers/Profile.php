<?php

class Profile extends Controller {

    public function __construct() {
        //$this->imageModel = $this->model('ImageModel');
        $this->profileModel = $this->model('ProfileModel');
    }

    public function profile() {
        if(!isLoggedIn()) {
            $this->redirect('login/login');
        }
        $this->view('Profile', null); //or header
    }
}

?>