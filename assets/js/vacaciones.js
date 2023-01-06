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
        $("#titulo_tabla_empleados").addClass("tabla_fratech");
		
		 $('#dias_disfrutar').css('border', '1px solid #193b83');
		
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
        //$("#solicitar_autorizacion_dias_marcados").addClass("btn_fratech");
	
		$("#solicitar_autorizacion_dias_marcados").addClass("btn_fratechAutorizar");
		$("#solicitar_autorizacion_dias_marcados").removeClass("btn-default");
		$("#solicitar_autorizacion_dias_marcados").removeClass("btn");
        $("#solicitar_autorizacion_dias_marcados").hover(function(){
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
    locale: 'es',
    aspectRatio: 1,
    contentHeight: 240,
    dayClick: function(date, jsEvent, view) {           
        var fechaActual = new Date();

        if (date >= fechaActual) 
        {
            if ($(this).attr('dia-inhabil') !== '1' && $(this).attr('dia-autorizado') !== '1' && $(this).attr('dia-pendiente') !== '1') {                    
                if ($(this).attr('dia-seleccionado') == '1') {
                    $(this).attr('dia-seleccionado', '0');
                    $(this).css('background-color', 'white');
                    if ($('#fechas_seleccionadas li.guardados:contains('+formato_fecha($(this).attr('data-date'), 1)+')').length) {
                        eliminarFecha($(this).attr('data-date'));
                    }
                    $('#fechas_seleccionadas li:contains('+formato_fecha($(this).attr('data-date'), 1)+')').parent().remove();
                }
                else
                {
                    if ( maximo_numero_dias > ($('#fechas_seleccionadas li.guardados').length + $('#fechas_pendientes li').length))
                    {
                        $(this).attr('dia-seleccionado', '1');
                        $(this).css('background-color', '#2fa9ce');
                        insertarFecha($(this).attr('data-date'));
                        $('#fechas_seleccionadas').append('<div><span class="btn-eliminar"> X </span><li class="guardados">' + formato_fecha($(this).attr('data-date'), 1) + '</li></div>');
                    }
                    else{
                        alert('Número máximo de días.');
                    }
                }
            }
        }
        habilitarSolicitarAutorizacion();
    }
});

// Al dar click en un botón (solo cuando se cambie de mes) pintar aquellas fechas que ya estén seleccionadas, días inhábiles, días autorizados y pendientes de autorizar.
$("button").click(function(event){
    if ($('#calendar').length) {
        pintarSeleccionados();                    
        llenarDiasInhabiles();
        llenarDiasMarcados();
    }
});

// Guardar las fechas
$('#guardar_dias_marcados').click(function(){    
    var resultado = confirm('¿Guardar las fechas marcadas?');

    if (resultado){
        var fechas = [];

        $('#fechas_seleccionadas > li').each( function( index, element ) {
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

function llenarDiasMarcados(){   
    debugger;     
    $('#fechas_seleccionadas').children().remove();
    $('#fechas_pendientes').children().remove();
    $('#fechas_autorizadas').children().remove();
    $('li.guardados').remove();
    $.ajax({
        type: "POST",
        data: {
            param: 8
        },
        url: "view/utilities.php",
        async: false,
        success: function(data) {
            $.each(JSON.parse(data), function( index, element ){
                switch(element.estado)
                {
                    case 2:
                        $('td.fc-day[data-date=' + element.fecha_vacaciones + ']').attr('dia-autorizado', '1').css('background-color', '#BCF5A9');
                        $('#fechas_autorizadas').append('<li>' + formato_fecha(element.fecha_vacaciones, 1) + '</li>');
                        $('#total_dias_autorizados').html("Autorizados: " + $('#fechas_autorizadas li').length);                            
                        break;
                    case 1:
                        $('td.fc-day[data-date=' + element.fecha_vacaciones + ']').attr('dia-pendiente', '1').css('background-color', '#f9e49c');
                        $('#fechas_pendientes').append('<li>' + formato_fecha(element.fecha_vacaciones, 1) + '</li>');
                        $('#total_dias_pendientes').html("En autorización: " + $('#fechas_pendientes li').length);
                        break;
                    default:                
                        $('td.fc-day[data-date=' + element.fecha_vacaciones + ']').attr('dia-seleccionado', '1').css('background-color', '#2fa9ce');
                        $('#fechas_seleccionadas').append('<div><span class="btn-eliminar"> X </span><li class="guardados">' + formato_fecha(element.fecha_vacaciones, 1) + '</li></div>');
                        $('#total_dias').html("Días seleccionados: " + $('#fechas_seleccionadas li').length);                            
                        break;
                }                    
            });
        }
    });              
}

// Al seleccionar un usuario autorizador llenar el campo de correo
$('td > select').change(function(){
    var identificador = $(this).attr("id");
    $(this).parent().siblings('#acciones_autorizador').remove();
    $(this).parent("td:last").after('<td id="acciones_autorizador"><span class="btn-actualizar">Guardar</span></td>');
});

// Llenar el combo de autorizadores al pasar el mouse sobre el control (Vista de administradores)
$('td > select').mouseover(function(){
    var identificador = $(this).attr("id");
    $.ajax({
        type: "POST",
        data: {
            param: 18
        },
        url: "view/utilities.php",
        success: function(data) {
            if (data.length) {
                if($('#' + identificador + '').children().length == 1)
                {
                    $.each(JSON.parse(data), function( index, element ){                                                                        
                        $('#' + identificador + '').append('<option value="' + element.Autorizador + '" correo="' + element.Correo + '">' + element.Nombre_Autorizador + '</option>');
                    });     
                }               
            }
            else{
                alert("No hay empleados");
            }
        }
    });
});

// Guardar las fechas que estan marcadas para autorizar
$('.autorizar_vacaciones').click(function(){
    var fechas = [];
    var empleado = $(this).parents('table').attr('id');
    var resultado = confirm('¿Autorizar vacaciones?');

    if (resultado) {        
        $('#' + empleado + ' input[type=checkbox]:checked').each(function(){
            fechas.push(formato_fecha($(this).val(), 2));
        });
        $.ajax({
            type: "POST",
            data: {
                empleado: empleado,
                fechas: fechas,
                param: 10
            },
            url: "view/utilities.php",
            dataType: 'html',
            success: function(data) {
                if (data.length) 
                {
                    alert("No se pudo autorizar");
                }
                else{
                    location.reload();
                }
            }
        });
    }
});

if ($('#calendar').length) {
        pintarSeleccionados();                    
        llenarDiasInhabiles();
        llenarDiasMarcados();
}

$('#solicitar_autorizacion_dias_marcados').click(function(){
    debugger;
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
                    llenarDiasMarcados();
                    location.reload();                        
                }
            }
        });
    }
}); 

$('.btn-rechazar').click(function(){
    var fechas = [];
    var empleado = $(this).parents('table').attr('id');
    var fila = $(this).parent('tr');

    fechas.push(formato_fecha($(this).parent().siblings().html(), 2));

    var resultado = confirm('¿Rechazar la fecha ' + formato_fecha(fechas[0], 1) + '?');

    if (resultado) 
    {
        $.ajax({
            type: "POST",
            data: {
                empleado: empleado,
                fechas: fechas,
                param: 12
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

function eliminarFecha(fecha){
    $.ajax({
        type: "POST",
        data: {
            fechas: fecha,
            param: 13
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

function insertarFecha(fecha){
    var fechas = [];
    fechas.push(fecha);
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
    return false;
}      

$('#cambiar_password_btn').click(function(){
    if($('#nuevo_username').val() != '' && $('#nuevo_password').val() != '') 
    {             
        $('.cargando').show(); // Muestra la imagen de cargando
        $.ajax({
            type: "POST",
            async: false,
            data: {
                param: 16,
                username: $('#nuevo_username').val(),
                password: $('#nuevo_password').val()
            },
            url: "view/utilities.php",
            dataType: "html",
            success: function(data) {
                $('.cargando').hide(); // Oculta la imagen de cargando 
                if(data)
                {
                    alert(data);
                }
                location.reload();
            }
        });
    }
});

// Pasar el valor del empleado a la pantalla modal
$(document).on('show.bs.modal', '#exampleModal', function(e) {
    var empleado = $('#username').val();
    $(e.currentTarget).find('input[name="nuevo_username"]').val(empleado);
    $(this).find('[autofocus]').focus();
});

$('#nuevo_password').keyup(function(){
    var password = $(this).val();
    var confirm_password = $('#confirm_password').val();

    $('#mensaje').html('');
    if (password.length && confirm_password.length)
    {
        if ( password == confirm_password && password != '') {
            $('#cambiar_password_btn').removeAttr('disabled');
        }
        else{
            $('#mensaje').html('No coincide la contraseña');
            $('#cambiar_password_btn').attr('disabled', 'disabled');
        }
    }
});

$('#confirm_password').keyup(function(){
    var confirm_password = $(this).val();
    var password = $('#nuevo_password').val();

    $('#mensaje').html('');
    if (confirm_password.length)
    {
        if ( password == confirm_password && confirm_password != '') {
            $('#cambiar_password_btn').removeAttr('disabled');
        }
        else{
            $('#mensaje').html('No coincide la contraseña');
            $('#cambiar_password_btn').attr('disabled', 'disabled');
        }
    }
});    

// Al presionar el enter en la pantalla de actualizar contraseña, checar que los valores entre contraseña y confirmar contraseña correspondan
$(document).on("keypress", "#exampleModal", function(event) {         
    if(event.keyCode == 13){
        if($('#nuevo_username').val() != '' && $('#nuevo_password').val() != '' && $('#nuevo_password').val() == $('#confirm_password').val()) 
        {             
            $( "#cambiar_password_btn" ).trigger( "click" );
            $('#exampleModal').modal('hide');
            //location.reload();
        }
    }
    return event.keyCode != 13;
});
// Filtrar por número de empleado
$(".autocompletar.no_empleado").keyup(function(){
        var valor = $(this).val();
        $(".autocompletar.nombre_autorizador").val('');
        $(".autocompletar.nombre_empleado").val('');                                
        if(valor !== ''){
            // Sino lo contiene ocultar
            $('tr td[data-title="Empleado"]').not(':contains(' + valor.toUpperCase() + ')').each(function(){
                $(this).parents('tr').hide();
            });
            // Si lo contiene mostrar
            $('tr td[data-title="Empleado"]:contains(' + valor.toUpperCase() + ')').each(function(){
                $(this).parents('tr').show();
            });
        }else{
            $('tr td[data-title="Empleado"]').each(function(){
                $(this).parents('tr').show();
            });
        }    
});

// Filtrar por nombre
$(".autocompletar.nombre_empleado").keyup(function(){
        var valor = $(this).val();
        $(".autocompletar.nombre_autorizador").val('');
        $(".autocompletar.no_empleado").val('');                
        if(valor !== ''){
            // Sino lo contiene ocultar
            $('tr td[data-title="Nombre"]').not(':contains(' + valor.toUpperCase() + ')').each(function(){
                $(this).parents('tr').hide();
            });
            // Si lo contiene mostrar
            $('tr td[data-title="Nombre"]:contains(' + valor.toUpperCase() + ')').each(function(){
                $(this).parents('tr').show();
            });
        }else{
            $('tr td[data-title="Nombre"]').each(function(){
                $(this).parents('tr').show();
            });
        }    
});

// Filtrar por autorizador
$(".autocompletar.nombre_autorizador").keyup(function(){            
        var valor = $(this).val();
        $(".autocompletar.nombre_empleado").val('');
        $(".autocompletar.no_empleado").val('');
        if(valor !== ''){
            // Sino lo contiene ocultar
            $('tr td[data-title="Nombre_autorizador"]').not(':contains(' + valor.toUpperCase() + ')').each(function(){
                $(this).parents('tr').hide();
            });
            // Si lo contiene mostrar
            $('tr td[data-title="Nombre_autorizador"]:contains(' + valor.toUpperCase() + ')').each(function(){
                $(this).parents('tr').show();
            });
        }else{
            $('tr td[data-title="Nombre_autorizador"]').each(function(){
                $(this).parents('tr').show();
            });
        }    
});        

// Actualizar el autorizador al presionar en el botón Ok
$(document).on('click', '#acciones_autorizador > span', function(){
    var boton = $(this);
    var empleado = $(this).closest('tr').find('td:eq(2)').html();
    var autoriza = $(this).parents('tr').find('td:eq(7)').children().find('option:selected').val();

    console.log('empleado: ' + empleado + ' autoriza: ' + autoriza);

    if (!autoriza) {
        alert('Se tiene que seleccionar un autorizador');
    }
    else{
        $.ajax({
            type: "POST",
            async: false,
            data: {
                param: 17,
                username: empleado,
                autoriza: autoriza
            },
            url: "view/utilities.php",
            dataType: "html",
            success: function(data) {
                $('.cargando').hide(); // Oculta la imagen de cargando 
                if(data)
                {
                    alert(data);
                }
            }
        });
        boton.parent().remove();
    }
});

// Validar el correo
function validarEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

// Al modificar el correo mostrar el botón de guardar
$('input[type="email"]').change(function(){
    if (!$(this).parent().siblings('#acciones_autorizador').length){
        //$(this).parent().siblings('#acciones_autorizador').remove();
        $(this).parent().after('<td id="acciones_autorizador"><span class="btn-actualizar">Guardar</span></td>');
    }
});

/*----------- Pantalla de actualización de empleados -----------*/

$(document).on('keyup', '#correo', function(){
    var correo = $(this).val();
    var confirm_correo = $('#confirm_correo').val();

    $('#mensaje').html('');
    if (correo.length && confirm_correo.length)
    {
        if ( correo == confirm_correo && correo != '' && validarEmail(correo)) {
            $('#cambiar_correo_btn').removeAttr('disabled');
        }
        else{
            $('#mensaje').html('No coincide el correo o es inválido');
            $('#cambiar_correo_btn').attr('disabled', 'disabled');
        }
    }
});

$(document).on('keyup', '#confirm_correo', function(){
    var confirm_correo = $(this).val();
    var correo = $('#correo').val();

    $('#mensaje').html('');
    if (confirm_correo.length)
    {
        if ( correo == confirm_correo && confirm_correo != '' && validarEmail(confirm_correo)) {
            $('#cambiar_correo_btn').removeAttr('disabled');
        }
        else{
            $('#mensaje').html('No coincide el correo o es inválido');
            $('#cambiar_correo_btn').attr('disabled', 'disabled');
        }
    }
});                

// Al presionar la tecla de enter en la pantalla de actualizar contraseña, checar que los valores entre contraseña y confirmar contraseña correspondan y actualizar
$(document).on("keypress", "#actualizar_empleado_modal", function(event) {         
    if(event.keyCode == 13){
        if($('#empleado').val() != '' && $('#correo').val() != '' && $('#correo').val() == $('#confirm_correo').val()) 
        {             
            $( "#cambiar_correo_btn" ).trigger( "click" );
            $('#actualizar_empleado_modal').modal('hide');
        }
    }
    return event.keyCode != 13;
});

// Al presionar la tecla ESC en la pantalla de actualizar correo desmarcar el check
$(document).on('keypress', '#actualizar_empleado_modal', function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    console.log(keycode); 
    if(keycode == '27'){
        var empleado = $('input[name="empleado"]').val();
        $('input[value="' + empleado + '"]').attr('checked', false);
        console.log(empleado);                    
    }
    //return event.keyCode != 27;
});

// Al dar click en un checkbox de los empleados lanzar la pantalla modal para asignar el correo
$(document).on('change', 'td[data-title="Autorizador"] > input[type="checkbox"]', function(e){
    var checkbox = $(this);
    var correo = $(this).parent().siblings('td[data-title="Correo"]').html();//$(this).parent().next().html();
    var respuesta;
    var es_autorizador = 0;

    // Si se marca, abrir la pantalla para capturar el correo, en caso de que se desmarque, preguntar si quiere quitarlo 
    if (checkbox[0].checked){
        $.ajax({
            type: "POST",
            data: {
                param: 19
            },
            url: "view/utilities.php",
            dataType: 'html',
            success: function(data) {
                $('div.container').append(data);
                $('div.container').find('input[name="empleado"]').val(checkbox.val());
                $('div.container').find('input[name="correo"]').val(correo);
                $('div.container').find('input[name="confirm_correo"]').val(correo);
                $('#actualizar_empleado_modal').modal('toggle');
            }
        });
    }
    else{
        // Acumula los empleados que tengan al usuario como autorizador
        $('select option:selected').each(function(){
            if($(this).val() == checkbox.val()){
                es_autorizador = es_autorizador + 1;
            }
        });

        // Si ya esta asociado a un empleado manda un mensaje
        if (es_autorizador) {
            checkbox[0].checked = true;
            alert('No se puede desmarcar, el usuario ya esta asignado como autorizador');
        }
        else{
            respuesta = confirm('¿Quitar el usuario de autorizadores?');
            if (respuesta){
                $.ajax({
                    type: "POST",
                    async: false,
                    data: {
                        param: 20,
                        empleado: checkbox.val(),
                        autoriza: 0,
                        correo: correo   
                    },
                    url: "view/utilities.php",
                    dataType: "html",
                    success: function(data) {
                        $('.cargando').hide(); // Oculta la imagen de cargando 
                        if(data)
                        {
                            alert(data);
                        }
                    }
                });                    
            }
            else{
                checkbox[0].checked = true;
            }
        }
    }            
});

// Asignar el usuario como autorizador
$(document).on('click', '#cambiar_correo_btn', function(){
    $.ajax({
        type: "POST",
        async: false,
        data: {
            param: 20,
            empleado: $('input[name="empleado"]').val(),
            autoriza: 1,
            correo: $('input[name="correo"]').val()   
        },
        url: "view/utilities.php",
        dataType: "html",
        success: function(data) {
            $('.cargando').hide(); // Oculta la imagen de cargando 
            if(data)
            {
                //alert(data);
                $('#actualizar_empleado_modal').modal('hide');
            }
        }
    });
});

// Al presionar el botón de cancelar, desmarcar el checkbox
$(document).on('click', '#cancelar_correo_btn', function(){
    var empleado = $('input[name="empleado"]').val();
    $('input[value="' + empleado + '"]').attr('checked', false);
});

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
$(document).on("keypress", "#actualizar_saldo_empleado_modal", function(event) {         
    if(event.keyCode == 13){
        return false;
    }
    return event.keyCode != 13;
});

// abrir pantalla para administrar saldos
$(document).on('click', '#editar-saldo-btn', function(){
    var empleado_modificar = $(this).attr('valor');
    var nombre = $(this).closest('tr').find('td:eq(3)').html();
    $('#actualizar_saldo_empleado_modal').remove();
    $.ajax({
        type: "POST",
        data: {
            param: 21,
            empleado: empleado_modificar
        },
        url: "view/utilities.php",
        dataType: 'html',
        success: function(data) {                
            $('div.container').append(data);
            $('div.container').find('input[name="empleado"]').val(empleado_modificar);
            $('div.container').find('input[name="nombre-usuario"]').val(nombre);                
            $('#actualizar_saldo_empleado_modal').modal('toggle');
        }
    });
});

// al presionar el botón agregar/modificar la base de datos y borrar el detalle de saldos y pintarlos con los nuevos valores.
$(document).on('click', '#agregar-saldo-btn', function(){
    var usuario = $('input[name="empleado"]').val();
    var anio = $('input[name="nuevo-anio"]').val();
    var saldo = $('input[name="nuevo-saldo"]').val();
    var AnioTabla = $("#Anio").text();
    
        if (anio != '' && saldo != '') {
            var respuesta = confirm('¿Agregar o actualizar el saldo del año ' + anio + '?');
            if (respuesta){
                $.ajax({
                    type: "POST",
                    data: {
                        param: 22,
                        usuario: usuario,
                        anio: anio,
                        saldo: saldo
                    },
                    url: "view/utilities.php",
                    dataType: 'html',
                    success: function(data) {
                        if (data.length == 0) {
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
                            $('input[name="nuevo-anio"]').val('');
                            $('input[name="nuevo-saldo"]').val('');
                            
                        }
                        else{
                            alert(data.length);
                        }
                    }
                });
                /*
                Leonardo Rafael Peña Hernandez.							06/03/2020
                Se agrega para poder agregar el nuevo cambio de los dias adelantados.
                */
                if($("#CheckAdelantarVacaciones").is(':checked')) {  
                    // alert("Está activado");  
                    // $("#CheckAdelantarVacaciones").attr('checked', false);
                    $.ajax({
                        type: "POST",
                        data: {
                            param: 32,
                            usuario: usuario,
                            anio: anio,
                            saldo: saldo
                        },
                        url: "view/utilities.php",
                        dataType: 'html',
                        success: function(data) {
                            if (data.length == 0) {
                                $("#CheckAdelantarVacaciones").attr('checked', false);
                            }
                            else{
                                alert(data.length);
                            }
                        }
                    });
                }
                //
            }
        }
        else{
            alert('Tiene que especificar año y saldo.');
            $('input[name="nuevo-anio"]').focus();
        }
    
});

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
    llenarDiasInhabiles();
    llenarDiasMarcados();
    habilitarSolicitarAutorizacion();   
});    

$(document).on('click', 'li', function(){
    $('#calendar').fullCalendar('gotoDate', formato_fecha($(this).html(), 2));
    pintarSeleccionados();                    
    llenarDiasInhabiles();
    llenarDiasMarcados();
});

// 31/07/2018: Cancelar días autorizados.
$('.btn-cancelar').click(function(){
    var fechas = [];
    var empleado = $(this).parents('table').attr('id');
    var fila = $(this).parent('tr');
    var total = $(this).parents('tbody').children().length;

    fechas.push(formato_fecha($(this).parent().siblings().html(), 2));

    var resultado = confirm('¿Cancelar la fecha ' + formato_fecha(fechas[0], 1) + '?');

    if (resultado) 
    {
        $.ajax({
            type: "POST",
            data: {
                empleado: empleado,
                fechas: fechas,
                param: 12
            },
            url: "view/utilities.php",
            dataType: 'html',
            success: function(data) {
                if (data.length) {
                    alert(data);
                }
            }
        });
        
        if (total - 1 == 0) {
            $(this).parents('table').remove();
        }
        else
        {
            $(this).closest('tr').remove();
        }
        console.log(total - 1);
    }        
});