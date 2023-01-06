<?php
class PermisosView
{
    private $model;
    private $controller;

    public function __construct() {
        $this->model = new PermisosModel();        
        $this->controller = new PermisosController($this->model);
    }
	
    public function output(){
        return "view/Permisos.php";
    }


   public function datosUsuario(){
       
        /*JSSH Se realizo cambio de uso de Tablas a div para usar grid y que se ajusten a la pantalla */
        echo '<div class="row" style="margin-left: 20px;">               
                <div class="col-md-2 columna-titulo">No. Empleado:</div>
				<div class="col-md-1 columna-valor">'.$_SESSION['usuario'].'</div>
                <div class="col-md-2 columna-titulo">Nombre:</div>
				<div class="col-md-7 columna-valor">'.$_SESSION['nombre'].'</div>
				<input id="unidad_negocio" type="hidden" value="'.$_SESSION['unidaddenegocio'].'">
				<div id="TipoUsuario"  style="display: none;">'.$_SESSION['tipo'].'</div>

                <div class="col-md-2 columna-titulo">Fecha Ingreso:</div>
				<div class="col-md-1 columna-valor">'.$_SESSION['fecha_ingreso']->format('d/m/Y').'</div>
                <div class="col-md-2 columna-titulo">Antigüedad (Años):</div>
				<div class="col-md-1 columna-valor">'.$_SESSION['antiguedad'].'</div>
                <div class="col-md-3 columna-titulo">Departamento:</div>
				<div class="col-md-3 columna-valor">'.$_SESSION['dpto'].'</div>             
              </div><br>';                
    }

    public function vistaPermisos(){
		$data = $this->controller->Tipo_Permiso();
		echo '<div class="row col-md-12">';//Abre row col
			echo '<div id="dias_disfrutar">';
				
				echo '<div id="datos_permiso">';
					echo '<table>';	/*  leonardo.pena
							se agrega combo de seleccion para el tipo de permiso
							02/11/2018
						*/
						echo '<div id="div-tipo_permiso">';


							/*JSSH Se agrega row para Tipo de permiso */
							echo '<div class="row">';

								echo '<div class="col-md-2">';						
										echo '<label><b>Tipo de Permiso </b></label>';
								echo '</div>';

								echo '<div class="col-md-4">';
										echo'<select id="tipo_permiso">';
											echo'<option value ="0" >Seleccione un tipo de permiso</option>';
												foreach ($data as $row) {                
											echo'<option value ='.$row['ID'].' >'.$row['TipoPermiso'].'</option>';
												}
										echo'</select>';
								echo '</div>';//Cierra Div Col Tipo Permiso				

								/*JSSH Se agrega row para Hora Inicio */
								echo '<div class="col-md-2">';										
									echo '<label><b>Hora inicio</b></label>';
								echo '</div>';

								echo '<div class="col-md-4">';	
									echo'<select id="hora_inicio">';
										echo'<option value ="00:00" >00:00</option>';
										echo'<option value ="00:15" >00:15</option>';
										echo'<option value ="00:30" >00:30</option>';
										echo'<option value ="00:45" >00:45</option>';
										echo'<option value ="01:00" >01:00</option>';
										echo'<option value ="01:15" >01:15</option>';
										echo'<option value ="01:30" >01:30</option>';
										echo'<option value ="01:45" >01:45</option>';
										echo'<option value ="02:00" >02:00</option>';
										echo'<option value ="02:15" >02:15</option>';
										echo'<option value ="02:30" >02:30</option>';
										echo'<option value ="02:45" >02:45</option>';
										echo'<option value ="03:00" >03:00</option>';
										echo'<option value ="03:15" >03:15</option>';
										echo'<option value ="03:30" >03:30</option>';
										echo'<option value ="03:45" >03:45</option>';
										echo'<option value ="04:00" >04:00</option>';
										echo'<option value ="04:15" >04:15</option>';
										echo'<option value ="04:30" >04:30</option>';
										echo'<option value ="04:45" >04:45</option>';
										echo'<option value ="05:00" >05:00</option>';
										echo'<option value ="05:15" >05:15</option>';
										echo'<option value ="05:30" >05:30</option>';
										echo'<option value ="05:45" >05:45</option>';
										echo'<option value ="06:00" >06:00</option>';
										echo'<option value ="06:15" >06:15</option>';
										echo'<option value ="06:30" >06:30</option>';
										echo'<option value ="06:45" >06:45</option>';
										echo'<option value ="07:00" >07:00</option>';
										echo'<option value ="07:15" >07:15</option>';
										echo'<option value ="07:30" >07:30</option>';
										echo'<option value ="07:45" >07:45</option>';
										echo'<option value ="08:00"  selected>08:00</option>';
										echo'<option value ="08:15" >08:15</option>';
										echo'<option value ="08:30" >08:30</option>';
										echo'<option value ="08:45" >08:45</option>';
										echo'<option value ="09:00" >09:00</option>';
										echo'<option value ="09:15" >09:15</option>';
										echo'<option value ="09:30" >09:30</option>';
										echo'<option value ="09:45" >09:45</option>';
										echo'<option value ="10:00" >10:00</option>';
										echo'<option value ="10:15" >10:15</option>';
										echo'<option value ="10:30" >10:30</option>';
										echo'<option value ="10:45" >10:45</option>';
										echo'<option value ="11:00" >11:00</option>';
										echo'<option value ="11:15" >11:15</option>';
										echo'<option value ="11:30" >11:30</option>';
										echo'<option value ="11:45" >11:45</option>';
										echo'<option value ="12:00" >12:00</option>';
										echo'<option value ="12:15" >12:15</option>';
										echo'<option value ="12:30" >12:30</option>';
										echo'<option value ="12:45" >12:45</option>';
										echo'<option value ="13:00" >13:00</option>';
										echo'<option value ="13:15" >13:15</option>';
										echo'<option value ="13:30" >13:30</option>';
										echo'<option value ="13:45" >13:45</option>';
										echo'<option value ="14:00" >14:00</option>';
										echo'<option value ="14:15" >14:15</option>';
										echo'<option value ="14:30" >14:30</option>';
										echo'<option value ="14:45" >14:45</option>';
										echo'<option value ="15:00" >15:00</option>';
										echo'<option value ="15:15" >15:15</option>';
										echo'<option value ="15:30" >15:30</option>';
										echo'<option value ="15:45" >15:45</option>';
										echo'<option value ="16:00" >16:00</option>';
										echo'<option value ="16:15" >16:15</option>';
										echo'<option value ="16:30" >16:30</option>';
										echo'<option value ="16:45" >16:45</option>';
										echo'<option value ="17:00" >17:00</option>';
										echo'<option value ="17:15" >17:15</option>';
										echo'<option value ="17:30" >17:30</option>';
										echo'<option value ="17:45" >17:45</option>';
										echo'<option value ="18:00" >18:00</option>';
										echo'<option value ="18:15" >18:15</option>';
										echo'<option value ="18:30" >18:30</option>';
										echo'<option value ="18:45" >18:45</option>';
										echo'<option value ="19:00" >19:00</option>';
										echo'<option value ="19:15" >19:15</option>';
										echo'<option value ="19:30" >19:30</option>';
										echo'<option value ="19:45" >19:45</option>';
										echo'<option value ="20:00" >20:00</option>';
										echo'<option value ="20:15" >20:15</option>';
										echo'<option value ="20:30" >20:30</option>';
										echo'<option value ="20:45" >20:45</option>';
										echo'<option value ="21:00" >21:00</option>';
										echo'<option value ="21:15" >21:15</option>';
										echo'<option value ="21:30" >21:30</option>';
										echo'<option value ="21:45" >21:45</option>';
										echo'<option value ="22:00" >22:00</option>';
										echo'<option value ="22:15" >22:15</option>';
										echo'<option value ="22:30" >22:30</option>';
										echo'<option value ="22:45" >22:45</option>';
										echo'<option value ="23:00" >23:00</option>';
										echo'<option value ="23:15" >23:15</option>';
										echo'<option value ="23:30" >23:30</option>';
										echo'<option value ="23:45" >23:45</option>';
									echo'</select>';
								echo'</div>';//Cierra Div Hora Inicio
							echo '</div>';//Cierra Div Tipo de Permiso

							/* termina el agregado combo de seleccion*/

							/*JSSH Se agrega row para Motivo permiso */
							echo '<div class="row">';

								echo '<div class="col-md-2">';					
									echo '<label><b>Motivo </b></label>';
								echo '</div>';

									echo '<div class="col-md-4">
											<textarea id="motivo_permiso" rows="2" cols="42" placeholder="Ingresar el motivo del permiso" required style="overflow:auto;resize:none"></textarea>
										</div>';						
									/*echo '<p>Hora inicio:</p><input type="time" name="hora_inicio" value="08:00" required>'; */
									
								
							
								
								echo '<div class="col-md-2">';								
									echo '<label><b>Hora fin</b></label>';
								echo '</div>';
												
								echo '<div class="col-md-4">';
									echo '<select id="hora_fin">';							
										echo'<option value ="00:00" >00:00</option>';
										echo'<option value ="00:15" >00:15</option>';
										echo'<option value ="00:30" >00:30</option>';
										echo'<option value ="00:45" >00:45</option>';
										echo'<option value ="01:00" >01:00</option>';
										echo'<option value ="01:15" >01:15</option>';
										echo'<option value ="01:30" >01:30</option>';
										echo'<option value ="01:45" >01:45</option>';
										echo'<option value ="02:00" >02:00</option>';
										echo'<option value ="02:15" >02:15</option>';
										echo'<option value ="02:30" >02:30</option>';
										echo'<option value ="02:45" >02:45</option>';
										echo'<option value ="03:00" >03:00</option>';
										echo'<option value ="03:15" >03:15</option>';
										echo'<option value ="03:30" >03:30</option>';
										echo'<option value ="03:45" >03:45</option>';
										echo'<option value ="04:00" >04:00</option>';
										echo'<option value ="04:15" >04:15</option>';
										echo'<option value ="04:30" >04:30</option>';
										echo'<option value ="04:45" >04:45</option>';
										echo'<option value ="05:00" >05:00</option>';
										echo'<option value ="05:15" >05:15</option>';
										echo'<option value ="05:30" >05:30</option>';
										echo'<option value ="05:45" >05:45</option>';
										echo'<option value ="06:00" >06:00</option>';
										echo'<option value ="06:15" >06:15</option>';
										echo'<option value ="06:30" >06:30</option>';
										echo'<option value ="06:45" >06:45</option>';
										echo'<option value ="07:00" >07:00</option>';
										echo'<option value ="07:15" >07:15</option>';
										echo'<option value ="07:30" >07:30</option>';
										echo'<option value ="07:45" >07:45</option>';
										echo'<option value ="08:00" >08:00</option>';
										echo'<option value ="08:15" >08:15</option>';
										echo'<option value ="08:30" >08:30</option>';
										echo'<option value ="08:45" >08:45</option>';
										echo'<option value ="09:00" selected>09:00</option>';
										echo'<option value ="09:15" >09:15</option>';
										echo'<option value ="09:30" >09:30</option>';
										echo'<option value ="09:45" >09:45</option>';
										echo'<option value ="10:00" >10:00</option>';
										echo'<option value ="10:15" >10:15</option>';
										echo'<option value ="10:30" >10:30</option>';
										echo'<option value ="10:45" >10:45</option>';
										echo'<option value ="11:00" >11:00</option>';
										echo'<option value ="11:15" >11:15</option>';
										echo'<option value ="11:30" >11:30</option>';
										echo'<option value ="11:45" >11:45</option>';
										echo'<option value ="12:00" >12:00</option>';
										echo'<option value ="12:15" >12:15</option>';
										echo'<option value ="12:30" >12:30</option>';
										echo'<option value ="12:45" >12:45</option>';
										echo'<option value ="13:00" >13:00</option>';
										echo'<option value ="13:15" >13:15</option>';
										echo'<option value ="13:30" >13:30</option>';
										echo'<option value ="13:45" >13:45</option>';
										echo'<option value ="14:00" >14:00</option>';
										echo'<option value ="14:15" >14:15</option>';
										echo'<option value ="14:30" >14:30</option>';
										echo'<option value ="14:45" >14:45</option>';
										echo'<option value ="15:00" >15:00</option>';
										echo'<option value ="15:15" >15:15</option>';
										echo'<option value ="15:30" >15:30</option>';
										echo'<option value ="15:45" >15:45</option>';
										echo'<option value ="16:00" >16:00</option>';
										echo'<option value ="16:15" >16:15</option>';
										echo'<option value ="16:30" >16:30</option>';
										echo'<option value ="16:45" >16:45</option>';
										echo'<option value ="17:00" >17:00</option>';
										echo'<option value ="17:15" >17:15</option>';
										echo'<option value ="17:30" >17:30</option>';
										echo'<option value ="17:45" >17:45</option>';
										echo'<option value ="18:00" >18:00</option>';
										echo'<option value ="18:15" >18:15</option>';
										echo'<option value ="18:30" >18:30</option>';
										echo'<option value ="18:45" >18:45</option>';
										echo'<option value ="19:00" >19:00</option>';
										echo'<option value ="19:15" >19:15</option>';
										echo'<option value ="19:30" >19:30</option>';
										echo'<option value ="19:45" >19:45</option>';
										echo'<option value ="20:00" >20:00</option>';
										echo'<option value ="20:15" >20:15</option>';
										echo'<option value ="20:30" >20:30</option>';
										echo'<option value ="20:45" >20:45</option>';
										echo'<option value ="21:00" >21:00</option>';
										echo'<option value ="21:15" >21:15</option>';
										echo'<option value ="21:30" >21:30</option>';
										echo'<option value ="21:45" >21:45</option>';
										echo'<option value ="22:00" >22:00</option>';
										echo'<option value ="22:15" >22:15</option>';
										echo'<option value ="22:30" >22:30</option>';
										echo'<option value ="22:45" >22:45</option>';
										echo'<option value ="23:00" >23:00</option>';
										echo'<option value ="23:15" >23:15</option>';
										echo'<option value ="23:30" >23:30</option>';
										echo'<option value ="23:45" >23:45</option>';
									echo'</select>';					
								echo '</div>';//Cierra Div de Hora Fin

							echo '</div>';//Cierra Div motivo permiso

						echo '</div>';//Cierra Div Tipo permiso			
					echo '</table>';//Cierra Table 
				echo '</div><!--Cierra ID = datos permiso-->
				

				<!--JSSH Se agrega row para Calendario y aviso de dias autorizados y boton-->
						<br>
						<div class="row">
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">
								<div id="calendar"><p id="mensaje"><p>
								</div>
							</div>
							<div id="detalle_vacaciones">
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div id="div_fechas_seleccionadas">
												<p id="total_dias">Días seleccionados: 0</p>
												<ul id="fechas_seleccionadas"></ul>
											</div>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div id="div_fechas_pendientes">
												<p id="total_dias_pendientes">En autorización: 0</p>
												<ul id="fechas_pendientes"></ul>
											</div>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div id="div_fechas_autorizadas">
												<p id="total_dias_autorizados">Autorizados: 0</p>
												<ul id="fechas_autorizadas"></ul>
											</div>
										</div>
									</div>
								</div>
							</div>       
						</div>


					
					<div class="row">
						<div class="col-sm-12">							
							
							<button style="margin: 10px;" type="button" class="btn btn-default" id="solicitar_autorizacion_permisos" disabled= "disabled">Solicitar autorización</button>
						</div>	
					</div>';						


				
				/*
				Se Agrega funcion para poder borrar Permisos 
				Leonardo Rafael Peña.
				21/02/2019
				*/
				//
				$data1 = $this->controller->empleados();
				if($_SESSION['tipo'] ==1){
				echo '<div id="CancelarPermiso">';
					echo '<div class="row">';	
						echo '<div id="contenido-flex">';
							echo '<div class="row">							
										<h3>Eliminar Permisos</h3>';

								echo'<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';

									echo'<div>
										<label>Buscar Empleado:</label>';
									echo'<select id="select_empleado">';
										echo'<option value ="0" >Seleccione un Empleado</option>';
										foreach ($data1 as $row1) {                
										echo'<option value ='.$row1['Empleado'].' >'.$row1['Empleado'].'- '.$row1['Nombre'].'</option>';
										}
									echo'</select>&nbsp;&nbsp;<button style="margin: 10px;" type="button" class="btn btn-default" id="buscar_permisos_empleado">Buscar</button>';
								echo'</div>';

								echo'<br>';

								echo '<table><tbody id="TablaPermisos">';
								//echo'<tr><td><label>Permisos:</label></td></tr>';
								echo '</tbody></table>';
							echo '</div>';
						echo '</div>';
					echo '</div>';	
				echo '</div>';
				}
				//			
			echo '</div>';   
			     
    }

    public function vistaAutorizador(){
        $data = $this->controller->diasPendientesAutorizar($_SESSION['usuario']);
        $empleado_anterior;
        $permiso_anterior;
        $first = true;

        if ($data) {
            echo '<div id="dias_pendientes">
					<p class="titulo">PENDIENTE POR AUTORIZAR</p>
						<div class="table">
							<tr>
								<td>';
									foreach ($data as $row) {                
										if ($first) {
											$empleado_anterior = $row['Empleado'];
											$permiso_anterior = $row['Permiso'];
											$first = false;
											echo '<table class="tabla-solicitudes"  id="'.$row['Empleado'].'">';
											echo    '<thead> 
														<tr>
															<th></th>
															<th>'.$row['Nombre'].'</th>                                  
															<th><button class="btn btn-default autorizar_permisos">Autorizar</button></th>
														</tr>
													</thead>';
											echo '<tbody>';
											echo '<tr>
													<td><span class="btn-rechazar" title="Rechazar permiso">x</span></td>                       
													<td id="motivo_permiso_detalle"><strong>MOTIVO: </strong>'.$row['Motivo'].'<strong><br>HORARIO: '.$row['HoraInicio']->format('H:i').' - '.$row['HoraFin']->format('H:i').'<br>FECHA(s): ';
										}

										if ($empleado_anterior == $row['Empleado']) {
											if ($permiso_anterior != $row['Permiso']) {
												echo '</strong></td><td data-title="Autorizar"><input class="form-control" type="checkbox" checked/></td></tr>';
												echo '<tr>
													<td><span class="btn-rechazar" title="Rechazar permiso">x</span></td>                       
													<td id="motivo_permiso_detalle"><strong>MOTIVO: </strong>'.$row['Motivo'].'<strong><br>HORARIO: '.$row['HoraInicio']->format('H:i').' - '.$row['HoraFin']->format('H:i').'<br>FECHA(s): '; 
												$permiso_anterior = $row['Permiso'];
											}
											echo ''.$row['Fecha'].', ';
										}
										else{
											echo '</strong></td><td data-title="Autorizar"><input class="form-control" type="checkbox" checked/></td></tr>';
											echo '</tbody>';
											echo '</table>';
											echo '<table class="tabla-solicitudes" id="'.$row['Empleado'].'">';
											echo    '<thead> 
														<tr>
															<th></th>
															<th>'.$row['Nombre'].'</th>                               
															<th><button class="btn btn-default autorizar_permisos">Autorizar</button></th>
														</tr>
													</thead>';
											echo '<tbody>';
											echo '<tr>
													<td><span class="btn-rechazar" title="Rechazar permiso">x</span></td>                       
													<td id="motivo_permiso_detalle"><strong>MOTIVO: </strong>'.$row['Motivo'].'<strong><br>HORARIO: '.$row['HoraInicio']->format('H:i').' - '.$row['HoraFin']->format('H:i').'<br>FECHA(s): '.$row['Fecha'].', ';                   
											$empleado_anterior = $row['Empleado'];
											$permiso_anterior = $row['Permiso'];
										}

										if ($row == end($data)) {
											echo '</strong></td>
												<td data-title="Autorizar"><input class="form-control" type="checkbox" checked/></td>                            
											</tr>';
											echo '</tbody>';
											echo '</table>';
										}
									}
            					echo '</td>';
            				echo '</tr>';
            			echo '</div>';
            	echo '</div>'; 
			echo '</div>';//Cierra row col 	
        }  
    }

    public function vistaPendienteAutorizar(){
        $data = $this->controller->obtenerFechas($_SESSION['usuario']);
        $empleado_anterior;
        $permiso_anterior;
        $first = true;

        if ($data['success']) {
            echo '<div id="dias_pendientes">';
            echo '<p class="titulo">EN AUTORIZACIÓN</p>';
            echo '<table class="table">';
            echo '<tr>';
            echo '<td>';
            foreach ($data['data'] as $row) {
                if ($row['estado'] == 1) {   
                    if ($first) {
                        $permiso_anterior = $row['Permiso'];
                        $first = false;
                        echo '<table class="tabla-solicitudes"  id="'.$row['Empleado'].'">';
                        echo    '<thead> 
                                    <tr>
                                        <th>'.$_SESSION['nombre'].'</th>
                                    </tr>
                                </thead>';
                        echo '<tbody>';
                        echo '<tr>                       
                                <td id="motivo_permiso_detalle"><strong>MOTIVO: </strong>'.$row['Motivo'].'<strong><br>HORARIO: '.$row['HoraInicio']->format('H:i').' - '.$row['HoraFin']->format('H:i').'<br>FECHA(s): ';
                    }

                    if ($permiso_anterior == $row['Permiso']) {
                        echo ''.$row['Fecha'].', ';                   
                    }
                    else{
                        echo '</strong></td></tr>';
                        echo '<tr>                       
                            <td id="motivo_permiso_detalle"><strong>MOTIVO: </strong>'.$row['Motivo'].'<strong><br>HORARIO: '.$row['HoraInicio']->format('H:i').' - '.$row['HoraFin']->format('H:i').'<br>FECHA(s): ';
                        echo ''.$row['Fecha'].', ';    
                        $permiso_anterior = $row['Permiso'];
                    }
                    if ($row == end($data)) {
                        echo '</strong></td></tr>';
                        echo '</tbody>';
                        echo '</table>';
                    }
                }
            }
            echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';
        }  
    } 

    public function autorizarPermisos($empleado, $fechas){
        $data = $this->controller->autorizarPermisos($empleado, $fechas);
        echo json_encode($data);      
    }

    public function solicitarAutorizacionPermisos($empleado){
        $data = $this->controller->solicitarAutorizacionPermisos($empleado);
		echo json_encode($data);      
    }

    public function insertarFechas($empleado, $fechas, $motivo, $horainicio, $horafin, $TipoMotivo){        
        $data = $this->controller->insertarFechas($empleado, $fechas, $motivo, $horainicio, $horafin, $TipoMotivo);
		 echo json_encode($data);
    }

    public function obtenerFechas($username){
        $data = $this->controller->obtenerFechas($username);
        echo json_encode($data);
    }

    public function rechazarVacaciones($empleado, $fechas){
        $data = $this->controller->rechazarVacaciones($empleado, $fechas);
        echo $data;  
    }

    public function eliminarFecha($empleado, $fechas, $HoraInicio, $HoraFin){
        $data = $this->controller->eliminarFecha($empleado, $fechas, $HoraInicio, $HoraFin);
        echo $data;  
    }
	
	public function TipoPermiso(){
		
		
	}
	public function listadoPermisos($Empleado){
		 $data = $this->controller->listadoPermisos($Empleado);
         echo json_encode($data);
	}

}