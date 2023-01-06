<?php
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