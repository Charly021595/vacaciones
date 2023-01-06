<?php
class Controller
{
    // Contenedor Instancia de la clase
    private static $instance = NULL;

    // Constructor privado, previene la creación de objetos vía new
    private function __construct(){
        //session_start();
    }

    // Clone no permitido
    public function __clone() { }

    // Método singleton 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }    

    public function index()
    {        
        if (isset($_SESSION['usuario'])){
            $data['content'] = 'view/home.php';
            $data['title'] = 'Vacaciones';            
            return $data;
        }
        else{
            $loginController = new LoginController(new LoginModel());
            $data['content'] = $loginController->showView();
            $data['title'] = 'Inicio';
            return $data;
        }
    }
    public function startSessions(){
        session_start();
    }
    public function destroySessions(){        
        // delete all session values
        session_unset();
        // terminate the session
        session_destroy();
    }

    public function mostrarMensaje(){
        if (isset($_SESSION['mensaje'])){
            echo '<script language="javascript">alert("'.$_SESSION['mensaje'].'");</script>';
        }
    }    

    public function showMenu(){
        if (isset($_SESSION['usuario'])){
            return 'view/menu.php';        
        }
    }

    public function borrarMensaje(){
        unset($_SESSION['mensaje']);
    }      
}