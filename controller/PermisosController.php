<?php
class PermisosController
{
    private $model;

    public function __construct($model){
        $this->model = $model;
    }

    public function showView(){
    	return 'view/Permisos.php';
    }

    public function obtenerPermisos($username){
    	$data = $this->model->obtenerPermisos($username);
    	if ($data['success']) {
    		return $data['data'];
    	}
    	else{
    		return '';
    	}    	
    }

    public function autorizarPermisos($empleado, $fechas){
        $data = $this->model->autorizarPermisos($empleado, $fechas, 2);
        return $data;
    }

    public function insertarFechas($empleado, $fechas, $motivo, $horainicio, $horafin,$TipoMotivo){
        $data = $this->model->insertarFechas($empleado, $fechas, $motivo, $horainicio, $horafin, $TipoMotivo);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }  
    }

    public function obtenerFechas($empleado){
        $data = $this->model->obtenerFechas($empleado);
        return $data;
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

    public function solicitarAutorizacionPermisos($empleado){
        $data = $this->model->obtenerFechas($empleado);
        
        $fechas = array();
        foreach ($data['data'] as $fecha) {
            if ($fecha['estado'] == 0) {
                array_push($fechas, $fecha['Fecha']);
            }
        }
        if (count($fechas) > 0) {
            $data = 'No hay datos';
			//$data = $this->model->autorizarPermisos($empleado, $fechas, 1);
            //$this->model->notificarSolicitud($empleado);
        }
        else{
            //$data = 'No hay datos';
			$data = $this->model->autorizarPermisos($empleado, $fechas, 1);
            $this->model->notificarSolicitud($empleado);
        }
        return $data;
    }

    public function rechazarPermisos($empleado, $fechas){
        $data = $this->model->autorizarVacaciones($empleado, $fechas, 0);
        return $data;
    }

    public function eliminarFecha($empleado, $fechas, $HoraInicio, $HoraFin){
        $data = $this->model->eliminarFecha($empleado, $fechas, $HoraInicio, $HoraFin);
        return $data;
    }

	//lpena 2/11/2018
	public function Tipo_Permiso(){
        $data = $this->model->Tipo_Permiso();
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }
	//lpena 21/02/2019
	public function empleados(){
        $data = $this->model->empleados();
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return '';
        }       
    }
	
	public function listadoPermisos($Empleado){
        $data = $this->model->listadoPermisos($Empleado);
        if ($data['success']) {
            return $data['data'];
        }
        else{
            return $data['data'];;
        }       
    }

}