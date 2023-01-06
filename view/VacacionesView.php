<?php
class VacacionesView
{
    private $model;
    private $controller;

    public function __construct() {
        $this->model = new VacacionesModel();        
        $this->controller = new VacacionesController($this->model);
    }
	
    public function output(){
        return "view/Vacaciones.php";
    }

    public function vistaVacaciones(){
        echo 
        '<div class="row col-md-12">
			<br>
            <div id="dias_disfrutar">
                    <div class="row">
                        <div class="col-sm-6">';
                            $this->saldos($_SESSION['usuario']);
                        echo '</div>';
                        echo '<div class="col-sm-6">';
                            $this->saldosAdelantados($_SESSION['usuario']);
                        echo '</div>
                    </div>
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
                        <button class="btn btn-default" id="guardar_dias_marcados">Guardar</button>
                        <button class="btn btn-default" id="cancelar_dias_marcados">Cancelar</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-default" id="solicitar_autorizacion_dias_marcados">Solicitar autorización</button>
                    </div>
                </div>
            </div>';            
    }

    public function vistaAutorizador(){
        $data = $this->controller->diasPendientesAutorizar($_SESSION['usuario']);
        $empleado_anterior;
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
                                        $first = false;
                                        echo '<table class="tabla-solicitudes"  id="'.$row['Empleado'].'">';
                                        echo    '<thead> 
                                                    <tr>
                                                        <!--<th>'.$row['Empleado'].'</th>-->
                                                        <th></th>
                                                        <th>'.$row['Nombre'].'</th>                                  
                                                        <th><button class="btn btn-default autorizar_vacaciones">Autorizar</button></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';                    
                                    }

                                    if ($empleado_anterior == $row['Empleado']) {
                                        echo '<tr>
                                                <td><span class="btn-rechazar" title="Rechazar fecha">x</span></td>                    
                                                <td data-title="Fecha solicitada" class="centrar">'.$row['Fecha'].'</td>                            
                                                <td data-title="Autorizar"><input class="form-control" type="checkbox" value="'.$row['Fecha'].'" checked/></td>
                                            </tr>';               
                                    }
                                    else{
                                        echo '</tbody>
                                            </table>
                                                <table class="tabla-solicitudes" id="'.$row['Empleado'].'">
                                                <thead> 
                                                    <tr>
                                                        <!--<th>'.$row['Empleado'].'</th>-->
                                                        <th></th>
                                                        <th>'.$row['Nombre'].'</th>                                
                                                        <th><button class="btn btn-default autorizar_vacaciones">Autorizar</button></th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                            <tr>
                                                <td><span class="btn-rechazar">x</span></td>                       
                                                <td data-title="Fecha solicitada" class="centrar">'.$row['Fecha'].'</td>
                                                <td data-title="Autorizar"><input class="form-control" type="checkbox" value="'.$row['Fecha'].'" checked/></td>
                                            </tr>';
                                        $empleado_anterior = $row['Empleado'];
                                    }

                                    if ($row == end($data)) {
                                        echo '</tbody>
                                        </table>';
                                    }
                                }
                                echo '</td>
                            </tr>
                        </div>
                    </div>'; 
        }  
    }


    

    public function vistaAutorizadorCancelar(){
        $data = $this->controller->diasAutorizados($_SESSION['usuario']);
        $empleado_anterior;
        $first = true;

        if ($data) {           
                echo '<div id="dias_pendientes">
                        <p class="titulo">AUTORIZADOS</p>';            
                        /*echo '<table class="table">';
                        echo '<tr>';
                        echo '<td>';*/
                        
                            echo '<div id="dias_autorizados">';  
                            echo '<div class="table">';          
                                    foreach ($data as $row) {                
                                        if ($first) {
                                            $empleado_anterior = $row['Empleado'];
                                            $first = false;
                                            echo '<table class="tabla-solicitudes"  id="'.$row['Empleado'].'">
                                                    <thead> 
                                                        <tr>
                                                            <!--<th>'.$row['Empleado'].'</th>-->
                                                            <th></th>
                                                            <th>'.$row['Nombre'].'</th>                                  
                                                            <!--<th><button class="btn btn-default cancelar_vacaciones">Cancelar</button></th>-->
                                                        </tr>
                                                    </thead>
                                                <tbody>';                    
                                        }

                                        if ($empleado_anterior == $row['Empleado']) {
                                            echo '<tr>
                                                    <td><span class="btn-cancelar" title="Cancelar fecha autorizada">x</span></td>                    
                                                    <td data-title="Fecha solicitada" class="centrar">'.$row['Fecha'].'</td>                            
                                                    <!--<td data-title="Cancelar"><input class="form-control" type="checkbox" value="'.$row['Fecha'].'" checked/></td>-->
                                                </tr>';               
                                        }
                                        else{
                                            echo '</tbody>
                                                </table>
                                                <table class="tabla-solicitudes" id="'.$row['Empleado'].'">
                                                    <thead> 
                                                        <tr>
                                                            <!--<th>'.$row['Empleado'].'</th>-->
                                                            <th></th>
                                                            <th>'.$row['Nombre'].'</th>                                
                                                            <!--<th><button class="btn btn-default cancelar_vacaciones">Cancelar</button></th>-->
                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                <tr>
                                                    <td><span class="btn-cancelar" title="Cancelar fecha autorizada">x</span></td>                       
                                                    <td data-title="Fecha solicitada" class="centrar">'.$row['Fecha'].'</td>
                                                    <!--<td data-title="Cancelar"><input class="form-control" type="checkbox" value="'.$row['Fecha'].'" checked/></td>-->
                                                </tr>';
                                            $empleado_anterior = $row['Empleado'];
                                        }

                                        if ($row == end($data)) {
                                            echo '</tbody>
                                            </table>';
                                        }
                                    }
                            /*echo '</td>';
                            echo '</tr>';
                            echo '</table>';*/
                            echo '</div>
                        </div>    
                        </div>
                    </div>';   	
       	
        }  
    } 
    
    
    public function vistaAdministrador(){
        $data = $this->controller->empleados();
        if ($data) {
            echo '<div class="container">';
                echo '<div class="row">';
                    echo '<div>';                       
                            echo '<div class="row" id="titulo_tabla_empleados">Empleados</div>';
                            echo '<div class="row" id="contenedor_buscar">
                                    <input id="unidad_negocio" type="hidden" value="'.$_SESSION['unidaddenegocio'].'">
                                    <div class="col-md-1" style="margin: 10px">
                                        <label>Buscar: </label>
                                    </div>
                                        <div class="col-md-3" style="margin: 10px">
                                            <input type="text" class="autocompletar no_empleado" placeholder="No. Empleado"></input>
                                        </div>
                                        <div class="col-md-3" style="margin: 10px">
                                            <input type="text" class="autocompletar nombre_empleado" placeholder="Nombre"></input>
                                        </div>
                                        <div class="col-md-3" style="margin: 10px">    
                                            <input type="text" class="autocompletar nombre_autorizador" placeholder="Autorizador"></input>
                                        </div>                                          
                                </div>';

                        echo '<tr><td>';          
                            echo '<div class="row" id="no-more-tables">';
                                echo '<table class="tabla-empleados" id="tabla-administracion-empleados">';
                                    echo '<thead> 
                                            <tr>
                                                <th>Autorizador</th>
                                                <th></th>
                                                <th>Empleado</th>
                                                <th>Nombre</th>            
                                                <th>Contraseña</th>                                                
                                                <th>Correo</th>
                                                <th>Saldo</th>
                                                <th>Nombre autorizador</th>                                                
                                            </tr>
                                        </thead>';
                                    echo '<tbody>';
                                        foreach ($data as $row) {
                                            echo '<tr>';
                                                    if($row['EsAutorizador']){
                                                        echo '<td data-title="Autorizador">
                                                                <input class="form-control" type="checkbox" value="'.$row['Empleado'].'" checked/>
                                                            </td>';
                                                            
                                                    }
                                                    else{
                                                        echo '<td data-title="Autorizador">
                                                                <input class="form-control" type="checkbox" value="'.$row['Empleado'].'"/>
                                                            </td>';
                                                    }
                                                    echo '<td id="editar-saldo-btn" valor="'.$row['Empleado'].'">
                                                            <img src="assets/img/editar_1.png" title="Editar" width="20" height="20" alt="Editar" class="img-responsive">
                                                        </td>
                                                        
                                                        
                                                    <td data-title="Empleado" class="centrar">'.$row['Empleado'].'</td>

                                                    <td data-title="Nombre">'.$row['Nombre'].'</td>

                                                    <td data-title="Contraseña" class="centrar col-contraseña">'.$row['Pass'].'</td>
                                                    
                                                    <td data-title="Correo">'.$row['Correo'].'</td>

                                                    <td data-title="Saldo" class="centrar">'.$row['Saldo'].'</td>

                                                    <td data-title="Nombre_autorizador">
                                                        <select class="form-control" id="autorizador'.$row['Empleado'].'">
                                                            <option value="'.$row['Autorizador'].'">'.$row['Nombre_Autorizador'].'
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>';
                                        }
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        echo '</tr></td>';


                    echo '</div>';
                echo '</div>';
            echo '</div>';            
        }
        else{
            echo '<label class="pp-left-5">No hay empleados.</label>';
        }
    }

    public function vistaActualizarEmpleado(){
        echo '<div class="modal fade" id="actualizar_empleado_modal" tabindex="-1" role="dialog" aria-labelledby="actualizar_empleado_modal_label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar correo</h5>
                    <p>Asignar el correo al autorizador.</p>
                  </div>
                  <div class="modal-body">                    
                    <div class="form-group">
                        <label for="empleado">No. Empleado:</label>
                        <input id="empleado" type="text" name="empleado" class="form-control" placeholder="No. Empleado" disabled/> 
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input id="correo" type="email" name="correo" class="form-control" placeholder="Correo" required autofocus />        
                    </div>
                    <div class="form-group">
                        <label for="confirm_correo">Confirmar correo:</label>
                        <input id="confirm_correo" type="email" name="confirm_correo" class="form-control" placeholder="Confirmar correo" required />
                        <p id="mensaje"><p>        
                    </div>                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar_correo_btn">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="cambiar_correo_btn" disabled="disabled">Aceptar</button>
                  </div>
                </div>
              </div>
            </div>';
    }

    public function vistaActualizarSaldos($empleado){
        echo '<div class="modal fade" id="actualizar_saldo_empleado_modal" tabindex="-1" role="dialog" aria-labelledby="actualizar_empleado_modal_label" aria-hidden="true" data-backdrop="static" data-keyboard="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar saldos</h5>
                    <p>Administrar saldos para el empleado.</p>
                  </div>
                  <div class="modal-body">                    
                    <div class="form-group">
                        <label for="empleado">No. Empleado:</label>
                        <input id="empleado" type="text" name="empleado" class="form-control" placeholder="No. Empleado" disabled/> 
                        <label for="nombre-usuario">Usuario:</label>
                        <input id="nombre-usuario" type="text" name="nombre-usuario" class="form-control" disabled/> 
                    </div>
                    <div class="row">                       
                            <div class="col-md-6" style="margin-bottom: 20px"; >
                                <input id="nuevo-anio" name="nuevo-anio" type="number" placeholder="año"/></p>
                                <input id="nuevo-saldo" name="nuevo-saldo" type="number" placeholder="saldo"/>                              
                            </div>
          
                            <div class="col-md-6">
                                <label class="CheckAdelantarVacaciones" for="CheckAdelantarVacaciones">Adelantar Saldo:</label>
                                <input class="big-checkbox" type="checkbox" id="CheckAdelantarVacaciones" name="CheckAdelantarVacaciones">
                                <button id="agregar-saldo-btn"><img src="assets/img/agregar.png" width="20" height="20" alt="ARZYZ" class="img-responsive" title="Agregar/Actualizar"></button>
                            </div>
                        
                    </div>';
                    $this->saldosEditar($empleado);                         
                    echo '
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>';
    }    

    public function autorizarVacaciones($empleado, $fechas){
        $data = $this->controller->autorizarVacaciones($empleado, $fechas);
        echo $data;      
    }

    public function solicitarAutorizacionVacaciones($empleado){
        $data = $this->controller->solicitarAutorizacionVacaciones($empleado);
        echo $data;      
    }

    public function datosUsuario(){
       
        /*JSSH Se realizo cambio de uso de Tablas a div para usar grid y que se ajusten a la pantalla */
        echo '<div class="row" style="margin-left: 20px;">               
                <div class="col-md-2 columna-titulo">No. Empleado:</div>
				<div class="col-md-1 columna-valor">'.$_SESSION['usuario'].'</div>
                <div class="col-md-2 columna-titulo">Nombre:</div>
				<div class="col-md-7 columna-valor">'.$_SESSION['nombre'].'</div>
                <input id="unidad_negocio" type="hidden" value="'.$_SESSION['unidaddenegocio'].'">
                <div class="col-md-2 columna-titulo">Fecha Ingreso:</div>
				<div class="col-md-1 columna-valor" id="TdFechaIngreso">'.$_SESSION['fecha_ingreso']->format('d/m/Y').'</div>
                <div class="col-md-2 columna-titulo">Antigüedad (Años):</div>
				<div class="col-md-1 columna-valor">'.$_SESSION['antiguedad'].'</div>
                <div class="col-md-3 columna-titulo">Departamento:</div>
				<div class="col-md-3 columna-valor">'.$_SESSION['dpto'].'</div>             
              </div><br>';                
    }


    public function saldos($username){
        $cont = 0;
        $data = $this->controller->obtenerSaldos($username);
        $saldo = array_sum(array_column($data, 'saldo'));
		$saldo2 = 0;
		$DiasTomadosAnticipados=0;
           
        $tabla =  '<br><h3 class="subtitulo">Días de vacaciones – Año Actual</h3><br>';
        if ($data) {
            $tabla .= '<table class="table">
                        <thead> 
                            <tr>
                                <th></th>
                                <th>Año</th>
                                <th>Saldo</th>                            
                                <th>Fecha vencimiento</th>
                                <th>Total</th>                            
                            </tr>
                        </thead>
                    <tbody>';
			foreach ($data as $row1) {
				if($row1['saldo'] > 0){
					$saldo2 = $saldo2 +$row1['saldo'];
				}
				if($row1['saldo'] =='-3'){
					$DiasTomadosAnticipados =1;
				}
			}
            foreach ($data as $row) {
                $tabla .= '<tr>
                            <td><span id="eliminar-saldo-btn" title="Eliminar">x</span></td>
                            <td data-title="Año">'.$row['anio'].'</td>';
				if($row['saldo'] > 0){		
					$tabla .=  '<td data-title="Saldo">'.$row['saldo'].'</td>';                        
				}
				else{
					$tabla .=  '<td data-title="Saldo">0</td>';
				}
				$tabla .=  '<td data-title="Fecha vencimiento">'.$row['fecha']->format('d/m/Y').'</td>';
                if ($cont == 0){
                    //echo '<td rowspan="'.count($data).'" id="saldo_dias">'.$saldo.'</td>';
                   if($saldo > 0){		
					$tabla .= '<td rowspan="'.count($data).'" id="saldo_dias1" >'.$saldo2.'</td>
                                <td rowspan="'.count($data).'" id="saldo_dias" style="display:none" >'.$saldo.'</td>
                                <td rowspan="'.count($data).'" id="ValidarDias" style="display:none" >'.$DiasTomadosAnticipados.'</td>';
					}
					else{
						$tabla .= '<td rowspan="'.count($data).'" id="saldo_dias" >'.$saldo2.'</td>
                                    <td rowspan="'.count($data).'" id="ValidarDias" style="display:none" >'.$DiasTomadosAnticipados.'</td>';
					}

				   $cont = 1;
                }
                $tabla .= '</tr>';
            }
            $tabla .= '</tbody></table>';        
        }
        else{
            $tabla .= '<label class="pp-left-5">No hay días disponibles.</label>';
        }
        echo $tabla; 
    }
	/* */
	public function saldosEditar($username){
        $cont = 0;
        $data = $this->controller->obtenerSaldos($username);
        $saldo = array_sum(array_column($data, 'saldo'));
        
        $tabla = '<h3 class="subtitulo">SALDOS</h3><br>';        
        if ($data) {
            $tabla .= '<table class="table">
                            <thead> 
                                <tr>
                                    <th></th>
                                    <th>Año</th>
                                    <th>Saldo</th>                            
                                    <th>Fecha vencimiento</th>
                                    <th>Total</th>                            
                                </tr>
                            </thead>
                        <tbody>';
            foreach ($data as $row) {
                $tabla .= '<tr>
                            <td><span id="eliminar-saldo-btn" title="Eliminar">x</span></td>
                            <td data-title="Año" id="Anio">'.$row['anio'].'</td>
                            <td data-title="Saldo">'.$row['saldo'].'</td>
                            <td data-title="Fecha vencimiento">'.$row['fecha']->format('d/m/Y').'</td>';
                if ($cont == 0){
                    $tabla .= '<td rowspan="'.count($data).'" id="saldo_dias">'.$saldo.'</td>';
				    $cont = 1;
                }
                
                /*
                si el diseño de esta tabla se rompe por que loe hace falta un TD para completarla es posible que se requiera agregar el siguiente else

                else{
                    $tabla .= '<td rowspan="'.count($data).'" id="saldo_dias">'.$saldo.'</td>';
                    $cont = 1;
                }*/
                $tabla .= '</tr>';
            }
            $tabla .= '</tbody></table>';    
        }
        else{
            $tabla .= '<label class="pp-left-5">No hay días disponibles.</label>';
        }
        echo $tabla; 
    }
	/* */
	 public function saldosAdelantados($username){
        $cont = 0;
		$data = $this->controller->obtenerSaldosAdelantados($username);
        //$data = $this->controller->obtenerSaldosAnticipado($username);
        $saldo = array_sum(array_column($data, 'total'));

        $tabla = '<br><h3 class="subtitulo">Días de vacaciones – Siguiente Año</h3><br>';        
        if ($data) {
            $tabla .= '<table class="table">
                            <thead> 
                                <tr>
                                    <th></th>
                                    <th>Año Sig. </th>
                                    <th>Dias Por Asignar</th>
                                    <th>Dias Anticipados</th>                            
                                    
                                    <th>Total</th>                            
                                </tr>
                            </thead>
                            <tbody>';
            foreach ($data as $row) {
                $tabla .= '<tr>
                                <td><span id="eliminar-saldo-btn" title="Eliminar">x</span></td>
                                <td data-title="AnioSiguiente">'.$row['AnioSiguiente'].'</td>
                                <td data-title="DiasOtorgados">'.$row['DiasOtorgados'].'</td>
                                <td data-title="SaldosAdelantados">'.$row['SaldosAdelantados'].'</td>  
                                <td data-title="total" id="saldo_adelantado">'.$row['total'].'</td>
                            </tr>';
            }
            $tabla .= '</tbody></table>';        
        }
        else{
            $tabla .= '<label class="pp-left-5">No hay días disponibles.</label>';
        }
        echo $tabla;
    }
	/**/
    public static function vistaAsignarAutorizador(){
        echo '<div class="w2ui-field">
                <label>Autorizador:</label>
                <div>
                    <input id="list" style="width: 300px;">
                </div>
            </div>';
    }
	
	//
	
	public function vistaSolitarVacaciones(){
		$data1 = $this->controller->listadoempleados();
		//$data2 = $this->controller->obtenerSaldosEmpleados($username);

         echo '<br><div id="dias_disfrutar">';
            echo '<div>'; 
				//
				echo '<div>';
				//
				echo '<div class="form-group">
                        <input id="unidad_negocio" type="hidden" value="'.$_SESSION['unidaddenegocio'].'">
                        <label for="select_empleado">Buscar Empleado:</label>
						<select name="select_empleado" id="select_empleado" onchange="LimpiarCalendario()">
						<option value ="0" >Seleccione un Empleado</option>';
                       foreach ($data1 as $row1) {                
						echo'<option value ='.$row1['Empleado'].' >'.$row1['Empleado'].'- '.$row1['Nombre'].'</option>';
						}
                        
                 echo '</select>
						&nbsp;<button type="button" style="margin: 10px" class="btn btn-default" id="buscar_permisos_empleado" onclick="buscarinformacion()">Buscar</button>
					</div>';
				
				echo '<center><table class="table" id="MostrarInfromacion">';
				
				//
				//echo '</td><td>';
                //$this->saldos($_SESSION['usuario']);
				//
				
				//echo '</td><td>';
                //$this->saldosAdelantados($_SESSION['usuario']);
				
				//echo '</td></tr>';
				//
				echo '</table></center>';
				//
				echo '</div>';
				//
            echo '</div>
            
            <div class="row">               
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">
                    <div id="calendar2">
                        <p id="mensaje1"><p>
                    </div>
                </div>
                <div id="detalle_vacaciones1">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="div_fechas_seleccionadas1">
                                    <p id="total_dias1">Días seleccionados: 0</p>
                                    <ul id="fechas_seleccionadas1"></ul>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="div_fechas_pendientes1">
                                    <p id="total_dias_pendientes1">En autorización: 0</p>
                                    <ul id="fechas_pendientes1"></ul>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="div_fechas_autorizadas1">
                                    <p id="total_dias_autorizados1">Autorizados: 0</p>
                                    <ul id="fechas_autorizadas1"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-default" id="solicitar_autorizacion_dias_marcados1">Solicitar autorización</button>
                    </div>    
                </div>
            </div>';
    }
	//

    public function diasFestivos($anio){
        $data = $this->controller->diasFestivos($anio);
        //echo json_encode($data['data']->result_array());
        echo json_encode($data['data']);
    }

    public function insertarFechas($username, $fechas,$usuariosolicitante){        
        $data = $this->controller->insertarFechas($username, $fechas,$usuariosolicitante);
    }

    public function obtenerFechas($username){
        $data = $this->controller->obtenerFechas($username);
        echo json_encode($data['data']);
    }

    public function empleados(){
        $data = $this->controller->empleados();
        echo json_encode($data);
    }

    public function autorizadores(){
        $data = $this->controller->autorizadores();
        echo json_encode($data);
    }

    public function rechazarVacaciones($empleado, $fechas){
        $data = $this->controller->rechazarVacaciones($empleado, $fechas);
        echo $data;  
    }

    public function eliminarFecha($empleado, $fechas){
        $data = $this->controller->eliminarFecha($empleado, $fechas);
        echo $data;  
    }

    public function asignarAutorizador($empleado, $autoriza, $correo){
        $data = $this->controller->asignarAutorizador($empleado, $autoriza, $correo);
        if ($data) {
            echo 'Usuario actualizado';
        }
        else{
            echo 'No se pudo actualizar';
        }
    }

    public function insertarAutorizador($empleado, $autoriza, $correo){
        $data = $this->controller->insertarAutorizador($empleado, $autoriza, $correo);
        if ($data && $autoriza == 1) {
            echo 'Usuario '.$data[0]['Empleado'].' definido como autorizador';
        }
        elseif ($data && $autoriza == 0) {
            echo 'El usuario '.$data[0]['Empleado'].' ya no es autorizador';
        }        
        else{
            echo 'No se pudo realizar la acción solicitada';
        }
    }

    public function insertarSaldo($username, $anio, $saldo){        
        $data = $this->controller->insertarSaldo($username, $anio, $saldo);
    }

    public function eliminarSaldo($username, $anio, $saldo, $eliminar){        
        $data = $this->controller->eliminarSaldo($username, $anio, $saldo, $eliminar);
    } 
	// Leonardo Peña
	//Agregar el saldo anticipado.
	//06/03/2020
	 public function insertarSaldoAnticipado($username, $anio, $saldo){        
        $data = $this->controller->insertarSaldoAnticipado($username, $anio, $saldo);
    }
	//
	public function obtenerFechasEmpleado($username){
        $data = $this->controller->obtenerFechasEmpleado($username);
        echo json_encode($data['data']);
    }
	
	public function obtenerSaldosEmpleados($Empleado){
		 $data = $this->controller->obtenerSaldosEmpleados($Empleado);
         echo json_encode($data);
	}
}