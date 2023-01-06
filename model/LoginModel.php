<?php
class LoginModel
{
    private $data;
    private $validUser;

    public function __construct(){
        $this->data = array();
        $this->validUser = false;
    }

    public function validateUser($username, $password){
		$query = array();
		$URL  = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    	include 'connect.php';
		$sql = "{call VacacionesValidaLogin(?, ?, ?)}";
		$params = array($username, $password, $URL);
		$stmt = sqlsrv_query($conn, $sql, $params);
		
		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"valido" => $row['valido'],
				"fecha" => $row['FechaUltimoAcceso'] !=  null ? $row['FechaUltimoAcceso']->format('Y-m-d') : false,
				"tipo" => $row['Admin'],
				"tiene_autorizador" => $row['TieneAutorizador']
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

	public function datosGenerales($username){
		$query = array();
    	include 'connect.php';
		$sql = "{call VacacionesDatosGenerales(?)}";
		$params = array($username);
		$stmt = sqlsrv_query($conn, $sql, $params);
		
		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}	

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$record = array(
				"Empleado" => $row['Empleado'],
				"Nombre" => utf8_encode($row['NombreCompleto']),
				"FechaIngreso" => $row['FechaIngreso'],
				"Antiguedad" => $row['Antiguedad'],
				"Vacaciones" => $row['Vacaciones'],
				"Dpto" => $row['Depto'],
				"UnidaddeNegocio" => $row['UnidaddeNegocio']
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

    public function actualizarCredenciales($username, $password){
		include 'connect.php';
		$sql = "{call VacacionesCambiaPassword(?,?)}";
		$params = array($username, $password);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		sqlsrv_free_stmt( $stmt );
		sqlsrv_close($conn); 	
    }	
}