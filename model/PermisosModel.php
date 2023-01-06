<?php
class PermisosModel
{
    public function __construct(){
    }

    public function obtenerFechas($username){
		$data = null;
		$query = array();
    	include 'connect.php';
		$sql = "{call PermisosFechasSolicitadas(?)}";
		$params = array($username);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			$data = array(
				'message' => sqlsrv_errors(),
				'status' => 'error',
				'code' => 400
			);
			echo json_encode($data);
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
			    "fecha_permiso"  => $row['FechaPermiso']->format('Y-m-d'),
			    "fecha_autorizado"  => $row['FechaAutorizado'] != null ? $row['FechaAutorizado']->format('Y-m-d') : null,
			    "estado"			=> $row['Estatus'],
				"Empleado" 	=> $row['Empleado'],
				"Fecha" 	=> $row['FechaPermiso']->format('d/m/Y'),
				"Motivo"	=> utf8_encode($row['Motivo']),
				"HoraInicio"=> $row['HoraInicio'],
				"HoraFin"	=> $row['HoraFin'],
				"Permiso"	=> utf8_encode($row['Permiso'])
			);
			array_push($query, $record);
		}

		sqlsrv_free_stmt( $stmt);		
		sqlsrv_close($conn);

		if (count($query) > 0) {
			$data = array(
				'data' => $query,
				'status' => 'success',
				'code' => 200
			);	
		}else{
			$data = array(
				'message' => "No hay permisos",
				'status' => 'error',
				'code' => 200
			);
		}
		return $data;    	
    } 

    public function autorizarPermisos($empleado, $fechas, $bandera){
		$data = null;
		foreach ($fechas as $row) {
			include 'connect.php';
			$sql = "{call PermisosActualizaFecha(?,?)}";
			$params = array($empleado, DateTime::createFromFormat('d/m/Y', $row)->format('Y-m-d'));
			$stmt = sqlsrv_query($conn, $sql, $params);

			if ( $stmt === false) {
				$data = array(
					'message' => sqlsrv_errors(),
					'status' => 'error',
					'code' => 400
				);
				echo json_encode($data);
			}

			sqlsrv_free_stmt( $stmt );
			sqlsrv_close($conn);
		}
		switch ($bandera) {
			case 1:
				$data = array(
					'message' => "tu permiso esta en estatus autorización",
					'status' => 'success',
					'code' => 200
				);
			break;

			case 2:
				$data = array(
					'message' => "tu permiso se autorizó correctamente",
					'status' => 'success',
					'code' => 200
				);
			break;
			
			default:
				$data = array(
					'message' => "Ocurrio un error al momento de hacer tu petición",
					'status' => 'error',
					'code' => 400
				);
			break;
		}
		return $data;  	
    }

    public function insertarFechas($username, $fechas, $motivo, $horainicio, $horafin, $TipoMotivo){
		$query = array();
		foreach ($fechas as $row) {
			include 'connect.php';
			$sql = "{call PermisosInsertaFecha(?,?,?,?,?,?)}";
			$params = array($username,  DateTime::createFromFormat('d/m/Y', $row)->format('Y-m-d'), $motivo, $horainicio, $horafin, $TipoMotivo);
			$stmt = sqlsrv_query($conn, $sql, $params);
			while( $row2 = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {	
				$record = array(
					"Resultado" => $row2['Resultado']
				);
				array_push($query, $record);
			}

			sqlsrv_free_stmt( $stmt);		
			sqlsrv_close($conn);	
		}
		return array(
			"success"=>count($query) > 0 ? true : false,
			"data"=>$query
		);    
	}

    public function eliminarFecha($empleado, $fechas, $HoraInicio, $HoraFin){
	    foreach ($fechas as $row) {
			include 'connect.php';
			$sql = "{call PermisosEliminaFecha(?,?,?,?)}";
			$params = array($empleado, DateTime::createFromFormat('d/m/Y', $row)->format('Y-m-d'), $HoraInicio, $HoraFin);
			$stmt = sqlsrv_query($conn, $sql, $params);

			if ( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}

			sqlsrv_free_stmt( $stmt );
			sqlsrv_close($conn);    	
		}
    }

	public function notificarSolicitud($empleado){
    	$success = false;
		include 'connect.php';
		$TipoReporte= 2;
		$sql = "{call VacacionesEnviaMail(?,?)}";
		$params = array($empleado , $TipoReporte);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );			// Se comenta, ya que si se envía correo desde SQL cae siempre aquí.
		}

		sqlsrv_free_stmt( $stmt );
		sqlsrv_close($conn);
    }

    public function diasPendientesAutorizar($autorizador){
		$query = array();
    	include 'connect.php';
		$sql = "{call PermisosPendientesAutorizar(?)}";
		$params = array($autorizador);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"Empleado" 	=> $row['Empleado'],
				"Nombre" 	=> utf8_encode($row['Nombre']),
				"Fecha" 	=> $row['FechaPermiso']->format('d/m/Y'),
				"Motivo"	=> utf8_encode($row['Motivo']),
				"HoraInicio"=> $row['HoraInicio'],
				"HoraFin"	=> $row['HoraFin'],
				"Permiso"	=> $row['Permiso']
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
	public function Tipo_Permiso(){
		$query = array();
    	include 'connect2.php';
		$sql = "{call rh_TipoPermisosCombo}";
		$stmt = sqlsrv_query($conn, $sql);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"ID" 	=> $row['ID'],
				"TipoPermiso" 	=> utf8_encode($row['TipoPermiso']),
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
	
	// leonardo.pena
	//22/02/2019
	public function empleados(){
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
	public function listadoPermisos($Empleado){
    	$query = array();
    	include 'connect.php';
		$sql = "{call PermisoPorEmpleado(?)}";
		$params = array($Empleado);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"Empleado" 		=> $row['Empleado'],
				"NombreCompleto" 		=> utf8_encode($row['NombreCompleto']),
				"FechaPermiso" 	=> $row['FechaPermiso']->format('d/m/Y'),
				"Departamento" => utf8_encode($row['Departamento']),
				"TipoPermiso" => utf8_encode($row['TipoPermiso']),
				"HoraInicio" => $row['HoraInicio'] ->format('H:i'),
				"HoraFin" => $row['HoraFin'] ->format('H:i'),
				
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

	
}