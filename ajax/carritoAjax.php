<?php
	$peticion_ajax=true;
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_carrito'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/carritoControlador.php";
        $ins_carrito = new carritoControlador();
        

        /*--------- Registrar pedido - Register ---------*/
        if($_POST['modulo_carrito']=="agregar"){
            echo $ins_carrito->registrar_carrito_controlador();
		}
		
		/*--------- Eliminar pedido - Delett ---------*/
        if($_POST['modulo_carrito']=="eliminar"){
            echo $ins_carrito->eliminar_carrito_controlador();
		}
		
		/*--------- Actualizar pedido - Update ---------*/
        if($_POST['modulo_carrito']=="actualizar"){
            echo $ins_carrito->actualizar_carrito_controlador();
        }

	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
	}