<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class loginControlador extends mainModel{

		/*----------  Controlador iniciar sesion administrador - Controller login administrator ----------*/
		public function iniciar_sesion_controlador(){

			$usuario=mainModel::limpiar_cadena($_POST['dashboard_usuario']);
			$clave=mainModel::limpiar_cadena($_POST['dashboard_clave']);

			/*-- Comprobando campos vacios - Checking empty fields --*/
			if($usuario=="" || $clave==""){
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "No has llenado todos los campos que son requeridos.",
					  icon: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
				exit();
			}


			/*-- Verificando integridad datos - Verifying data integrity --*/
			
			if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "La contraseña no coincide con el formato solicitado.",
					  icon: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
				exit();
			}

			$clave=mainModel::encryption($clave);

			/*-- Verificando datos de la cuenta - Verifying account details --*/
			$datos_cuenta=mainModel::datos_tabla("Normal","usuario WHERE usuario_usuario='$usuario' AND 	usuario_clave='$clave' AND usuario_cuenta_estado='Activa'","*",0);
			$datoscliente=mainModel::datos_tabla("Normal","cliente WHERE cliente_email='$usuario' AND 	cliente_clave='$clave' AND cliente_cuenta_estado='Activa'","*",0);

			if($datos_cuenta->rowCount()==1){

				$row=$datos_cuenta->fetch();

				$datos_cuenta->closeCursor();
			    $datos_cuenta=mainModel::desconectar($datos_cuenta);

				$_SESSION['id_sto']=$row['usuario_id'];
				$_SESSION['nombre_sto']=$row['usuario_nombre'];
				$_SESSION['apellido_sto']=$row['usuario_apellido'];
				$_SESSION['genero_sto']=$row['usuario_genero'];
				$_SESSION['usuario_sto']=$row['usuario_usuario'];
				$_SESSION['cargo_sto']=$row['usuario_cargo'];
				$_SESSION['foto_sto']=$row['usuario_foto'];
				$_SESSION['token_sto']=mainModel::encryption(uniqid(mt_rand(), true));

				if(headers_sent()){
					echo "<script> window.location.href='".SERVERURL.DASHBOARD."/home/'; </script>";
				}else{
					if ($_SESSION['cargo_sto'] == "Administrador") {
						return header("Location: ".SERVERURL.DASHBOARD."/home/");
					}else if ($_SESSION['cargo_sto'] == "Usuario") {
						return header("Location: ".SERVERURL."bag/");
					}
					
				}

			} else if($datoscliente->rowCount()==1){

				$row=$datoscliente->fetch();

				$datoscliente->closeCursor();
			    $datoscliente=mainModel::desconectar($datoscliente);

			    $id_cli=$row['cliente_id'];
				$_SESSION['id_sto']=$row['cliente_id'];
				$_SESSION['nombre_sto']=$row['cliente_nombre'];
				$_SESSION['apellido_sto']=$row['cliente_apellido'];
				$_SESSION['genero_sto']=$row['cliente_genero'];
				$_SESSION['usuario_sto']=$row['cliente_nombre'];
				$_SESSION['cargo_sto']=$row['cliente_cargo'];
				$_SESSION['foto_sto']=$row['cliente_foto'];
				$_SESSION['token_sto']=mainModel::encryption(uniqid(mt_rand(), true));


$visita=mainModel::ejecutar_consulta_simple("SELECT * FROM visitas WHERE cliente_id='$id_cli'");
				$comprobar = $visita->rowCount();
				if ($comprobar==0) {
					
			$datos=[
				"cliente_id"=>[
					"campo_marcador"=>":cliente_id",
					"campo_valor"=>$id_cli
				],
				"ultima_visita"=>[
					"campo_marcador"=>":Visita",
					"campo_valor"=>date("Y-m-d-H-i-s")
                ],
				"estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>"Conectado"
                ]
			];

            /*-- Guardando datos del cliente - Saving client data --*/
			$agregar=mainModel::guardar_datos("visitas",$datos);
		
				}else{

			$datos=[
				"ultima_visita"=>[
					"campo_marcador"=>":Visita",
					"campo_valor"=>date("Y-m-d-H-i-s")
                ],
				"estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>"Conectado"
                ]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id_cli
			];

            $actualizar=mainModel::actualizar_datos("visitas",$datos,$condicion);

				}
				

				return header("Location: ".SERVERURL.DASHBOARD."/home/");
					
				

			}else{
				echo'<script>
					Swal.fire({
					  title: "Datos incorrectos",
					  text: "El nombre de usuario o contraseña no son correctos.",
					  icon: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
			}
		} /*-- Fin controlador - End controller --*/


		/*----------  Controlador forzar cierre de sesion - Controller force logout ----------*/
		public function forzar_cierre_sesion_controlador(){
			session_destroy();
			if(headers_sent()){
				echo "<script> window.location.href='".SERVERURL."index/'; </script>";
			}else{
				return header("Location: ".SERVERURL."index/");
			}
		} /*-- Fin controlador - End controller --*/


		/*----------  Controlador cierre de sesion administrador - Controller logout administrator  ----------*/
		public function cerrar_sesion_administrador_controlador(){

			if ($_SESSION["cargo_sto"] == "Usuario") {
				
				$datos=[
				"ultima_visita"=>[
					"campo_marcador"=>":Visita",
					"campo_valor"=>date("Y-m-d-H-i-s")
                ],
				"estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>"Desconectado"
                ]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$_SESSION["id_sto"]
			];

            $actualizar=mainModel::actualizar_datos("visitas",$datos,$condicion);
			}

			$token=mainModel::decryption($_POST['token']);
			$usuario=mainModel::decryption($_POST['usuario']);

			if($token==$_SESSION['token_sto'] && $usuario==$_SESSION['usuario_sto']){
				unset($_SESSION['id_sto']);
				unset($_SESSION['nombre_sto']);
				unset($_SESSION['apellido_sto']);
				unset($_SESSION['genero_sto']);
				unset($_SESSION['usuario_sto']);
				unset($_SESSION['cargo_sto']);
				unset($_SESSION['foto_sto']);
				unset($_SESSION['token_sto']);
				$alerta=[
					"Alerta"=>"redireccionar",
					"URL"=>SERVERURL."index/"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No se pudo cerrar la sesión",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador - End controller --*/
	}