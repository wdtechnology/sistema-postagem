<?php
    class Users extends Controller {

        public function __construct(){

        } 

        public function register(){
            // Chack for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email'=> trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validate email
                if(empty($data['email'])){
                    $data['email_err'] = 'Campo email não pode ser vazio!';
                }

                // Validate Name
                if(empty($data['name'])){
                    $data['name_err'] = 'Campo nome não pode ser vazio!';
                }

                // Validate Password
                if(empty($data['password'])){
                    $data['password_err'] = 'Campo senha não pode ser vazio!';
                } elseif(strlen($data['password']) < 6) {
                    $data['password_err'] = 'A senha deve conter mais de 6 caracteres';
                }

                // Validate Confirm Passwors
                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Campo confirmar senha não pode ser vazio!';
                } else {
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_err'] = 'As senhas estão diferente';
                    }
                }

                // Make sure errors are empty
                if(empty($data['email_err']) && empty($data['name_err'])  && empty($data['password_err']) && 
                empty($data['confirm_password_err'])) {
                    //Validated
                    die('SUCESSO');
                } else {
                    // Load view with errors
                    $this->view('users/register', $data);
                }


            } else {
                // Init data
                $data = [
                    'name' => '',
                    'email'=> '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                // Load view
                $this->view('users/register', $data);
            }            
        }

        public function login(){
            // Chack for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'email'=> trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                 // Validate email
                 if(empty($data['email'])){
                    $data['email_err'] = 'Campo email não pode ser vazio!';
                }

                // Validate Password
                if(empty($data['password'])){
                    $data['password_err'] = 'Campo senha não pode ser vazio!';
                } elseif(strlen($data['password']) < 6) {
                    $data['password_err'] = 'A senha deve conter mais de 6 caracteres';
                }

                 // Make sure errors are empty
                 if(empty($data['email_err']) &&  empty($data['password_err'])) {
                     //Validated
                     die('SUCESSO');
                 } else {
                     // Load view with errors
                     $this->view('users/login', $data);
                 }
                 
            } else {
                // Init data
                $data = [
                    'email'=> '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => ''
                ];
                // Load view
                $this->view('users/login', $data);
            }
        }
    }