<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class correoControlador extends mainModel{

		/*----------  Controlador iniciar sesion administrador - Controller login administrator ----------*/
		public function enviar_correo_cliente_controlador(){

			$nombre=mainModel::limpiar_cadena($_POST['name']);
			$correo=mainModel::limpiar_cadena($_POST['email']);
			$asunto=mainModel::limpiar_cadena($_POST['subject']);
			$mensaje=$_POST['message'];

			 /*-- Comprobando campos vacios - Checking empty fields --*/
            if($nombre=="" || $asunto=="" || $correo=="" || $mensaje==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Verificando integridad de los datos - Checking data integrity --*/
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$asunto)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El ASUNTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }


    $headers="MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html: charset=utf-8\r\n";
	$headers .="From: " . $nombre . " < " . $correo . " >\t\n";

	$enviar = mail("Arturosojovivas@gmail.com", $asunto, $mensaje, $headers);


	if ($enviar) {

				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Mensaje Enviado!",
                    "Texto"=>"Su mensaje se ha enviado exitosamente.",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
	}else{

	 			$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error",
                    "Texto"=>"El mensaje no ha podido ser enviado, intente nuevamente.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
	}

		echo json_encode($alerta);
		} /*-- Fin controlador - End controller --*/

	}