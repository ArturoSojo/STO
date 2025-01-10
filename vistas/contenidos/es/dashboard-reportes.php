<!-- Page header -->
  <div class="container-fluid">
    <h1 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-file fa-fw"></i> &nbsp; REPORTES
    </h1>
    <p class="lead">
        ¡Bienvenido <strong><?php echo $_SESSION['nombre_sto']." ".$_SESSION['apellido_sto'];?></strong>! Puedes exportar los registros de los pedidos realizados en el formato de preferencia en esta sección.</p>
    </div>
     <div class="container">
    <div class="dashboard-container mb-4 mt-4">
    	<div class="text-center">
    		<hr>
    	<form method="post" action="<?php echo SERVERURL;?>modelos/export.php?">
    			<h2>
    	<label>Mostrar reportes del: &nbsp;</label><select name="modo">
    		<option>
    			Día
    		</option>
    		<option>
    			Semana
    		</option>
    		<option>
    			Mes
    		</option>
    	</select>
    	</h2>
    	<hr>
    	 <h3 align="center"><li class="fas fa-download"></li> Exportar a: &nbsp;<button type="submit" class="btn btn-warning"><li class="fas fa-download"></li> &nbsp; PDF </button> </h3>
           <hr>  
          </form>
    	</div>
    </div>
</div> 
    	