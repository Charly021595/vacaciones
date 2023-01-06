<?php
class LoginController
{
    private $model;

    public function __construct($model){
        $this->model = $model;
    }

    public function showView()
    {
    	return "view/login.php";
    }

    public function validateUser($username, $password){
    	$data = $this->model->validateUser($username, $password);
    	if($data['data'][0]['valido'] === 1 ){//&& $data['data'][0]['fecha'] !== false){          
            $datos = $this->model->datosGenerales($username);
            $_SESSION['usuario'] = $datos['data'][0]['Empleado'];
            $_SESSION['nombre'] = $datos['data'][0]['Nombre'];
            $_SESSION["fecha_ingreso"]   = $datos['data'][0]['FechaIngreso'];            
            $_SESSION["antiguedad"]   = $datos['data'][0]['Antiguedad'];    
            $_SESSION["vacaciones"]   = $datos['data'][0]['Vacaciones'];    
            $_SESSION["dpto"]   = $datos['data'][0]['Dpto'];
            $_SESSION["unidaddenegocio"]   = $datos['data'][0]['UnidaddeNegocio'];
            $_SESSION["tipo"]   = $data['data'][0]['tipo'];
            $_SESSION["tiene_autorizador"] = $data['data'][0]['tiene_autorizador'];
            $_SESSION["acceso"] = time();
        }
        return $data['data'];
    }

    public function actualizarCredenciales($username, $password){
        $data = $this->model->actualizarCredenciales($username, $password);
        $datos = $this->model->datosGenerales($username);
        $_SESSION['usuario'] = $datos['data'][0]['Empleado'];
        $_SESSION['nombre'] = $datos['data'][0]['Nombre'];
        $_SESSION["fecha_ingreso"]   = $datos['data'][0]['FechaIngreso'];            
        $_SESSION["antiguedad"]   = $datos['data'][0]['Antiguedad'];    
        $_SESSION["vacaciones"]   = $datos['data'][0]['Vacaciones'];    
        $_SESSION["dpto"]   = $datos['data'][0]['Dpto']; 
        $_SESSION["tipo"]   = $data['data'][0]['tipo'];
        $_SESSION["tiene_autorizador"]   = $data['data'][0]['tiene_autorizador'];        
        $_SESSION["acceso"] = time();
        return $data;
    }    
}