<?php

class Upload extends Controller {

    public function __construct() {
        $this->uploadModel = $this->model('UploadModel');
    }

    private $error = [];

    public function uploadFile() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $filename = $_FILES['imagefile']['name'];
            //$ext = explode('.',trim($_POST['file']));
            $var = strtolower(end(explode('.',$filename)));
            $data = [
                'name' => $_POST['name'],
                'ext' => $var,
                'tags' => $_POST['tags'],
                'visibility' => $_POST['visibility']
            ];

            $stringValidation = "/^[a-zA-Z0-9]*$/";

            //image name validation
            if(empty($data['name'])) {
                $error['name'] = 'error name empty';
            }
            else if(strlen($data['name']) < 3 || strlen($data['name']) > 50) {
                $error['name'] = 'error name too short/long';
            }
            else if(!preg_match($stringValidation, $data['name'])) {
                $error['name'] = 'error name invalid';
            }

            //file extension validation
            $validExt = array('gif','jpeg','jpg','png');

            if(!in_array($data['ext'], $validExt)) {
                $error['ext'] = 'Invalid extension!';
            }

            //image visibility
            if(empty($data['visibility'])) {
                $error['visibility'] = 'error visibility empty';
            }
            else if($data['visibility'] != 'public' || $data['visibility'] != 'private') {
                $error['visibility'] = 'error visibility type';
            }

            //search for errors
            if(empty($this->error)) {
                if($imageId = $this->uploadModel->upload(array($_SESSION['userId'],$data['name'],$data['visibility'],$data['ext']))) {
                    if(!empty($data['tags'])) {
                        $tags = $data['tags'];
        
                        foreach ($tags as $key => $value) {
                            if($this->uploadModel->doesTagExist()) {
                                $this->uploadModel->addNewTag($value);
                            }
                            $this->uploadModel->addTags($this->uploadModel->getTagId($value),$imageId);
                        }
                    }
                    if(move_uploaded_file($_FILES['imagefile']['tmp_name'],'../public/images/'.$imageId.'.'.$data['ext'])) {
                        $this->error['save'] = 'couldnt save it';
                    }
                    $this->view('UploadFile', $this->error);
                } else {
                    $this->view('UploadFile', $this->error);
                }
            }
            //image tags
        }
        $this->view('UploadFile', $this->error);
    }
}

?>