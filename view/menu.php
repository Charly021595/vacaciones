<div class="row pd-top-10">
	<div class="col-md-2 center-align pd-10">
		<img id="logo_arzyz" src="assets/img/logo.jpg" width="150" style="display:none;" height="20" alt="ARZYZ" class="img-responsive">
		<img id="logo_fratech" src="assets/img/logo_fratech.png" style="display:none; margin-top: -10px;" width="150" height="20" class="img-responsive">
	</div>
	<div class="col-md-10">
		<nav id="navbar_unidad_negocio" class="navbar navbar-inverse">
		  <div class="container-fluid">
		  	<div class="navbar-header">
			    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
				</button>
				<!-- <a class="navbar-brand"><?php echo $_SESSION['user'];?></a> -->
		    </div>
		    <div class="collapse navbar-collapse" id="menu">
			<ul id="clase_fratech" class="nav navbar-nav">
				<?php 
				if (isset($_GET['a'])){ ?>
					<li class="<?php if($_GET['a'] == 1){ echo 'active';} ?>"><a href='../vacaciones/index.php?a=1'>Vacaciones </a></li>
					<!--<li class="<?php if($_GET['a'] == 3){ echo 'active';} ?>"><a href='../vacaciones/index.php?a=3'>Permisos</a></li>-->
					<!-- LPENA 26/10/2018
						Se agrega la opcion de Permisos para las cuentas
						que no son Administrativos.
					-->
					<li class="<?php if($_GET['a'] == 3){ echo 'active';} ?>"><a href='../vacaciones/index.php?a=3'> Permisos Personales / Laborales</a></li>
					
					<?php
						if($_SESSION['tipo'] == 1){
					?>
							<!-- <li class="<?php if($_GET['a'] == 3){ echo 'active';} ?>"><a href='../vacaciones/index.php?a=3'>Permisos </a></li> -->
							<li class="<?php if($_GET['a'] == 2){ echo 'active';} ?>"><a href='../vacaciones/index.php?a=2'>Administración </a></li>
							
							<li class="<?php if($_GET['a'] == 4){ echo 'active';} ?>"><a href='../vacaciones/index.php?a=4'>Asignar Vacaciones </a></li>
					<?php }
				} else { 
				?>
					<li><a href='../vacaciones/index.php?a=1'>Vacaciones </a></li>
					<!-- LPENA 26/10/2018
						Se agrega la opcion de Permisos para las cuentas
						que no son Administrativos. -->
					
					<li><a href='../vacaciones/index.php?a=3'>Permisos Personales / Laborales</a></li>
					
					<?php
						if($_SESSION['tipo'] == 1){
					?>	
						<!-- LPENA 26/10/2018
						Se trata de liberar informacion
						-->
						<!-- <li><a href='../vacaciones/index.php?a=3'>Permisos </a></li> -->
						<li><a href='../vacaciones/index.php?a=2'>Administración </a></li>
						<li><a href='../vacaciones/index.php?a=4'>Asignar Vacaciones </a></li>
				<?php
					}
				}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a id="logout-btn"><span class="glyphicon glyphicon-user"></span> Salir</a></li>
			</ul>
			
		    </div>
		  </div>
		</nav>
	</div>
</div>