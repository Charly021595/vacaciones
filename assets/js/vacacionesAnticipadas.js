jQuery(function () {
    traer_datos_usuario();
});

function traer_datos_usuario(){
    $("#logo_arzyz").show();
    $("#logo_fratech").hide();
    let unidad_negocio = $("#unidad_negocio").val();
    if (unidad_negocio == 'FRATECH') {
        $("#logo_arzyz").hide();
        $("#logo_fratech").show();
        $('#navbar_unidad_negocio').css('background', '#193b83');
		$('#dias_disfrutar').css('border', '1px solid #193b83');
		$("#solicitar_autorizacion_dias_marcados1").addClass("btn_fratechAutorizar");
		$("#solicitar_autorizacion_dias_marcados1").removeClass("btn-default");
		$("#solicitar_autorizacion_dias_marcados1").removeClass("btn");
        $("a").hover(function(){
            $(this).css({
                "background-color":"#176bd4", 
                "color":"#fff"
            });
            }, function(){
            $(this).css({
                "background-color":"#193b83", 
                "color":"#fff"
            });
        });
        $(".navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:focus, .navbar-inverse .navbar-nav>.active>a:hover").css({
            "background-color":"#022757", 
            "color":"#fff"
        });
		$("#buscar_permisos_empleado").addClass("btn_fratech");
		$("#buscar_permisos_empleado").hover(function(){
            $(this).css({
                "background-color":"#176bd4", 
                "color":"#fff"
            });
            }, function(){
            $(this).css({
                "background-color":"#193b83", 
                "color":"#fff"
            });
        });
		$("#solicitar_autorizacion_dias_marcados1").addClass("btn_fratech");
    }
}

// Agregar el evento de dar click sobre los días del calendario
	 $('#calendar2').fullCalendar({
				locale: 'es',
				aspectRatio: 1,
				contentHeight: 240,
				dayClick: function(date, jsEvent, view) {           
					//var fechaActual = new Date();
					var fechaActual=new Date(new Date().getTime() - 24*60*60*1000);
					if (date >= fechaActual) 
					{
						//
						var empleadoASolicitar = $("#select_empleado option:selected").val();
						if(empleadoASolicitar !=0){
							//
							if ($(this).attr('dia-inhabil1') !== '1' && $(this).attr('dia-autorizado1') !== '1' && $(this).attr('dia-pendiente1') !== '1') {                    
								if ($(this).attr('dia-seleccionado1') == '1') {
									$(this).attr('dia-seleccionado1', '0');
									$(this).css('background-color', 'white');
									if ($('#fechas_seleccionadas1 li.guardados1:contains('+formato_fecha($(this).attr('data-date'), 1)+')').length) {
										eliminarFechaOtroEmpleado($(this).attr('data-date'));
									}
									$('#fechas_seleccionadas1 li:contains('+formato_fecha($(this).attr('data-date'), 1)+')').parent().remove();
								}
								else
								{
									if ( maximo_numero_dias2 > ($('#fechas_seleccionadas1 li.guardados1').length + $('#fechas_pendientes1 li').length))
									{
										$(this).attr('dia-seleccionado1', '1');
										$(this).css('background-color', '#2fa9ce');
										insertarFechaOtroEmpleado($(this).attr('data-date'));
										$('#fechas_seleccionadas1').append('<div><span class="btn-eliminar1"> X </span><li class="guardados1">' + formato_fecha($(this).attr('data-date'), 1) + '</li></div>');
									}
									else{
										alert('Número máximo de días permitidos.');
									}
								}
							}
							//
						}
					}
					habilitarSolicitarAutorizacion1();
				}
			});
	//
   function buscarinformacion(){
	   var empleadoASolicitar = $("#select_empleado option:selected").val()
		//
		if(empleadoASolicitar !=0){
			ObtenerInformacionEmpleado();
			//SaldoMaximoDias();
			llenarDiasMarcados1();
	   }else{
		   alert("Seleccionar Empleado");
	   }
   }
    // Al dar click en un botón (solo cuando se cambie de mes) pintar aquellas fechas que ya estén seleccionadas, días inhábiles, días autorizados y pendientes de autorizar.
    $("button").click(function(event){
        if ($('#calendar2').length) {
            pintarSeleccionados1();                    
            llenarDiasInhabiles1();
            llenarDiasMarcados1();
        }
    });

    // Guardar las fechas
    $('#guardar_dias_marcados').click(function(){    
        var resultado = confirm('¿Guardar las fechas marcadas?');

        if (resultado){
            var fechas = [];

            $('#fechas_seleccionadas1 > li').each( function( index, element ) {
                fechas.push(element.innerText);
            });

            $.ajax({
                type: "POST",
                data: {
                    fechas: fechas,
                    param: 7
                },
                url: "view/utilities.php",
                dataType: 'html',
                success: function(data) {
                    if (data.length) {
                        alert(data);
                    }
                }
            });
        }
    });

    function llenarDiasMarcados1(){
        var empleadoASolicitar = $("#select_empleado option:selected").val()
		//
		if(empleadoASolicitar !=0){
			$('#fechas_seleccionadas1').children().remove();
			$('#fechas_pendientes1').children().remove();
			$('#fechas_autorizadas1').children().remove();
			$('li.guardados1').remove();
			$.ajax({
				type: "POST",
				data: {
					param: 35,
					empleadoASolicitar:empleadoASolicitar
				},
				url: "view/utilities.php",
				async: false,
				success: function(data) {
					$.each(JSON.parse(data), function( index, element ){
						switch(element.estado)
						{
							case 2:
								$('td.fc-day[data-date=' + element.fecha_vacaciones + ']').attr('dia-autorizado1', '1').css('background-color', '#BCF5A9');
								$('#fechas_autorizadas1').append('<li>' + formato_fecha(element.fecha_vacaciones, 1) + '</li>');
								$('#total_dias_autorizados1').html("Autorizados: " + $('#fechas_autorizadas1 li').length);                            
								break;
							case 1:
								$('td.fc-day[data-date=' + element.fecha_vacaciones + ']').attr('dia-pendiente1', '1').css('background-color', '#f9e49c');
								$('#fechas_pendientes1').append('<li>' + formato_fecha(element.fecha_vacaciones, 1) + '</li>');
								$('#total_dias_pendientes1').html("En autorización: " + $('#fechas_pendientes1 li').length);
								break;
							default:                
								$('td.fc-day[data-date=' + element.fecha_vacaciones + ']').attr('dia-seleccionado1', '1').css('background-color', '#2fa9ce');
								$('#fechas_seleccionadas1').append('<div><span class="btn-eliminar1"> X </span><li class="guardados1">' + formato_fecha(element.fecha_vacaciones, 1) + '</li></div>');
								$('#total_dias1').html("Días seleccionados: " + $('#fechas_seleccionadas1 li').length);                            
								break;
						}                    
					});
				}
			}); 
		}
		if ($('#fechas_seleccionadas1 li').length) {
            $('#solicitar_autorizacion_dias_marcados1').removeAttr('disabled');
        }
        else{
            $('#solicitar_autorizacion_dias_marcados1').attr('disabled', 'disabled');
        }
		
    }
    if ($('#calendar2').length) {
            pintarSeleccionados1();                    
            llenarDiasInhabiles1();
            llenarDiasMarcados1();
    }

    $('#solicitar_autorizacion_dias_marcados').click(function(){
        var resultado = confirm('¿Solicitar autorización para las fechas marcadas?');

        if (resultado) {
            $.ajax({
                type: "POST",
                data: {
                    param: 11
                },
                url: "view/utilities.php",
                dataType: 'html',
                success: function(data) {
                    if (data.length) {
                        alert(data);
                    }
                    else{
                        llenarDiasMarcados1();
                        location.reload();                        
                    }
                }
            });
        }
    }); 

    

    /*----------- Pantalla de actualización de empleados -----------*/
	$('#tabla-administracion-empleados > th').click(function(){
        var col = $(this).parent().children().index($(this));
        $('.cargando').show(); // Muestra la imagen de cargando
        sortTable(col);
        $('.cargando').hide(); // Oculta la imagen de cargando            
    });

    function sortTable(col) {
      var table, rows, switching, i, x, y, shouldSwitch;
      table = document.getElementById("tabla-administracion-empleados");
      switching = true;
      /*Make a loop that will continue until
      no switching has been done:*/
      while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.getElementsByTagName("TR");
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
          //start by saying there should be no switching:
          shouldSwitch = false;
          /*Get the two elements you want to compare,
          one from current row and one from the next:*/
          x = rows[i].getElementsByTagName("TD")[col];
          y = rows[i + 1].getElementsByTagName("TD")[col];
          //check if the two rows should switch place:
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        }
        if (shouldSwitch) {
          /*If a switch has been marked, make the switch
          and mark that a switch has been done:*/
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
        }
      }
    }

    // Al presionar la tecla de enter en la pantalla de actualizar saldos, checar que los valores esten completos
    $(document).on('click', '#eliminar-saldo-btn', function(){
        var anio = $(this).closest('tr').find('td:eq(1)').html();
        var usuario = $('input[name="empleado"]').val();
        var respuesta = confirm('¿Eliminar el saldo del año ' + anio + '?');
        if (respuesta){         
            $.ajax({
                type: "POST",
                data: {
                    param: 24,
                    usuario: usuario,
                    anio: anio
                },
                url: "view/utilities.php",
                dataType: 'html',
                success: function(data) {
                    if (data.length) {
                        alert(data);
                    }
                    else{
                        $( ".subtitulo" ).remove();
                        $( "div.saldos" ).remove();
                        $.ajax({
                            type: "POST",
                            data: {
                                param: 23,
                                empleado: usuario
                            },
                            url: "view/utilities.php",
                            dataType: 'html',
                            success: function(data) {                
                                $('div.modal-body').append(data);
                            }
                        });
                    }
                }
            });
        }
    });

    $(document).on('click', 'span.btn-eliminar', function(){
        eliminarFecha(formato_fecha($(this).next().html(), 2));
        $('td.fc-day[data-date=' + formato_fecha($(this).next().html(), 2) + ']').attr('dia-seleccionado', '0').css('background-color', 'white');                    
        llenarDiasInhabiles1();
        llenarDiasMarcados1();
        habilitarSolicitarAutorizacion1();   
    });    

    $(document).on('click', 'li', function(){
        $('#calendar2').fullCalendar('gotoDate', formato_fecha($(this).html(), 2));
        pintarSeleccionados1();                    
        llenarDiasInhabiles1();
        llenarDiasMarcados1();
    });

 function pintarSeleccionados1()
    {
        $('#fechas_seleccionadas1 > div > li').each(function(index){
            $('td.fc-day[data-date=' + formato_fecha($(this).text(), 2) + ']').attr('dia-seleccionado1', '1').css('background-color', '#2fa9ce');
        });   
    }
    function llenarDiasInhabiles1()
    {
        var anio = $('#calendar2').fullCalendar('getView').title.split(' ')[1];
        $.ajax({
            type: "POST",
            data: {
                anio: anio,    
                param: 6
            },
            url: "view/utilities.php",
            success: function(data) {
                $.each(JSON.parse(data), function( index, element ){
                    $('td.fc-day[data-date=' + element.dia_festivo + ']').attr('dia-inhabil1', '1').css('background-color', 'lightgray');                    
                });
            }
        });
        $('td.fc-day[data-date=' + ((anio*1) + 1) + '-01-01]').attr('dia-inhabil1', '1').css('background-color', 'lightgray');
    }  
	
	function insertarFechaOtroEmpleado(fecha){
        var empleadoASolicitar = $("#select_empleado option:selected").val()
		//
		if(empleadoASolicitar !=0){
			//
			var fechas = [];
			fechas.push(fecha);
			$.ajax({
				type: "POST",
				data: {
					fechas: fechas,
					empleadoASolicitar: empleadoASolicitar,
					param: 34
				},
				url: "view/utilities.php",
				dataType: 'html',
				success: function(data) {
					if (data.length) {
						alert(data);
					}
				}
			});
			return false;;
			//
		}else{
			alert("Favor de asignar empleado ");
		}
		//
    }
	//
	 $(document).on('click', 'span.btn-eliminar1', function(){
        eliminarFechaOtroEmpleado(formato_fecha($(this).next().html(), 2));
        $('td.fc-day[data-date=' + formato_fecha($(this).next().html(), 2) + ']').attr('dia-seleccionado1', '0').css('background-color', 'white');                    
        llenarDiasInhabiles1();
        llenarDiasMarcados1();
        habilitarSolicitarAutorizacion1();   
    });    

    $(document).on('click', 'li', function(){
        $('#calendar2').fullCalendar('gotoDate', formato_fecha($(this).html(), 2));
        pintarSeleccionados1();                    
        llenarDiasInhabiles1();
        llenarDiasMarcados1();
    });
	
	function habilitarSolicitarAutorizacion1()
    {
        $('#total_dias1').html("Días seleccionados: " + $('#fechas_seleccionadas1 li').length);// + " de " + total_saldo);        
        // Si ya hay días marcados, habilitar el botón para solicitar autorización
        if ($('#fechas_seleccionadas1 li').length) {
            $('#solicitar_autorizacion_dias_marcados1').removeAttr('disabled');
            $('#solicitar_autorizacion_permisos1').removeAttr('disabled');
        }
        else{
            $('#solicitar_autorizacion_dias_marcados1').attr('disabled', 'disabled');
            $('#solicitar_autorizacion_permisos1').attr('disabled', 'disabled');
        }        
    }
	
	function eliminarFechaOtroEmpleado(fecha){
		var empleadoASolicitar = $("#select_empleado option:selected").val();
		if(empleadoASolicitar !=0){
			$.ajax({
				type: "POST",
				data: {
					fechas: fecha,
					empleadoASolicitar: empleadoASolicitar,
					param: 36
				},
				url: "view/utilities.php",
				dataType: 'html',
				success: function(data) {
					if (data.length) {
						alert(data);
					}
				}
			});
		}else{
			alert("Favor de Agregar Empleado")
		}
    }
	//
	function ObtenerInformacionEmpleado(){
    var Empleado = document.getElementById("select_empleado").value
	var totalDias = 0;
	var FechaIngreso =""
	var saldo =0;
	//
	var saldo2=0;
	//
	var ValidarDiasAnticipados =0;
	$('#MostrarInfromacion').find("tr").remove();	
	var saldoTotal = 0;
        $.ajax({
            type: "POST",
            data: {
                Empleado: Empleado,
                param: 37
            },
            url: "view/utilities.php",
            dataType: 'JSON',
            success: function(data) {
               
				if (data.length) {
                    //alert(data);
					//
					for(i=0;i<data.length;i++){
						if(parseInt(data[i]['saldo']) >0){
						saldo2 = saldo2 + parseInt(data[i]['saldo']);
						}
						if(parseInt(data[i]['saldo']) <= -3){
							ValidarDiasAnticipados=1;
						}
						
						saldo = saldo + parseInt(data[i]['saldo']);
						
					}
					
					//
					var tabla = "<tr><th>Año </th><th>Saldo </th><th> Fecha vencimiento </th><th>Fecha de Ingreso </th><th>Total </th></tr>"
					for(i=0;i<data.length;i++){
						
						tabla += "<tr id='Permiso"+i+"'><td>"+data[i]['anio'] +"</td>";
						if(parseInt(data[i]['saldo']) <= 0){
							tabla += "<td  >0 </td>";
						}
						else{
							tabla += "<td >"+data[i]['saldo']+" </td>";
						}
						tabla += "<td >"+data[i]['fecha']+" </td>";
						if(FechaIngreso !=data[i]['FechaIngreso'] ){
							tabla += "<td id='tdFechaIngreso'>"+data[i]['FechaIngreso']+" </td>";
							FechaIngreso = data[i]['FechaIngreso'];
						}
						if(i==0){
							if(saldo > 0){
								tabla += "<td id='saldos_dias1'>"+saldo2+"</td>";
								tabla += "<td  id='saldo_dias' style='display:none'>"+saldo+"</td>";
							}else{
								//tabla += "<td id='saldos_dias1'>"+saldo2+"</td>";
								tabla += "<td  id='saldo_dias'>"+saldo2+"</td>";
							}
						}
						tabla += "<td id='ValidarDias' style='display:none' ></td>";
					}
					$('#MostrarInfromacion').append(tabla);
					document.getElementById("tdFechaIngreso").rowSpan = i;
					document.getElementById("saldo_dias").rowSpan = i;
				if(saldo > 0){
					$("#saldo_dias").text(saldo);
				}else{
					$("#saldo_dias").text(saldo2);
				}
				$("#ValidarDias").text(ValidarDiasAnticipados);
				SaldoMaximoDias();
				//var ParamValidarDias= $("#ValidarDias").text(); 
                }else{
					var tabla ="<tr><td><label class='pp-left-5'>No hay días disponibles.</label></td></tr>"
					$('#MostrarInfromacion').append(tabla);
					
				}
            }
        });
	}
	
	function SaldoMaximoDias(){
		//
		//var fechaActual = new Date(); //Fecha actual
		//var fechaActual=new Date(new Date().getTime() - 2592000000);
		var fechaActual=new Date(new Date().getTime() - 48*60*60*1000);
		var fechaActual2 = moment(fechaActual).format("DD-MM-YYYY");
		var anio = fechaActual.getFullYear(); //obteniendo año
		//
		
		FechadeIngreso = $("#tdFechaIngreso").text();
		var fecha =FechadeIngreso.split("/")
		MesIngreso2 = parseInt(fecha[1]);
		DiaIngreso2 = parseInt(fecha[0]);
		if(DiaIngreso2<10)
		DiaIngreso2='0'+DiaIngreso2; //agrega cero si el menor de 10
		if(MesIngreso2<10)
		MesIngreso2='0'+MesIngreso2 //agrega cero si el menor de 10
		////
		if(MesIngreso2>6){
			var parametro = 1;
		}else{
			var parametro = 0;
            anio = anio-1;
		}
		////
		var FechaIngresoAnio= moment(anio+"-"+MesIngreso2+"-"+DiaIngreso2);
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
		fecha1 = FActual[1] + '-/' + FActual[0] + '/' + FActual[2];
		//fecha2 = FIngreso[1] + '-' + FIngreso[0] + '-' + FIngreso[2];

		
		
		if( $("#saldo_dias").length !=0){
			maximo_numero_dias2 =  Math.round($('td#saldo_dias').html());
			maximo_numero_dias2 = maximo_numero_dias2 + $('#fechas_pendientes1 li').length;
			//
			var ParamValidarDias= $("#ValidarDias").text(); 
			if(ParamValidarDias !=1)
			{
				if(maximo_numero_dias2 == -1){
					maximo_numero_dias2 =2;
				}
				else if(maximo_numero_dias2 == -2){
					maximo_numero_dias2 = 1
				}
				else if(Date.parse(fecha1) >= Date.parse(fecha2)){
					
					maximo_numero_dias2 = maximo_numero_dias2+3;
				}
			//
			}
        }
        else{
            maximo_numero_dias2 = 0;
			var ParamValidarDias= $("#ValidarDias").text(); 
			if(ParamValidarDias !=1)
			{
				if(maximo_numero_dias2 == -1){
					maximo_numero_dias2 =2;
				}
				else if(maximo_numero_dias2 == -2){
					maximo_numero_dias2 = 1
				}
				else if(Date.parse(fecha1) >= Date.parse(fecha2)){
					maximo_numero_dias2 = maximo_numero_dias2+3;
				}
			}
        }
		habilitarSolicitarAutorizacion1();
		//
		if ($('#fechas_seleccionadas1 li').length) {
            $('#solicitar_autorizacion_dias_marcados1').removeAttr('disabled');
        }
        else{
            $('#solicitar_autorizacion_dias_marcados1').attr('disabled', 'disabled');
        }
		//
	}
	
	function LimpiarCalendario(){
		 $(".fc-today").attr('style', 'white');
		 $(".fc-future").attr('style', 'white');
		 $(".fc-day").attr('style', 'white');
		 $('#MostrarInfromacion').find("tr").remove();
		 if ($('#fechas_seleccionadas1 li').length) {
            $('#solicitar_autorizacion_dias_marcados1').removeAttr('disabled');
        }
        else{
            $('#solicitar_autorizacion_dias_marcados1').attr('disabled', 'disabled');
        }
	}
	//
	$('#solicitar_autorizacion_dias_marcados1').click(function(){
        var resultado = confirm('¿Solicitar autorización para las fechas marcadas?');
		 var Empleado = document.getElementById("select_empleado").value
        if (resultado) {
            $.ajax({
                type: "POST",
                data: {
                    param: 38,
					empleadoASolicitar: Empleado
                },
                url: "view/utilities.php",
                dataType: 'html',
                success: function(data) {
                    if (data.length) {
                        alert(data);
                    }
                    else{
                        llenarDiasMarcados1();
                        //location.reload();                        
                    }
                }
            });
        }
    }); 
	
	//