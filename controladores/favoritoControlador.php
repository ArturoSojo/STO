<?php

    if($peticion_ajax){
        require_once "../modelos/mainModel.php";
    }else{
        require_once "./modelos/mainModel.php";
    }

	class favoritoControlador extends mainModel{

        public function registrar_favorito_controlador(){

            
            if(!isset($_SESSION['cargo_sto'])){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else if($_SESSION['cargo_sto'] == "Usuario"){
                

            $id_pro=mainModel::decryption($_POST['producto']);
            $id_pro=mainModel::limpiar_cadena($id_pro);
            $id_cli=$_SESSION['id_sto'];

            /*-- Comprobando cliente en la DB - Checking client in DB --*/
            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id_cli'");
            if($check_cliente->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Cuenta no encontrada",
                    "Texto"=>"No hemos encontrado tu cuenta en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{

                $cliente=$check_cliente->fetch();
            }

            $check_product=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id_pro'");
            if($check_product->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Producto no encontrada",
                    "Texto"=>"No hemos encontrado el producto en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{

                $producto=$check_product->fetch();
            }

            $check_favorito=mainModel::ejecutar_consulta_simple("SELECT * FROM favorito WHERE cliente_id='$id_cli' AND producto_id='$id_pro'");
            if($check_favorito->rowCount()!=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ya lo has añadido",
                    "Texto"=>"Ya has añadido el producto a favoritos",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            $fecha = date('Y-m-d');

            $datos_favorito=[
                "favorito_fecha"=>[
                    "campo_marcador"=>":Fecha",
                    "campo_valor"=>$fecha
                ],
                "cliente_id"=>[
                    "campo_marcador"=>":Cliente",
                    "campo_valor"=>$id_cli
                ],
                "producto_id"=>[
                    "campo_marcador"=>":Producto",
                    "campo_valor"=>$id_pro
                ]

            ];

            $agregar_favorito=mainModel::guardar_datos("favorito",$datos_favorito);

            if($agregar_favorito->rowCount()==1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Guardado como Favorito!",
                    "Texto"=>"El producto fue añadido a favoritos con exito",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];

            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error",
                    "Texto"=>"No se ha podido añadir el producto a favoritos",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
            }

            $agregar_favorito->closeCursor();
            $agregar_favorito=mainModel::desconectar($agregar_favorito);

             }else{
                $alerta=
                    [ 
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

             echo json_encode($alerta);
             
        } 

        public function paginador_favorito_controlador($pagina,$registros,$url){
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $id_cli = $_SESSION['id_sto'];

            $url=mainModel::limpiar_cadena($url);
            $url=SERVERURL.$url."/";
            $tabla="";

            $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;


            $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM favorito WHERE cliente_id=$id_cli ORDER BY favorito_id DESC LIMIT $inicio,$registros";
           

            $conexion = mainModel::conectar();

            $favorito = $conexion->query($consulta);

            $favorito = $favorito->fetchAll();

            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);

            $tabla.='<div class="container-cards full-box">';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                $pag_inicio=$inicio+1;
                foreach($favorito as $f){

        $id_pro = mainModel::encryption($f['producto_id']);
        $datos_producto=mainModel::datos_tabla("Unico","producto","producto_id",$id_pro);
        $producto=$datos_producto->fetch();

         $total_price=$producto['producto_precio_venta']-($producto['producto_precio_venta']*($producto['producto_descuento']/100));

                    $tabla.='
                        <div class="card-product div-bordered bg-white shadow-2">
                            <figure class="card-product-img">
                            <img src="'.SERVERURL.'vistas/assets/product/cover/'.$producto['producto_portada'].'" class="img-fluid" alt="'.$producto['producto_nombre'].'" />
                            </figure>
                            <div class="card-product-body">
                                <div class="card-product-content scroll">
                                    <h5 class="text-center fw-bolder">'.mainModel::limitar_cadena($producto['producto_nombre'],70,"...").'</h5>
                                    <p class="card-product-price text-center fw-bolder">'.COIN_SYMBOL.number_format($total_price,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME.'</p>';
                                $tabla.='</div>
                                <form method="POST" class="FormularioAjax" data-form="save" data-lang="'.LANG.'" action="'.SERVERURL.'ajax/carritoAjax.php">
                                <input type="hidden" name="modulo_carrito" value="agregar">
                                <input type="hidden" name="producto" value="'.mainModel::encryption($producto['producto_id']).'">
                                <input type="hidden" name="cantidad" value="1">
                                <div class="text-center card-product-options" style="padding: 10px 0;">
                                    <button type="submit" class="btn btn-link btn-sm btn-rounded text-success" ><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</button>
                                    </form>
                                    &nbsp; &nbsp;
                                    <a href="'.SERVERURL.'details/'.mainModel::encryption($producto['producto_id']).'/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                                    &nbsp; &nbsp;
                                     <form method="POST" class="FormularioAjax" data-form="delete" data-lang="'.LANG.'" action="'.SERVERURL.'ajax/favoritoAjax.php" style="display: inline-block">
                                <input type="hidden" name="modulo_favorito" value="eliminar">
                                <input type="hidden" name="favorito" value="'.mainModel::encryption($f['favorito_id']).'">
                                    <button type="submit" class="btn btn-link btn-sm btn-rounded text-danger" ><i class="fas fa-trash fa-fw"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                    $contador++;
                }
                $pag_final=$contador-1;
            }else{
                if($total>=1){
                    $tabla.='
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-boxes fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">Haga clic en el botón para listar nuevamente los productos que están registrados en favoritos.</h4>
                            <a href="'.$url.'" class="btn btn-primary btn-rounded btn-lg" data-mdb-ripple-color="dark">Haga clic acá para recargar el listado</a>
                        </div>
                    ';
                }else{
                    $tabla.='
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-star fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">¡No hay Productos en Favoritos!</h4>
                            <p class="mb-0">No hemos encontrado productos registrados en favoritos.</p>
                        </div>
                    ';
                }
            }

            $tabla.='</div>';
                 



            if($total>0 && $pagina<=$Npaginas){
                $tabla.='<p class="text-end">Mostrando favoritos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
            }

            /*--Paginacion - Pagination --*/
            if($total>=1 && $pagina<=$Npaginas){
                $tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
            }

            return $tabla;
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador eliminar producto - Controller delete product ---------*/
        public function eliminar_favorito_controlador(){

            /*-- Recuperando id del producto - Retrieving product id - --*/
			$id=mainModel::decryption($_POST['favorito']);
			$id=mainModel::limpiar_cadena($id);

            /*-- Comprobando producto en la BD - Checking producto in DB --*/
			$check_pedido=mainModel::ejecutar_consulta_simple("SELECT * FROM favorito WHERE favorito_id='$id'");
			if($check_pedido->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Producto no encontrado",
					"Texto"=>"El producto que intenta eliminar de favoritos no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
            	$campos=$check_pedido->fetch();
			}
            $cliente_id = $campos['cliente_id'];

            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$cliente_id'");
            if($check_cliente->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos encontrado el cliente registrado en el sistema.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $cliente=$check_cliente->fetch();
            }

            /*-- Eliminando producto - Deleting product --*/
			$eliminar_favorito=mainModel::eliminar_registro("favorito","favorito_id",$id);

			if($eliminar_favorito->rowCount()==1){
				$alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Producto quitado de favoritos!",
                    "Texto"=>"El producto ha sido eliminado de favoritos exitosamente",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];

			}else{
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido eliminar el poducto de favoritos, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}

			$eliminar_favorito->closeCursor();
			$eliminar_favorito=mainModel::desconectar($eliminar_favorito);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/

  }