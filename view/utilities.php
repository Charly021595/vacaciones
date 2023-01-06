<?php
	session_start();
	include ("../models.php");
	include ("../controllers.php");
	include ("../views.php");

	$vacacionesView = new VacacionesView();
	$loginView = new LoginView();
	$permisosView = new PermisosView();

	// Terminar sesión del usuario
	if (isset( $_POST['param'] ) && $_POST['param'] == 2) {
		Controller::startSessions();
		Controller::destroySessions();		
	}

	// Valida credenciales
	if (isset( $_POST['param'] ) && $_POST['param'] == 5){
        $data = $loginView->validateUser($_POST['username'], $_POST['password']);
        /*
        	1 - Cambiar credenciales.
        	2 - Usuario correcto.
        	3 - Usuario incorrecto.
        */
        if ($data[0]['valido'] === 1 && $data[0]['fecha'] === false )
        {
        	if (!$_SESSION["tiene_autorizador"]) {
				$_SESSION['mensaje'] = 'No tiene asignado un autorizador, póngase en contacto con Capital Humano.';
			}
			echo '1';
        }        
        else if ($data[0]['valido'] === 1)
        {
			if (!$_SESSION["tiene_autorizador"]) {
				$_SESSION['mensaje'] = 'No tiene asignado un autorizador, póngase en contacto con Capital Humano.';
			}        	
			echo '2';			
        }         
        else{
        	echo '3';
        }
    }

	// Recuperar días festivos
	if (isset( $_POST['param'] ) && $_POST['param'] == 6){
        $vacacionesView->diasFestivos($_POST['anio']);
    }    

	// Insertar fechas marcadas
	if (isset( $_POST['param'] ) && $_POST['param'] == 7 && isset( $_POST['fechas'] )){
		$fechas = $_REQUEST['fechas'];
        $vacacionesView->insertarFechas($_SESSION["usuario"], $fechas,$_SESSION["usuario"]);
    }

	// Obtener fechas marcadas
	if (isset( $_POST['param'] ) && $_POST['param'] == 8){
        $data = $vacacionesView->obtenerFechas($_SESSION["usuario"]);
    }

	// Obtener empleados
	if (isset( $_POST['param'] ) && $_POST['param'] == 9){
        $data = $vacacionesView->empleados();
    }

	// Autorizar fechas pendientes
	if (isset( $_POST['param'] ) && $_POST['param'] == 10 && isset( $_POST['empleado'] ) && isset( $_POST['fechas'] )){		
        $data = $vacacionesView->autorizarVacaciones($_POST['empleado'], $_POST['fechas']);
    }

	// Enviar fechas para autorización
	if (isset( $_POST['param'] ) && $_POST['param'] == 11){
        $data = $vacacionesView->solicitarAutorizacionVacaciones($_SESSION["usuario"]);
        $data = '';
    }

	// Rechazar fecha seleccionada
    // 31/07/2018: También se utiliza para cancelar fechas ya canceladas.
	if (isset( $_POST['param'] ) && $_POST['param'] == 12 && isset( $_POST['fechas'] )){
        $vacacionesView->rechazarVacaciones($_POST['empleado'], $_POST['fechas']);
    }

	// Eliminar fecha
	if (isset( $_POST['param'] ) && $_POST['param'] == 13 && isset( $_POST['fechas'] )){
        $vacacionesView->eliminarFecha($_SESSION["usuario"], $_POST['fechas']);
    }

	// Obtener empleados
	if (isset( $_POST['param'] ) && $_POST['param'] == 14){
        file_put_contents('empleados.json', $vacacionesView->empleados());
        /*$fp = fopen('empleados.json', 'w');
		fwrite($fp, $vacacionesView->empleados());   //here it will print the array pretty
		fclose($fp);*/
    }

	if (isset( $_GET['param'] ) && $_GET['param'] == 15){
        $data = $vacacionesView->empleados();
    }

	// Actualizar credenciales
	if (isset( $_POST['param'] ) && $_POST['param'] == 16){
        $valid = $loginView->actualizarCredenciales($_POST['username'], $_POST['password']);
        echo $valid;
    }

	// Actualizar usuario autorizador
	if (isset( $_POST['param'] ) && $_POST['param'] == 17){
        $valid = $vacacionesView->asignarAutorizador($_POST['username'], $_POST['autoriza'], 1);
        echo $valid;
    }

	// Obtener autorizadores
	if (isset( $_POST['param'] ) && $_POST['param'] == 18){
        $data = $vacacionesView->autorizadores();
    }

    // Cargar pantalla modal para asignar o cambiar correo a un autorizador
	if (isset( $_POST['param'] ) && $_POST['param'] == 19){
        $data = $vacacionesView->vistaActualizarEmpleado();
    }

    // Actualizar usuario autorizador
	if (isset( $_POST['param'] ) && $_POST['param'] == 20){
        $valid = $vacacionesView->insertarAutorizador($_POST['empleado'], $_POST['autoriza'], $_POST['correo']);
        echo $valid;
    }

    // Cargar pantalla modal para administrar saldos
	if (isset( $_POST['param'] ) && $_POST['param'] == 21){
        $data = $vacacionesView->vistaActualizarSaldos($_POST["empleado"]);
    }   

	// Insertar nuevo saldo
	if (isset( $_POST['param'] ) && $_POST['param'] == 22 && isset($_POST['anio']) && isset($_POST['saldo']) ){
        $vacacionesView->insertarSaldo($_POST["usuario"], $_POST['anio'], $_POST['saldo']);
    }

    // Cargar saldos
	if (isset( $_POST['param'] ) && $_POST['param'] == 23){
        $data = $vacacionesView->saldos($_POST["empleado"]);
    }

    // Eliminar saldo
	if (isset( $_POST['param'] ) && $_POST['param'] == 24 && isset($_POST['usuario']) && isset($_POST['anio'])){
        $data = $vacacionesView->eliminarSaldo($_POST["usuario"], $_POST['anio'], null, 1);
    }

    // Enviar fechas para autorización de permiso
	if (isset( $_POST['param'] ) && $_POST['param'] == 25 && isset( $_POST['fechas'] )){
		$fechas = $_REQUEST['fechas'];
        $data = $permisosView->insertarFechas($_SESSION["usuario"], $fechas,utf8_decode($_POST['motivo']), $_POST['HoraInicio'], $_POST['HoraFin'], $_POST['TipoMotivo']);
    }

	// Obtener fechas marcadas para permisos
	if (isset( $_POST['param'] ) && $_POST['param'] == 26){
        $data = $permisosView->obtenerFechas($_SESSION["usuario"]);
    }    

	// Rechazar fechas marcadas para permisos (eliminarlas)
	if (isset( $_POST['param'] ) && $_POST['param'] == 27 && isset( $_POST['fechas'] )){
        $data = $permisosView->eliminarFecha($_POST["empleado"], $_POST['fechas'],$_POST['HoraInicio'], $_POST['HoraFin']);
    }

	// Autorizar fechas de permisos
	if (isset( $_POST['param'] ) && $_POST['param'] == 28 && isset( $_POST['fechas'] )){
        $data = $permisosView->autorizarPermisos($_POST["empleado"], $_POST['fechas']);
    }  
	
	//lrph
	// Enviar fechas para autorización
	if (isset( $_POST['param'] ) && $_POST['param'] == 29){
        $data = $permisosView->solicitarAutorizacionPermisos($_SESSION["usuario"]);
        $data = '';
    }
	//lrph
	// Enviar combobox 02/11/2018
	if (isset( $_POST['param'] ) && $_POST['param'] == 30){
        $data = $permisosView->solicitarAutorizacionPermisos();
        $data = '';
    }
	//lrph
	// Enviar combobox 22/02/2019
	if (isset( $_POST['param'] ) && $_POST['param'] == 31){
        $data = $permisosView->listadoPermisos($_POST["Empleado"]);
        
    }
	//lrph
	// Envia los dias anticipados. 06/03/2020
	if (isset( $_POST['param'] ) && $_POST['param'] == 32 && isset($_POST['anio']) && isset($_POST['saldo'])){
         $vacacionesView->insertarSaldoAnticipado($_POST["usuario"], $_POST['anio'], $_POST['saldo']);
    }
	// Insertar fechas marcadas a otro empleado
	if (isset( $_POST['param'] ) && $_POST['param'] == 34 && isset( $_POST['fechas'] )&& isset( $_POST['empleadoASolicitar'] )){
		$fechas = $_REQUEST['fechas'];
        $vacacionesView->insertarFechas($_POST['empleadoASolicitar'], $fechas,$_SESSION["usuario"]);
    }
	// Obtener fechas marcadas
	if (isset( $_POST['param'] ) && $_POST['param'] == 35 && isset( $_POST['empleadoASolicitar'] )){
        $data = $vacacionesView->obtenerFechasEmpleado($_POST['empleadoASolicitar']);
    }
	if (isset( $_POST['param'] ) && $_POST['param'] == 36 && isset( $_POST['empleadoASolicitar'] )){
         $vacacionesView->eliminarFecha( $_POST['empleadoASolicitar'], $_POST['fechas']);
    }
	if (isset( $_POST['param'] ) && $_POST['param'] == 37){
        $data = $vacacionesView->obtenerSaldosEmpleados($_POST["Empleado"]);
        
    }
	if (isset( $_POST['param'] ) && $_POST['param'] == 38 && isset( $_POST['empleadoASolicitar'] )){
        $data = $vacacionesView->solicitarAutorizacionVacaciones($_POST["empleadoASolicitar"]);
        
    }
	
?>