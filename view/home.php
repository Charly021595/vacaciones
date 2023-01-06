<?php
	if (isset($_GET['a'])) {
		switch ($_GET['a']) {
			case 1:
				vacaciones();
				
				break;
			case 2:
				if ($_SESSION["tipo"] == 1) {
					administrador();
				}
				else{
					vacaciones();
					
				}
				break;
			case 3:
				if ($_SESSION["tipo"] == 1) {
					permisos();
				}
				else{
					//vacaciones();
					permisos();
				}
				break;	
			case 4:
				if ($_SESSION["tipo"] == 1) {
					solicitarvacaciones();
				}
				else{
					//vacaciones();
					permisos();
				}
				break;						
		}
	}
	else{
		vacaciones();
		
	}	
	function vacaciones()
	{
		$vacacionesView = new VacacionesView();
		$vacacionesView->datosUsuario();
		?>
		<div id="cuerpo">
		<?php
			$vacacionesView->vistaVacaciones();
		 	$vacacionesView->vistaAutorizador();
			$vacacionesView->vistaAutorizadorCancelar();		 	
		?>
		</div>

		<?php
								
	}

	function administrador()
	{
		$vacacionesView = new VacacionesView();
		?>
		<div id="cuerpo">
		<?php
			$vacacionesView->vistaAdministrador();		 	
		?>
		</div>
		<?php						
	}	

	function permisos()
	{
		$permisosView = new PermisosView();
		$permisosView->datosUsuario();
		?>
		<div id="cuerpo">
		<?php
			$permisosView->vistaPermisos();
			$permisosView->vistaAutorizador();
			//$permisosView->vistaPendienteAutorizar();
		?>
		</div>
		<?php			
	}
	function solicitarvacaciones()
	{
		$vacacionesView = new VacacionesView();
		?>
		<div id="cuerpo">
		<?php
			$vacacionesView->vistaSolitarVacaciones();		 	
		?>
		</div>
		<?php						
	}	
	
?>