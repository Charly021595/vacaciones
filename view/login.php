<div class="center-align pd-10">
    <img src="assets/img/logo.jpg" width="280" height="60" alt="ARZYZ" class="img-responsive">    
</div>
<div class="container">
    <form method="post">
        <div class="form-group">
            <label for="username">No. Empleado:</label>
            <input id="username" type="text" name="username" class="form-control" placeholder="No. Empleado" required/> 
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input id="password" type="password" name="password" class="form-control" placeholder="Contraseña" required/>        
        </div>
        <!--<div class="form-group">
            <label for="tipo_usuario">Tipo usuario:</label>
            <select id="tipo_usuario" name="tipo_usuario" class="form-control" required/>
            <option value="1">Normal</option>
            <option value="3">Administrador</option>
            </select>
        </div>-->        
        <!--<div class="form-group">
            <label><input type="checkbox" name="remember" value="" id="remember_credentials"> Recordar credenciales</label>
        </div>-->
        <!-- Agregar la pantalla para cambiar contraseña -->
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
                    <p>Cambio obligatorio de contraseña por primer ingreso al módulo de vacaciones.</p>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>-->
                  </div>
                  <div class="modal-body">                    
                    <div class="form-group">
                        <label for="nuevo_username">No. Empleado:</label>
                        <input id="nuevo_username" type="text" name="nuevo_username" class="form-control" placeholder="No. Empleado" disabled required /> 
                    </div>
                    <div class="form-group">
                        <label for="nuevo_password">Nueva contraseña:</label>
                        <input id="nuevo_password" type="password" name="nuevo_password" class="form-control" placeholder="Contraseña" required autofocus />        
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar contraseña:</label>
                        <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirmar contraseña" required />
                        <p id="mensaje"><p>        
                    </div>                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="cambiar_password_btn" disabled="disabled">Guardar</button>
                  </div>
                </div>
              </div>
            </div>        
        <div class="center-align">            
            <button class="btn btn-default" id="login">ENTRAR</button>
			<a id ="CambiarContrasena"><h5>Cambiar de Contraseña</h5></a>
        </div>
		
		<!--
		leonardo Peña
		12/03/2019
		Se Agrega la funcion para funcion de cambiar contraseña
		-->
		    <div class="modal fade" id="ModalContrasena" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
                  
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>-->
                  </div>
                  <div class="modal-body">                    
                    <div class="form-group">
                        <label for="nuevo_username">No. Empleado:</label>
                        <input id="NoEmpleado" type="text" name="NoEmpleado" class="form-control" placeholder="No. Empleado"  required /> 
                    </div>
					<div class="form-group">
                        <label for="nuevo_password">Contraseña anterior:</label>
                        <input id="contrasenaAnterior" type="password" name="contrasenaAnterior" class="form-control" placeholder="Contraseña anterior" required autofocus />        
                    </div>
                    <div class="form-group">
                        <label for="nuevo_password">Nueva contraseña:</label>
                        <input id="nuevaContrasena" type="password" name="nuevaContrasena" class="form-control" placeholder="Nueva Contraseña" required autofocus />        
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar contraseña:</label>
                        <input id="confirmarContrasena" type="password" name="confirmarContrasena" class="form-control" placeholder="Confirmar contraseña" required />
                        <p id="mensaje1"><p>        
                    </div>                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="cambiar_contrasena_btn" disabled="disabled">Guardar</button>
                  </div>
                </div>
              </div>
            </div> 
		<!-- -->
    </form>
</div>