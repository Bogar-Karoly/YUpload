<?php

class Image extends Controller {

    private $error = [];

    public function __construct()
    {
        $this->uploadModel = $this->model('UploadModel');
    }

    public function getImages() {

        $data = array(json_decode($_POST['start']), json_decode($_POST['end']));

        $result = $this->uploadModel->loadImages($data);

        $dataArray = [];
        foreach($result as $value) {
            $temp = [];
            
            $temp['Url'] = 'http://localhost/upload/images/'.strval($value[0]).'.'.strval($value[1]);
            $temp['Name'] = strval($value[2]);
            $temp['Downloads'] = strval($value[3]);
            $temp['Username'] = strval($value[4]);

            array_push($dataArray,$temp);
        }
        $json = json_encode($dataArray);

        echo $json;
    }
    public function index() {
        $data = 'new data';
        echo $data;
    }
}



?>