<?php
	$peticion_ajax=true;
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_correo'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/correoControlador.php";
        $ins_correo = new correoControlador();
        
        /*--------- Cerrar sesion administrador - Log out administrator ---------*/
        if($_POST['modulo_correo']=="enviar_correo_cliente"){
        	
            echo $ins_correo->enviar_correo_cliente_controlador();
		}

	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
	}