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
		$('#dias_disfrutar').css('border', '1px solid #193b83');
        $(".navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:focus, .navbar-inverse .navbar-nav>.active>a:hover").css({
            "background-color":"#022757", 
            "color":"#fff"
        });
        $('#navbar_unidad_negocio').css('background', '#193b83');
        //$("#solicitar_autorizacion_permisos").addClass("btn_fratech");
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
		//solicitar_autorizacion_permisos
		$("#solicitar_autorizacion_permisos").addClass("btn_fratechAutorizar");
		$("#solicitar_autorizacion_permisos").removeClass("btn-default");
		$("#solicitar_autorizacion_permisos").removeClass("btn");
        $("#solicitar_autorizacion_permisos").hover(function(){
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
		
    }
}

// Agregar el evento de dar click sobre los días del calendario
$('#calendar').fullCalendar({
    aspectRatio: 1,
    contentHeight: 240,
    dayClick: function(date, jsEvent, view) {           
        //var fechaActual = new Date();
		//lpena se agrega la variable de ayer, para que permita agregar desde el dia de hoy
		var TipoEmpleado = $("#TipoUsuario").text();
		if(TipoEmpleado=="1"){
			var ayer=new Date(new Date().getTime() - 2592000000);
		}else if(TipoEmpleado=="0"){
			var ayer=new Date(new Date().getTime() - 48*60*60*1000);
		}		
        if (date >= ayer) 
        {
            if ($(this).attr('dia-inhabil') !== '1' && $(this).attr('dia-autorizado') !== '1' && $(this).attr('dia-pendiente') !== '1') {                    
                if ($(this).attr('dia-seleccionado') == '1') {
                    $(this).attr('dia-seleccionado', '0');
                    $(this).css('background-color', 'white');
                    $('#fechas_seleccionadas li:contains('+formato_fecha($(this).attr('data-date'), 1)+')').parent().remove();
                }
                else
                {
                    $(this).attr('dia-seleccionado', '1');
                    $(this).css('background-color', '#2fa9ce');  
                    $('#fechas_seleccionadas').append('<div><span class="btn-eliminar"> X </span><li class="guardados">' + formato_fecha($(this).attr('data-date'), 1) + '</li></div>');
                }                  
            }
        }
        habilitarSolicitarAutorizacion();
    },
    locale: 'es'
});

function llenarDiasMarcados(){      
    //$('#fechas_seleccionadas').children().remove();
    $('#fechas_pendientes').children().remove();
    $('#fechas_autorizadas').children().remove();
    //$('li.guardados').remove();
    $.ajax({
        type: "POST",
        data: {param: 26},
        url: "view/utilities.php",
        success: function(data) {
            let datos = JSON.parse(data);
            console.log(datos.status);
            if (datos.status == "success") {
                $.each(datos.data, function( index, element ){
                    switch(element.estado)
                    {
                        case 2:
                            //$('td.fc-day[data-date=' + element.fecha_permiso + ']').attr('dia-autorizado', '1').css('background-color', '#BCF5A9');
                            $('#fechas_autorizadas').append('<li>' + formato_fecha(element.fecha_permiso, 1) + '</li>');
                            $('#total_dias_autorizados').html("Autorizados: " + $('#fechas_autorizadas li').length);                            
                            break;
                        case 1:
                            // lpena 10/12/2018 
                            // se comenta linea anterior para poder realizar varios permisos en el mismo dia
                            //$('td.fc-day[data-date=' + element.fecha_permiso + ']').attr('dia-pendiente', '1').css('background-color', '#f9e49c');
                            $('#fechas_pendientes').append('<li>' + formato_fecha(element.fecha_permiso, 1) + '</li>');
                            $('#total_dias_pendientes').html("En autorización: " + $('#fechas_pendientes li').length);
                            break;
                        default:                
                            /*$('td.fc-day[data-date=' + element.fecha_permiso + ']').attr('dia-seleccionado', '1').css('background-color', '#2fa9ce');
                            $('#fechas_seleccionadas').append('<div><span class="btn-eliminar"> X </span><li class="guardados">' + formato_fecha(element.fecha_permiso, 1) + '</li></div>');
                            $('#total_dias').html("Días seleccionados: " + $('#fechas_seleccionadas li').length);*/                            
                            break;
                    }                    
                });
            }else if(datos.status == "error"){
                alert(datos.message);
            }
        }
    });              
}

$('input[type=time]').change(function(){
    var HoraInicio  = $('input[name=hora_inicio]').val();
    var HoraFin     = $('input[name=hora_fin]').val();    
    var diferencia = ( new Date("1970-1-1 " + HoraFin) - new Date("1970-1-1 " +  HoraInicio) ) / 1000 / 60 / 60;

    diferencia = diferencia.toFixed(2);

    //$('#tiempo-permiso').html(diferencia);
});

$('#solicitar_autorizacion_permisos').click(function(){
    var motivo      = $('#motivo_permiso').val();
    //var HoraInicio  = $('input[name=hora_inicio]').val();
    //var HoraFin     = $('input[name=hora_fin]').val();
	var HoraInicio  = document.getElementById("hora_inicio").value;
    var HoraFin     = document.getElementById("hora_fin").value;
	var TipoMotivo = document.getElementById("tipo_permiso").value;
    if (motivo == '') {
        alert('Debe especificar el motivo del permiso');
        $('#motivo_permiso').focus();
        return false;
    }

    var diferencia = ( new Date("1970-1-1 " + HoraFin) - new Date("1970-1-1 " +  HoraInicio) ) / 1000 / 60 / 60;
    if (diferencia < 1) {
        diferencia = diferencia * 60;
    }

    if (diferencia < 0) {        
        alert('La hora de inicio debe ser menor a la hora final.');
        return false;
    }
	if (TipoMotivo == 0) {        
        alert('Favor de ingresar un tipo de permiso.');
        return false;
    }
    var resultado   = confirm('¿Solicitar permiso para las fechas marcadas?');

    if (resultado) {
        var fechas = [];

        $('#fechas_seleccionadas > div > li').each( function( index, element ) {
            fechas.push(element.innerText);
        });
        $.ajax({
            type: "POST",
            data: {
                param: 25,
                fechas: fechas,
                motivo: motivo,
                HoraInicio: HoraInicio,
                HoraFin: HoraFin,
				TipoMotivo:TipoMotivo
            },
            url: "view/utilities.php",
            dataType: 'html',
            success: function(data) {
                if (data.length) {
                    if(data =='[{"Resultado":-1}]'){
                        alert("El usuario ya tiene un permiso agendado en este horario.");
                    }else{
                        $.ajax({
                            type: "POST",
                            data: {
                                param: 29
                            },
                            url: "view/utilities.php",
                            dataType: 'html',
                            success: function(data) {
                                datos = JSON.parse(data);
                                if (datos.status == 'success') {
                                    alert(datos.message);
                                    llenarDiasMarcados();
                                    location.reload();
                                    document.location.reload();
                                    habilitarSolicitarAutorizacion();
                                }else{
                                    alert(datos.message);
                                }
                            }
                        });
                    }
                }
            }
        });
    }
});

// Guardar las fechas que estan marcadas para autorizar
$('.autorizar_permisos').click(function(){
    var empleado = $(this).parents('table').attr('id');
    var auxiliar = $(this).closest('table').find('td#motivo_permiso_detalle');
    var autorizar = $(this).closest('table').find('td#motivo_permiso_detalle').next();
    var fechas = [],
    fechas_iniciales = [];

    auxiliar.each(function(){
        if ($(this).next().children().is(':checked') == true){
            fechas_iniciales += $(this).html().substring($(this).html().indexOf("FECHA(s):") + 10, $(this).html().length - 10).replace(' ','');
        }
    });

    fechas = fechas_iniciales.replace(/\s+/g, '');

    if (fechas.length == 0) {
        alert('No tiene permisos marcados para autorizar.');
        return false;
    }

    var resultado = confirm('¿Autorizar permisos?');

    if (resultado) {        
        $.ajax({
            type: "POST",
            data: {
                empleado: empleado,
                fechas: fechas.slice(0,-1).split(','),
                param: 28
            },
            url: "view/utilities.php",
            dataType: 'html',
            success: function(data) {
                datos = JSON.parse(data);
                console.log(data);
                if (datos.status == 'success') {
                    alert(datos.message);
                    document.location.reload();  
                }else{
                    alert("No se pudo autorizar");
                }
            }
        });
    }
});

$('.btn-rechazar').click(function(){
    var empleado = $(this).parents('table').attr('id');
    var cadena = $(this).closest('tr').find('td:eq(1)').html();
    var fechas = cadena.substring(cadena.indexOf("FECHA(s):") + 10, cadena.length - 11).split(', ');
	/**/
	var HoraInicio = cadena.substring(cadena.indexOf("HORARIO:") + 9, cadena.length - 43).split('- ');
	var HoraFin = cadena.substring(cadena.indexOf("HORARIO:") + 17, cadena.length - 35).split('- ');
	/**/
    console.log(fechas);
    console.log(empleado);

    var resultado = confirm('¿Rechazar permiso?');

    if (resultado) 
    {
        $.ajax({
            type: "POST",
            data: {
                empleado: empleado,
                fechas: fechas,
				HoraInicio: HoraInicio,
				HoraFin: HoraFin,
                param: 27
            },
            url: "view/utilities.php",
            dataType: 'html',
            success: function(data) {
                if (data.length) {
                    alert(data);
                }
            }
        });
        $(this).closest('tr').remove();
    }
});

$(document).on('click', 'span.btn-eliminar', function(){
    $('td.fc-day[data-date=' + formato_fecha($(this).next().html(), 2) + ']').attr('dia-seleccionado', '0').css('background-color', 'white');
    $(this).parent().remove();                  
    habilitarSolicitarAutorizacion();   
});

$(document).on('click', 'li', function(){
    $('#calendar').fullCalendar('gotoDate', formato_fecha($(this).html(), 2));
    pintarSeleccionados();                    
    llenarDiasInhabiles();
    llenarDiasMarcados();
	// Pintar_permiso();
});

$('#buscar_permisos_empleado').click(function(){
    var Empleado = document.getElementById("select_empleado").value;
	$('#TablaPermisos').find("tr").remove();	
        $.ajax({
            type: "POST",
            data: {
                Empleado: Empleado,
                param: 31
            },
            url: "view/utilities.php",
            dataType: 'JSON',
            success: function(data) {
               
				if (data.length) {
                    //alert(data);
					for(i=0;i<data.length;i++){
						 var tabla = "<tr id='Permiso"+i+"'><td>"+data[i]['Empleado'] +"</td>";
						tabla += "<td style='width:300px;'>"+data[i]['NombreCompleto']+" </td>";
						tabla += "<td style='width:50px;'>"+data[i]['FechaPermiso']+" </td>";
						tabla += "<td style='width:150px;'>"+data[i]['Departamento']+" </td>";
						tabla += "<td style='width:280px;'>"+data[i]['TipoPermiso']+" </td>";
						tabla += "<td style='width:50px;'>"+data[i]['HoraInicio']+" </td>";
						tabla += "<td style='width:50px;'>"+data[i]['HoraFin']+" </td>";
						tabla += "<td><button class='btn-eliminarPermiso' data-toggle='tooltip' data-placement='top' title='Eliminar Permiso' onclick='BorrarPermiso(\""+data[i]['Empleado']+"\",\""+data[i]['FechaPermiso']+"\",\""+data[i]['HoraInicio']+"\",\""+data[i]['HoraFin']+"\",\""+i+"\")' id='Borrar"+i+"'>X</button></td></tr>";
						$('#TablaPermisos').append(tabla);
					}
                }
            }
        });
});

function BorrarPermiso(empleado,fechas,HoraInicio,HoraFin,i){
	var empleado = empleado;
	var fechas = [fechas];
	var HoraInicio = HoraInicio;
	var HoraFin = HoraFin;
	var i= i;
	var resultado = confirm('Eliminar permiso?');

    if (resultado) 
    {
        $.ajax({
            type: "POST",
            data: {
               empleado: empleado,
                fechas: fechas,
				HoraInicio: HoraInicio,
				HoraFin: HoraFin,
                param: 27
            },
            url: "view/utilities.php",
            dataType: 'JSON',
            success: function(data) {
               
				 if (data.length) {
                    alert(data);
                }
            }
        });
       $('#Permiso'+i).remove();
	}
}
