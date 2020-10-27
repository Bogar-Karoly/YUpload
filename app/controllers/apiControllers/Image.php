<?php

class Image extends Controller {

    private $error = [];

    public function __construct()
    {
        $this->uploadModel = $this->model('UploadModel');
    }

    public function getImages() {

        //$new = json_decode($_POST['start']);
        $data = array(json_decode($_POST['start']), json_decode($_POST['end']));

        $result = $this->uploadModel->loadImages($data);

        //$image = file_get_contents($result['Id'].'.'.$result['Ext'],'../app/images/'.$result['Id'].'.'.$result['Ext']);
        $dirArray = [];
        foreach($result as $value) {
            $temp = 'http://localhost/upload/images/'.strval($value[0]).'.'.strval($value[1]);
            array_push($dirArray,$temp);
        }
        //$dir = 'http://localhost/upload/images/'.$result['Id'].'.'.$result['Ext'];
        //$coded = base64_encode($image);
        $json = json_encode($dirArray);

        echo $json;
    }
    public function index() {
        $data = 'new data';
        echo $data;
    }
}



?>