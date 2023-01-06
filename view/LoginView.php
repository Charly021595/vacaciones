<?php
class LoginView
{
    private $model;
    private $controller;

    public function __construct() {
        $this->model = new LoginModel();
        $this->controller = new LoginController($this->model);        
    }
	
    public function output(){
        return "view/login.php";
    }

    public function validateUser($username, $password){
        $data = $this->controller->validateUser($username, $password);
        return $data;
        /*if($data['valido']){
            echo 'true';
        }
        else{
            echo 'false';
        }*/
    }

    public function actualizarCredenciales($username, $password){
        $validUser = $this->controller->actualizarCredenciales($username, $password);
        return $validUser;
    }    
}