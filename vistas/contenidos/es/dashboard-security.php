<!-- Page header -->
  <div class="container-fluid">
    <h1 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-lock fa-fw"></i> &nbsp; Seguridad
    </h1>
    <p class="lead">
        ¡Bienvenido <strong><?php echo $_SESSION['nombre_sto']." ".$_SESSION['apellido_sto'];?></strong>! Aquí puedes respaldar la Base de Datos de tu negocio para guardar los datos existentes o importar una base de datos para extraer los datos de las tablas.</p>
    </div>
     <div class="container">
    <div class="dashboard-container mb-4 mt-4">
    	<div class="text-center">
    	   <img src="<?php echo SERVERURL;?>vistas/assets/img/backup.png" width="200px">
    	<hr>
        <h2 align="center">&nbsp;<a href="<?php echo SERVERURL;?>modelos/database_backup.php" class="btn btn-danger  mb-4 mt-4"> Respaldar Base de Datos &nbsp;<li class="fas fa-download"></li> </a> </h2>
        <hr>  
 
    	</div>
    </div>
</div> 

