<?php
  // Agregar las clases
  include ("models.php");
  include ("controllers.php");
  include ("views.php");
  // Iniciar sesión
  $controlador = Controller::getInstance();
  $controlador->startSessions();
  $data = $controlador->index();  

  // Si la diferencia entre el tiempo actual y el de acceso es mayor a 5 minutos, entonces salir.
  if (isset($_SESSION["acceso"]) && (time() - $_SESSION["acceso"]) > 1800) {
    $controlador->destroySessions();
    $data = $controlador->index();
  }  
?>  
<!doctype html>
<html lang="es">
  <head>
    <title><?php echo ($data['title']); ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel='stylesheet' href='assets/calendar/fullcalendar.css' />    
    <link rel="stylesheet" href="assets/css/estilos.css" type="text/css">
    <link rel="icon" type="image/png" href="assets/img/icon.png" />
    <link rel="stylesheet" type="text/css" href="http://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  </head>
  <body>
    <div class="container">
    <?php
      // Si hay usuario mostrar menú
      if ( $controlador->showMenu()) {
        include $controlador->showMenu();
      }
    ?>                  
    <div id="content-area">
    <?php
      include $data['content'];
      $controlador->mostrarMensaje();
      $controlador->borrarMensaje();    
    ?>      
    </div>    
    <?php 
      /* Se carga el pie de página que será igual para todas*/        
    ?>    
    <div class="cargando"></div>
  </div>
  <?php //Se carga el archivo de JavaScript
      include ("javascripts.php");
  ?>
      <script type="text/javascript">
      <?php
      if (isset($_REQUEST['a'])){
        switch ($_REQUEST['a']) {
          case 3:
            include ("assets/js/permisos.js");
            break;
           case 4:
            include ("assets/js/vacacionesAnticipadas.js");
            break;
          
          default:
            include ("assets/js/vacaciones.js");
            break;
        }
      }
      else{
        include ("assets/js/vacaciones.js");
      }?>
      </script>
  </body>
</html>