
<?php
	//JSSH Se agrega esta clase de conexión para apuntar a Prod, ya que no podia visualizar el listado de permisos
	//Que ejecuta el store procedure rh_TipoPermisoCombo
	$serverName = "VMSQL2008"; //serverName\instanceName
	$connectionInfo = array( "Database"=>"Consultas", "UID"=>"Consulta", "PWD"=>"Consulta");
	// $serverName = "VMDYNAMICSAXDEV";
	// $connectionInfo = array( "Database"=>"Consultas", "UID"=>"Consulta", "PWD"=>"Consulta");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

	if( !$conn ) {
	 echo "No se pudo establecer la conexión.<br />";
	 die( print_r( sqlsrv_errors(), true));
	}	
?>