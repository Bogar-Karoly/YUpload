<?php 

class Login extends Controller{

    public $error = [];

    public function __construct() {
        $this->loginModel = $this->model('LoginModel');
    }

    private function sendPasswordRecovery($email, $password) {
        $subject = 'Password Recovery';
        $message = '<p>Your new password: <b>'.$password.'</b></p>';

        $header = 'From: myaltarmy@gmail.com \r\n';
        $header .= 'MINE-VERSION: 1.0'.'\r\n';
        $header .= 'Content-type:text/html;charset:UTF-8'.'\r\n';

        if(mail($email,$subject,$message,$header)) {
            return true;
        }
        return false;
    }

    public function passwordRecovery() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
            if(empty($email)) {
                $this->error['passRecovery'] = 'Email cannot be empty!';
                //error
            }
            else if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $this->error['passRecovery'] = 'Invalid Email Address!';
            }
            else if(!$this->loginModel->emailExist($email)) {
                $this->error['passRecovery'] = 'Email doesn\'t exists!';
            }

            if(empty($this->error)) {
                $newPassword = '';

                for($i = 0; $i < 8; $i++) {
                    $newPassword .= $characters[rand(0, strlen($characters)-1)];
                }

                $hashedPassword = password_hash($newPassword,PASSWORD_DEFAULT);
                
                if($this->loginModel->setNewPassword($email,$hashedPassword))  {
                    if($this->sendPasswordRecovery($email,$newPassword)) {
                        $this->view('Verification',null);
                        exit();
                    }
                    else{
                        $this->error['error1'] = 'error1';
                    }
                }
                else{
                    $this->error['error2'] = 'error2';
                }
            }
        }
        else {
            $this->error['error3'] = 'error3';
        }
        $this->view('PasswordRecovery',$this->error);
    }

    public function confirmEmail($data) {

        if(empty($data)) {
            $this->error['confirmError'] = 'Empty link';
        }
        else if(!$this->loginModel->verify($data)) {
            $this->error['confirmError'] = 'Verification failed';
        }

        if(empty($this->error)) {
            //success

            $this->view('VerificationResult',null);
        }
        else {
            $this->view('VerificationResult',$this->error);
        }

    }

    private function sendVerification($vkey, $email) {

        //params
        $subject = 'Email Verifictaion';
        $message = '<a href="'.URL_ROOT.'/login/confirmEmail/'.$vkey.'">VERIFY</a>';

        $header = 'From: myaltarmy@gmail.com \r\n';
        $header .= 'MINE-VERSION: 1.0'.'\r\n';
        $header .= 'Content-type:text/html;charset:UTF-8'.'\r\n';

        if(mail($email,$subject,$message,$header)) {
            return true;
        }
        return false;
    }

    public function registration() {
        if (isLoggedIn()) {
            $this->redirect('home/index');
        }else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
                if (empty($data['username'])) {
                    $this->error['username'] = "Username cannot be empty!";
                } elseif (strlen($data['username']) < 3) {
                    $this->error['username'] = "Username must be atleast three character long!";
                } elseif (!preg_match($nameValidation, $data['username'])) {
                    $this->error['username'] = "Username cannot contains special characters!";
                } elseif ($this->loginModel->userNameExist($data)) {
                    $this->error['username'] = "Username is already in use!";
                }

                //Validate email
                if (empty($data['email'])) {
                    $this->error['email'] = "Email address cannot be empty!";
                } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $this->error['email'] = "Email address is not valid!";
                } elseif ($this->loginModel->emailExist($data)) {
                    $this->error['username'] = "Email is already in use!";
                }

                //Validate password
                if (empty($data['password'])) {
                    $this->error['password'] = "Password cannot be empty!";
                } elseif (strlen($data['password']) < 8) {
                    $this->error['password'] = "Password must be atleast eight character long!";
                } elseif (preg_match($passwordValidation, $data['password'])) {
                    $this->error['password'] = "Password must contains atleast one number!";
                }
            
                //Validate passwordRepeat
                if (empty($data['passwordRepeat'])) {
                    $this->error['passwordRepeat'] = "Password confirmation cannot be empty!";
                } elseif ($data['passwordRepeat'] != $data['password']) {
                    $this->error['passwordRepeat'] = "Passwords do not match!";
                }

                //check for errors
                if (empty($this->error)) {
                    //hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    //verification key
                    $data['vkey'] = md5(time().$data['username']);

                    //regist the user
                    if ($this->loginModel->registration($data)) {
                        //send email on success
                        if ($this->sendVerification($data['vkey'], $data['email'])) {
                            $this->view('Verification', null);
                            exit();
                        }
                    } else {
                        $this->error['regist'] = 'Something went wrong, please try again later!';
                    }
                }
            }
        }
        $this->view('Signup',$this->error);
    }

    public function login() {
        if (isLoggedIn()) {
            $this->redirect('home/index');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password'])
                ];
            
                if (empty($data['email'])) {
                    $this->error['email'] = 'Please enter the email address!';
                }
                if (empty($data['password'])) {
                    $this->error['password'] = 'Please enter the password!';
                }
                if (empty($this->error)) {
                    $result = $this->loginModel->login($data);

                    if ($result) {
                        if ($result['Verified'] == true) {
                            $this->createSession($result);
                        } else {
                            if (!$this->sendVerification($result['Vkey'], $result['Email'])) {
                                $this->view('Verification', null);
                            } else {
                                $this->redirect('home/index');
                            }
                        }
                    } else {
                        $this->error['email'] = 'Email or password incorrect! Please try again!';
                    }
                }
            }
        }
        $this->view('Signin',$this->error);
    }

    public function createSession($userData) {

        $_SESSION['userId'] = $userData['Id'];
        $_SESSION['username'] = $userData['Username'];
        $_SESSION['email'] = $userData['Email'];
        $_SESSION['authority'] = $userData['Authority'];

        $this->redirect('home/index');
    }

    public function logout() {
        unset($_SESSION['userId']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['authority']);
        session_destroy();

        $this->redirect('home/index');
    }
}

?>