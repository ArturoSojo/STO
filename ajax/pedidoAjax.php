<?php
	$peticion_ajax=true;
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_pedido'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/pedidoControlador.php";
        $ins_pedido = new pedidoControlador();
        
        /*--------- Registrar pedido - Register ---------*/
        if($_POST['modulo_pedido']=="agregar"){
            echo $ins_pedido->registrar_pedido_controlador();
		}
		
		/*--------- Eliminar pedido - Delett ---------*/
        if($_POST['modulo_pedido']=="eliminar"){
            echo $ins_pedido->eliminar_pedido_controlador();
		}
		
		/*--------- Actualizar pedido - Update ---------*/
        if($_POST['modulo_pedido']=="entregar"){
            echo $ins_pedido->entregar_pedido_controlador();
        }

        if($_POST['modulo_pedido']=="exportar"){
            echo $ins_pedido->exportar_pedido_controlador();
        }

        if($_POST['modulo_pedido']=="pago"){
            echo $ins_pedido->pago_pedido_controlador();
        }

	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
	}