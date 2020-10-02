<?php 

class Login extends Controller{

    public $error = [
        'username' => '',
        'email' => '',
        'password' => '',
        'passwordRepeat' => ''
    ];

    public function __construct() {
        $this->userModel = $this->model('LoginModel');
        //echo 'as';
    }

    public function registration() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Validations
            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'passwordRepeat' => trim($_POST['passwordRepeat'])
            ];

            //Validate username
            if(empty($data['username'])) {
                $this->error['username'] = "Username cannot be empty!";
            }
            else if(strlen($data['username']) < 3) {
                $this->error['username'] = "Username must be atleast three character long!";
            }
            else if(!preg_match($nameValidation,$data['username'])) {
                $this->error['username'] = "Username cannot contains special characters!";
            }
            else if($this->userModel->userNameExist($data)) {
                $this->error['username'] = "Username is already in use!";
            }

            //Validate email
            if(empty($data['email'])) {
                $this->error['email'] = "Email address cannot be empty!";
            }
            else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error['email'] = "Email address is not valid!";
            }
            else if($this->userModel->emailExist($data)) {
                $this->error['username'] = "Email is already in use!";
            }

            //Validate password
            if(empty($data['password'])) {
                $this->error['password'] = "Password cannot be empty!";
            }
            else if(strlen($data['password']) < 8) {
                $this->error['password'] = "Password must be atleast three character long!";
            }
            else if(preg_match($passwordValidation,$data['password'])) {
                $this->error['password'] = "Password must contains atleast one number!";
            }
            
            //Validate passwordRepeat
            if(empty($data['passwordRepeat'])) {
                $this->error['passwordRepeat'] = "Password confirmation cannot be empty!";
            }
            else if($data['passwordRepeat'] != $data['password']) {
                $this->error['passwordRepeat'] = "Passwords do not match!";
            }

            //check for errors
            if(empty($this->error['password']) && empty($this->error['email']) && empty($this->error['username']) && empty($this->error['passwordRepeat'])) {
                //hash password
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                
                if($this->userModel->registration($data)) {
                    header('Location: '.URL_ROOT.'/Home/index');
                }
                else {
                    die('Something went wrong!');
                }
            }
        }
        $this->view('Signup',$this->error);
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password'])
            ];
            
            if(empty($data['email'])) {
                $this->error['email'] = 'Please enter the email address!';
            }
            if(empty($data['password'])) {
                $this->error['password'] = 'Please enter the password!';
            }
            if(empty($this->error['password']) && empty($this->error['email'])) {
                $result = $this->userModel->login($data);

                if($result) {
                    $this->createSession($result);
                }
                else {
                    $this->error['email'] = 'Email or password incorrect! Please try again!';
                }
            }
        }
        else {
            $data = [
                'email' => '',
                'password' => ''
            ];
        }
        $this->view('Home',$this->error);
    }

    public function createSession($userData) {

        $_SESSION['userId'] = $userData['Id'];
        $_SESSION['username'] = $userData['Username'];
        $_SESSION['email'] = $userData['Email'];
        $_SESSION['authority'] = $userData['Authority'];

        header('Location: '.URL_ROOT.'/home/index');
    }

    public function logout() {
        unset($_SESSION['userId']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['authority']);
        session_destroy();

        header('Location: '.URL_ROOT.'/home/index');
    }
}

?>