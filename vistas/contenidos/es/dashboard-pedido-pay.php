<!-- Page header -->
  <div class="container-fluid">
    <h1 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-lock fa-fw"></i> &nbsp; Registrar Pago
    <p class="lead">
        ¡Bienvenido <strong><?php echo $_SESSION['nombre_sto']." ".$_SESSION['apellido_sto'];?></strong>! Acá podrá registrar los datos del pago asociado al pedido.</p>
    </div>
    <?php  include "./vistas/inc/".LANG."/btn_go_back.php"; ?>

     <div class="container">
    <div class="dashboard-container mb-4 mt-4">
    <form class="dashboard-container FormularioAjax" method="POST" data-form="save" data-lang="<?php echo LANG;?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/pedidoAjax.php" enctype="multipart/form-data" >
        <input type="hidden" name="modulo_pedido" value="pago">
        <input type="hidden" name="pedido" value="<?php echo $pagina[2];?>">
    	<div class="text-center">
    	   <h3>¿Cuál fue el medio con que se efectuó el pago?</h3><br>
           <input type="text" name="tipo_pago" class="form-control">
           <br><br><br>
           <h3>Número de Referencia:</h3><br><input type="text" name="referencia" class="form-control">
    	<hr>
        <h2 align="center">&nbsp;<input type="submit" class="btn btn-success  mb-4 mt-4" value="GUARDAR"> </h2>
        <hr>  
 
    	</div>
        </form>
    </div>
</div> 

