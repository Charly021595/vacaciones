    <script src="//code.jquery.com/jquery-2.1.0.min.js"> </script>
    <script src="assets/js/general.js?t=<?=time()?>"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
    <script src='assets/calendar/lib/moment.min.js'></script>
    <script src='assets/calendar/fullcalendar.js'></script>
    <script src='assets/calendar/locale/es.js'></script>
    <script type="text/javascript">

    var vista = location.search.substring(location.search.length - 1, location.search.length);
    var anio_actual;
    var porcentaje_permitido = 1.3;
    var maximo_numero_dias;
	var FechadeIngreso = 0;
	var FechaActual = 0;
	var	MesActual = 0;
	var	DiaActual = 0;
	var MesIngreso =0;
	var DiaIngreso = 0;
	var AnioActual =0;
	var AnioIngreso =0;
	var AnioSiguiente = 0;
	//
	var anio_actual2;
    var porcentaje_permitido2 = 1.3;
    var maximo_numero_dias2;
	var FechadeIngreso2 = 0;
	var FechaActual2 = 0;
	var	MesActual2 = 0;
	var	DiaActual2 = 0;
	var MesIngreso2 =0;
	var DiaIngreso2 = 0;
	var AnioActual2 =0;
	var AnioIngreso2 =0;
	var AnioSiguiente2 = 0;
	//

 

    $(window).load(function() {
        $('span#eliminar-saldo-btn').css('display','none');
        $('.cargando').hide(); // Ocultar la imagen si ya se cargó el DOM.
        $('#solicitar_autorizacion_dias_marcados').attr('disabled', 'disabled');    
        // Si ya hay días marcados, habilitar el botón para solicitar autorización
        if ($('#fechas_seleccionadas li').length) {
            $('#solicitar_autorizacion_dias_marcados').removeAttr('disabled');
            $('#solicitar_autorizacion_permisos').removeAttr('disabled');
        }
        else{
            $('#solicitar_autorizacion_dias_marcados').attr('disabled', 'disabled');
            $('#solicitar_autorizacion_permisos').attr('disabled', 'disabled');
        }
		
		
		////
		if ($('#fechas_seleccionadas1 li').length) {
            $('#solicitar_autorizacion_dias_marcados1').removeAttr('disabled');
        }
        else{
            $('#solicitar_autorizacion_dias_marcados1').attr('disabled', 'disabled');
        }
		////
        $('#username').focus();
		FechadeIngreso = $("#TdFechaIngreso").text();
		
		///////////
		//
		var fechaActual = new Date(); //Fecha actual
		var fechaActual2 = moment(fechaActual).format("DD-MM-YYYY");
		var anio = fechaActual.getFullYear(); //obteniendo año
		//
		
		
		var fecha =FechadeIngreso.split("/")
		MesIngreso = parseInt(fecha[1]);
		DiaIngreso = parseInt(fecha[0]);
		if(DiaIngreso<10)
		DiaIngreso='0'+DiaIngreso; //agrega cero si el menor de 10
		if(MesIngreso<10)
		MesIngreso='0'+MesIngreso //agrega cero si el menor de 10
		////
		if(MesIngreso>6){
			var parametro = 1;
		}else{
			var parametro = 0;
            anio = anio-1;
		}
		////
		var FechaIngresoAnio= moment(anio+"-"+MesIngreso+"-"+DiaIngreso);
		var FechaIngresoAnio1 = moment(FechaIngresoAnio).add(6, 'M');
		var FechaIngresoAnio2 = moment(FechaIngresoAnio1).format('DD-MM-YYYY');
		////
		var FActual = fechaActual2.split('-');
		var FIngreso = FechaIngresoAnio2.split('-');

		//Cambiamos el orden al formato americano, de esto dd/mm/yyyy a esto mm/dd/yyyy
		if(parametro==1){
			fecha2 = FIngreso[1] + '/' + FIngreso[0] + '/' + (FIngreso[2]-1);
		}
		else{
			fecha2 = FIngreso[1] + '/' + FIngreso[0] + '/' + FIngreso[2];
		}
		fecha1 = FActual[1] + '/' + FActual[0] + '/' + FActual[2];
		//fecha2 = FIngreso[1] + '-' + FIngreso[0] + '-' + FIngreso[2];
		///////////
		
		
		if( $("#saldo_dias").length !=0){
        //if ($('td#saldo_dias').html() && ($('td#saldo_dias').html()*1 != 0)) {
			//Se documenta la linea de abajo ya que te permite agregar 2 dias mas de vacaciones si no has tomado ninguno 
            //maximo_numero_dias = Math.round($('td#saldo_dias').html() * porcentaje_permitido);
			maximo_numero_dias = Math.round($('td#saldo_dias').html());
			maximo_numero_dias = maximo_numero_dias + $('#fechas_pendientes li').length;
			//
			var ParamValidarDias= $("#ValidarDias").text(); 
			if(ParamValidarDias !=1)
			{
				//
				if(maximo_numero_dias == -1){
					maximo_numero_dias =2;
				}
				else if(maximo_numero_dias == -2){
					maximo_numero_dias = 1
				}
				else if(Date.parse(fecha1) >= Date.parse(fecha2)){
					maximo_numero_dias = maximo_numero_dias+3;
				}
				//
			}
        }
        else{
            maximo_numero_dias = 0;
			var ParamValidarDias= $("#ValidarDias").text(); 
			if(ParamValidarDias !=1)
			{
				if(maximo_numero_dias == -1){
					maximo_numero_dias =2;
				}
				else if(maximo_numero_dias == -2){
					maximo_numero_dias = 1
				}
				else if(Date.parse(fecha1) >= Date.parse(fecha2)){
					maximo_numero_dias = maximo_numero_dias+3;
				}
			}
        }
    });

    // Función para convertir una fecha en formato YYYY-mm-dd a dd-mm-YYYY y viceversa.
    function formato_fecha(fecha, formato){
        var nueva_fecha;
        var res;
        if (formato == 1) {
            res = fecha.split("-");
            nueva_fecha = res[2] + '/' + res[1] + '/' + res[0];
        }
        else{
            res = fecha.split("/");
            nueva_fecha = res[2] + '-' + res[1] + '-' + res[0];
        }
        return nueva_fecha;
    } 

    function habilitarSolicitarAutorizacion()
    {
        $('#total_dias').html("Días seleccionados: " + $('#fechas_seleccionadas li').length);// + " de " + total_saldo);        
        // Si ya hay días marcados, habilitar el botón para solicitar autorización
        if ($('#fechas_seleccionadas li').length) {
            $('#solicitar_autorizacion_dias_marcados').removeAttr('disabled');
            $('#solicitar_autorizacion_permisos').removeAttr('disabled');
        }
        else{
            $('#solicitar_autorizacion_dias_marcados').attr('disabled', 'disabled');
            $('#solicitar_autorizacion_permisos').attr('disabled', 'disabled');
        }        
    }

    // Recorrer los días inhabiles
    function llenarDiasInhabiles()
    {
        var anio = $('#calendar').fullCalendar('getView').title.split(' ')[1];
        $.ajax({
            type: "POST",
            data: {
                anio: anio,    
                param: 6
            },
            url: "view/utilities.php",
            success: function(data) {
                $.each(JSON.parse(data), function( index, element ){
                    $('td.fc-day[data-date=' + element.dia_festivo + ']').attr('dia-inhabil', '1').css('background-color', 'lightgray');                    
                });
            }
        });
        $('td.fc-day[data-date=' + ((anio*1) + 1) + '-01-01]').attr('dia-inhabil', '1').css('background-color', 'lightgray');
    }  
	 
    function pintarSeleccionados()
    {
        $('#fechas_seleccionadas > div > li').each(function(index){
            $('td.fc-day[data-date=' + formato_fecha($(this).text(), 2) + ']').attr('dia-seleccionado', '1').css('background-color', '#CEECF5');
        });   
    }

    $( document ).ready(function() {
        // Clic en el botón de cerrar sesión para terminar las sesiones
        $('#logout-btn').click(function(){
        	$.ajax({
    			type: "POST",
    			data: {
    			  param: 2
    			},
    			url: "view/utilities.php",
    			success: function(data) {
    			  location.reload();
    			}
    		}); 	
        });

        // Botón de login
        $(document).on('click','#login', function(e){
            var remember_credentials = $('#remember_credentials').is(':checked');
            if($('#username').val() != '' && $('#password').val() != '') 
            {                 
                $('.cargando').show(); // Muestra la imagen de cargando
                $.ajax({
                    type: "POST",
                    async: false,
                    data: {
                      param: 5,
                      username: $('#username').val(),
                      password: $('#password').val(),
                      tipo: $('#tipo_usuario').val()
                    },
                    url: "view/utilities.php",
                    dataType: "html",
                    success: function(data) {
                        $('.cargando').hide(); // Oculta la imagen de cargando 
                        switch (data) {
                            case '1':
                                $('#exampleModal').modal('toggle');
                                break;
                            case '2':
                                location.reload();
                                break;
                            case '3':
                                alert('Los datos proporcionados son incorrectos.');
                                break;
                        }                    
                    }
                });
            }
        });   

        // Clic en el botón de cancelar del login
        $('#reset-btn').click(function(){
        	$('pre').remove();
        });

        // Limpiar los días seleccionados al presionar el botón de cancelar
        $('#cancelar_dias_marcados').click(function(){
            $('td.fc-day[dia-seleccionado=1]').attr('dia-seleccionado', '0').css('background-color', 'white');
            $('#fechas_seleccionadas li').remove();
            $('#total_dias').html("Días seleccionados: " + $('#fechas_seleccionadas li').length);
            $('#calendar').fullCalendar('today');
        });

        // Clic en el botón de regresar
        $(document).on('click','#back-btn',function(){    	
    		location.reload();							// Checar bien lo que hace en esta parte
        });

        // Siempre te mantiene en la página
        var count = 0; // needed for safari
        window.onload = function () { 
            if (typeof history.pushState === "function") { 
                history.pushState("back", null, null);          
                window.onpopstate = function () { 
                    history.pushState('back', null, null);              
                    window.location = '../vacaciones';
                }; 
            }
        }    
        
        $(document).on('click', '#solicitar_autorizacion_permisos', function(){
            $.ajax({
                type: "POST",
                data: {
                    param: 24
                },
                url: "view/utilities.php",
                dataType: 'html',
                success: function(data) {
                    if (data.length) {
                        alert(data);
                    }
                }
            });        
        });    

        if ($('#calendar').length) {
            pintarSeleccionados();                    
            llenarDiasInhabiles();
            llenarDiasMarcados();
        }   
		if ($('#calendar2').length) {
            pintarSeleccionados1();                    
            llenarDiasInhabiles1();
            llenarDiasMarcados1();
        } 
		//
		// Botón de Cambio de contraseña
		//leonardo Peña
		//12/03/2019
		//
        $(document).on('click','#CambiarContrasena', function(e){
            $('#ModalContrasena').modal('show');
			$("#NoEmpleado").val("");
			$("#contrasenaAnterior").val(""); 
			$("#nuevaContrasena").val("");
			$("#confirmarContrasena").val("");
			
        }); 
		 $(document).on('click','#cambiar_contrasena_btn', function(e){
           var NoEmpleado= $("#NoEmpleado").val();
		   var contrasenaAnterior = $("#contrasenaAnterior").val(); 
		   var nuevaContrasena= $("nuevaContrasena").val();
		   var confirmarContrasena = $("confirmarContrasena").val();
        }); 
		
		$('#nuevaContrasena').keyup(function(){
        var password = $(this).val();
        var confirm_password = $('#confirmarContrasena').val();

        $('#mensaje1').html('');
        if (password.length && confirm_password.length)
        {
            if ( password == confirm_password && password != '') {
                $('#cambiar_contrasena_btn').removeAttr('disabled');
            }
            else{
                $('#mensaje1').html('No coincide la contraseña');
                $('#cambiar_contrasena_btn').attr('disabled', 'disabled');
            }
        }
    });

    $('#confirmarContrasena').keyup(function(){
        var confirm_password = $(this).val();
        var password = $('#nuevaContrasena').val();

        $('#mensaje1').html('');
        if (confirm_password.length)
        {
            if ( password == confirm_password && confirm_password != '') {
                $('#cambiar_contrasena_btn').removeAttr('disabled');
            }
            else{
                $('#mensaje1').html('No coincide la contraseña');
                $('#cambiar_contrasena_btn').attr('disabled', 'disabled');
            }
        }
    }); 
	
	 $('#cambiar_contrasena_btn').click(function(){
        if($('#NoEmpleado').val() != '' && $('#nuevaContrasena').val() != '') 
        {             
            $('.cargando').show(); // Muestra la imagen de cargando
            // 
			$.ajax({
                    type: "POST",
                    async: false,
                    data: {
                      param: 5,
                      username: $('#NoEmpleado').val(),
                      password: $('#contrasenaAnterior').val(),
                      //tipo: $('#tipo_usuario').val()
                    },
                    url: "view/utilities.php",
                    dataType: "html",
                    success: function(data) {
                        $('.cargando').hide(); // Oculta la imagen de cargando 
                        switch (data) {
                            case '1':
                                $('#exampleModal').modal('toggle');
                                break;
                            case '2':
                               $.ajax({
									type: "POST",
									async: false,
									data: {
									  param: 16,
									  username: $('#NoEmpleado').val(),
									  password: $('#nuevaContrasena').val()
									},
									url: "view/utilities.php",
									dataType: "html",
									success: function(data) {
										$('.cargando').hide(); // Oculta la imagen de cargando 
										if(data)
										{
											alert(data);
										}
										alert('La Contraseña ha sido actualizada.');
										$('#ModalContrasena').modal('hide');
									}
								});
                                break;
                            case '3':
                                alert('Los datos proporcionados son incorrectos.');
                                break;
                        }                    
                    }
                });
			//
			
        }
    });
		//
		//
    });   
</script>