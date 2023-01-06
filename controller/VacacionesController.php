<?php
class VacacionesController
{
    private $model;

    public function __construct($model){
        $this->model = $model;
    }

    public function showView(){
    	return 'view/vacaciones.php';
    }

    public function obtenerVacaciones($username){
    	$data = $this->model->obtenerVacaciones($username);
    	if ($data['success']) {
    		return $data['data'];
    	}
    	else{
    		return '';
    	}    	
    }

    public function obtenerSaldos($username){
        $data = $this->model->obtenerSaldos($username);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }    

    public function autorizarVacaciones($empleado, $fechas){
        $data = $this->model->autorizarVacaciones($empleado, $fechas, 2);
        return $data;
    }

    public function diasFestivos($anio){
        $data = $this->model->diasFestivos($anio);
        return $data;
    }

    public function insertarFechas($username, $fechas,$usuariosolicitante){
        $data = $this->model->insertarFechas($username, $fechas,$usuariosolicitante);
        return $data;
    }

    public function obtenerFechas($username){
        $data = $this->model->obtenerFechas($username);
        return $data;
    }

    public function empleados(){
        $data = $this->model->empleados();
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }

    public function autorizadores(){
        $data = $this->model->autorizadores();
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }

    public function diasPendientesAutorizar($autorizador){
        $data = $this->model->diasPendientesAutorizar($autorizador);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }

    public function solicitarAutorizacionVacaciones($empleado){
        $data = $this->model->obtenerFechas($empleado);
        
        $fechas = array();
        foreach ($data['data'] as $fecha) {
            if ($fecha['estado'] == 0) {
                array_push($fechas, $fecha['fecha_vacaciones']);
            }
        }
        if (count($fechas) > 0) {
            $data = $this->model->autorizarVacaciones($empleado, $fechas, 1);
            $this->model->notificarSolicitud($empleado);
        }
        else{
            $data = 'No hay datos';
        }
        return $data;
    }

    public function rechazarVacaciones($empleado, $fechas){
        $data = $this->model->autorizarVacaciones($empleado, $fechas, 0);
        return $data;
    }

    public function eliminarFecha($empleado, $fechas){
        $data = $this->model->eliminarFecha($empleado, $fechas);
        return $data;
    }

    public function asignarAutorizador($empleado, $autoriza, $correo){
        $data = $this->model->asignarAutorizador($empleado, $autoriza, $correo);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }
    }

    public function insertarAutorizador($empleado, $autoriza, $correo){
        $data = $this->model->insertarAutorizador($empleado, $autoriza, $correo);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }
    }

    public function insertarSaldo($username, $anio, $saldo){        
        $data = $this->model->insertarSaldo($username, $anio, $saldo);
        return $data;
    }


    public function eliminarSaldo($username, $anio, $saldo, $eliminar){        
        $data = $this->model->eliminarSaldo($username, $anio, $saldo, $eliminar);
        return $data;
    } 

    public function diasAutorizados($autorizador){
        $data = $this->model->diasAutorizados($autorizador);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }
	/*
	Leonardo Rafael Peña 
	Insertar Vacaciones Adelantados
	09/03/2020
	*/
	 public function insertarSaldoAnticipado($username, $anio, $saldo){        
        $data = $this->model->insertarSaldoAnticipado($username, $anio, $saldo);
        return $data;
    }
	
	/*
	Leonardo Rafael Peña
	Seleccionar Vacaciones Adelantadas
	12/03/2020
	*/
	public function obtenerSaldosAdelantados($username){
        $data = $this->model->obtenerSaldosAdelantados($username);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }
	//lpena 21/02/2019
	public function listadoempleados(){
        $data = $this->model->listadoempleados();
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }  
	public function obtenerFechasEmpleado($username){
        $data = $this->model->obtenerFechasEmpleado($username);
        return $data;
    }
	public function obtenerSaldosEmpleados($username){
        $data = $this->model->obtenerSaldosEmpleados($username);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }    

}