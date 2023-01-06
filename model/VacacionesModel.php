<?php
class VacacionesModel
{
    public function __construct(){
    }

    public function obtenerFechas($username){
		$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesFechasSolicitadas(?)}";
		$params = array($username);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
			    "fecha_vacaciones"  => $row['FechaVacaciones']->format('Y-m-d'),
			    "fecha_autorizado"  => $row['FechaAutorizado'] != null ? $row['FechaAutorizado']->format('Y-m-d'):null,
			    "estado"			=> $row['Estatus']
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);

		return array(
            "success"=>count($query) > 0 ? true : false,
            "data"=>$query
        );    	
    }

	public function obtenerSaldos($username){
    	$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesDevuelveSaldos(?)}";
		$params = array($username);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
			    "anio"   => $row['Anio'],
			    "saldo" => $row['SaldoDias'],
			    "fecha" => $row['FechaVencimiento']			   
			);
			array_push($query, $record);
		}
		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);
		return array(
            "success"=>true,
            "data"=>$query
        );
    }    
    

    public function autorizarVacaciones($empleado, $fechas, $estado){
		foreach ($fechas as $row) {
			include 'connect.php';
			$sql = "{call VacacionesActualizaFecha(?,?,?)}";
			$params = array($empleado, $row, $estado);
			$stmt = sqlsrv_query($conn, $sql, $params);

			if ( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}

			sqlsrv_free_stmt( $stmt );
			sqlsrv_close($conn);
		}    	
    }

	public function diasFestivos($anio){
    	$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesDiasFestivos(?)}";
		$params = array($anio);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
			    "dia_festivo"   => $row['FechaFestiva']->format('Y-m-d')		   
			);
			array_push($query, $record);
		}
		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);
		return array(
            "success"=> count($query) > 0 ? true : false,
            "data"=>$query
        );
    }

    public function insertarFechas($username, $fechas, $usuariosolicitante){
		foreach ($fechas as $row) {
			include 'connect.php';
			$sql = "{call VacacionesInsertaFecha(?,?,?)}";
			$params = array($username, $row, $usuariosolicitante);
			$stmt = sqlsrv_query($conn, $sql, $params);

			if ( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}

			sqlsrv_free_stmt( $stmt );
			sqlsrv_close($conn);
		}
	}

	public function empleados(){
    	$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesAutoriza()}";
		$params = array();
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"recid" 		=> $row['Empleado'],
				"Empleado" 		=> $row['Empleado'],
				"Nombre" 		=> utf8_encode($row['NombreEmpleado']),
				"Autorizador" 	=> $row['EmpleadoAutoriza'],
				"Nombre_Autorizador" => utf8_encode($row['NombreAutoriza']),
				"Correo" => utf8_encode($row['Correo']),
				"Pass" => utf8_encode($row['Pass']),
				"EsAutorizador" => $row['Autorizador'],
				"Saldo" => $row['Saldo']
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);
		return array(
            "success"=> count($query) > 0 ? true : false,
            "data"=>$query
        );
    }

	public function autorizadores(){
    	$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesCatAutorizadores()}";
		$params = array();
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"Autorizador" 	=> $row['EmpleadoAutoriza'],
				"Nombre_Autorizador" => utf8_encode($row['NombreAutoriza']),
				"Correo" => utf8_encode($row['Correo'])
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);
		return array(
            "success"=> count($query) > 0 ? true : false,
            "data"=>$query
        );
    }	

    public function diasPendientesAutorizar($autorizador){
		$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesPendientesAutorizar(?)}";
		$params = array($autorizador);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"Empleado" 		=> $row['Empleado'],
				"Nombre" 		=> utf8_encode($row['Nombre']),
				"Fecha" 	=> $row['FechaVacaciones']->format('d/m/Y')
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);

		return array(
            "success"=>count($query) > 0 ? true : false,
            "data"=>$query
        );    	
    }    

    public function eliminarFecha($empleado, $fecha){
    	$query = array();
		include 'connect.php';
		$sql = "{call VacacionesEliminaFecha(?,?)}";
		$params = array($empleado, $fecha);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		sqlsrv_free_stmt( $stmt );
		sqlsrv_close($conn);    	
    }

	public function asignarAutorizador($empleado, $autoriza, $correo){
		$query = array();
		include 'connect.php';
		$sql = "{call VacacionesActualizaAutorizador(?,?)}";
		$params = array($empleado, $autoriza);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"Empleado" 		=> $row['Empleado']
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);

		return array(
            "success"=>count($query) > 0 ? true : false,
            "data"=>$query
        ); 
	}

	public function insertarAutorizador($empleado, $autoriza, $correo){
		$query = array();
		include 'connect.php';
		$sql = "{call VacacionesInsertaAutorizador(?,?,?)}";
		$params = array($empleado, $correo, $autoriza);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"Empleado" 		=> $row['Empleado']
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);

		return array(
            "success"=>count($query) > 0 ? true : false,
            "data"=>$query
        ); 
	}

	public function notificarSolicitud($empleado){
    	$success = false;
		include 'connect.php';
		$sql = "{call VacacionesEnviaMail(?)}";
		$params = array($empleado);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );			// Se comenta, ya que si se envía correo desde SQL cae siempre aquí.
		}

		sqlsrv_free_stmt( $stmt );
		sqlsrv_close($conn);
    } 	

    public function insertarSaldo($username, $anio, $saldo){
		include 'connect.php';
		$sql = "{call VacacionesSaldos_IUD(?,?,?)}";
		$params = array($username, $anio, $saldo);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		sqlsrv_free_stmt( $stmt );
		sqlsrv_close($conn);
	}

	public function eliminarSaldo($username, $anio, $saldo, $eliminar){
		include 'connect.php';
		$sql = "{call VacacionesSaldos_IUD(?,?,?,?)}";
		$params = array($username, $anio, $saldo, $eliminar);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		sqlsrv_free_stmt( $stmt );
		sqlsrv_close($conn);
	}  

    public function diasAutorizados($autorizador){
		$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesAutorizadasPorAutorizador(?)}";
		$params = array($autorizador);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"Empleado" 		=> $row['Empleado'],
				"Nombre" 		=> utf8_encode($row['Nombre']),
				"Fecha" 	=> $row['FechaVacaciones']->format('d/m/Y')
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);

		return array(
            "success"=>count($query) > 0 ? true : false,
            "data"=>$query
        );    	
    }
	/*
	Leonardo Rafael Peña 
	Insertar Vacaciones Adelantados
	09/03/2020
	*/
	public function insertarSaldoAnticipado($username, $anio, $saldo){
		include 'connect.php';
		$sql = "{call VacacionesInsertarSaldoAnticipado(?,?,?)}";
		$params = array($username, $anio, $saldo);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		sqlsrv_free_stmt( $stmt );
		sqlsrv_close($conn);
	}
	//
	public function obtenerSaldosAdelantados($username){
    	$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesDevuelveSaldosAdelantados(?)}";
		$params = array($username);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
			    "AnioSiguiente"   	=> $row['AnioSiguiente'],
			    "SaldosAdelantados" 	=> $row['SaldosAdelantados'],
			    "DiasOtorgados" 	=> $row['DiasOtorgados'],
				"total"				=> $row['total']
			);
			array_push($query, $record);
		}
		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);
		return array(
            "success"=>true,
            "data"=>$query
        );
    }    
	//
	//
	// leonardo.pena
	
	public function listadoempleados(){
    	$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesListadoEmpleados()}";
		$params = array();
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				
				"Empleado" 		=> $row['Empleado'],
				"Nombre" 		=> utf8_encode($row['NombreCompleto']),
				
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);
		return array(
            "success"=> count($query) > 0 ? true : false,
            "data"=>$query
        );
    }
	
	//
	public function obtenerFechasEmpleado($username){
		$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesFechasSolicitadas(?)}";
		$params = array($username);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
			    "fecha_vacaciones"  => $row['FechaVacaciones']->format('Y-m-d'),
			    "fecha_autorizado"  => $row['FechaAutorizado'] != null ? $row['FechaAutorizado']->format('Y-m-d'):null,
			    "estado"			=> $row['Estatus']
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);

		return array(
            "success"=>count($query) > 0 ? true : false,
            "data"=>$query
        );    	
    }
	public function obtenerSaldosEmpleados($username){
    	$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesDevuelveSaldosEmpleados(?)}";
		$params = array($username);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
			    "anio"   => $row['Anio']  != null ?  $row['Anio']:0 ,
			    "saldo" => $row['SaldoDias'] != null ?  $row['SaldoDias']:0,
			    "fecha" => $row['FechaVencimiento'] != null ? $row['FechaVencimiento']->format('Y-m-d'):'----------------',
				"FechaIngreso" => $row['FechaIngreso']->format('d/m/Y')				
			);
			array_push($query, $record);
		}
		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);
		return array(
            "success"=>true,
            "data"=>$query
        );
    }  
	//
}