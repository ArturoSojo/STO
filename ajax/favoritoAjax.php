<?php
	$peticion_ajax=true;
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_favorito'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/favoritoControlador.php";
        $ins_favorito = new favoritoControlador();
        
        /*--------- Registrar pedido - Register ---------*/
        if($_POST['modulo_favorito']=="agregar"){
            echo $ins_favorito->registrar_favorito_controlador();
		}
		
		/*--------- Eliminar pedido - Delett ---------*/
        if($_POST['modulo_favorito']=="eliminar"){
            echo $ins_favorito->eliminar_favorito_controlador();
		}

	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
	}