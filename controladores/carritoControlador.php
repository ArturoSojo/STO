<?php

    if($peticion_ajax){
        require_once "../modelos/mainModel.php";
    }else{
        require_once "./modelos/mainModel.php";
    }

	class carritoControlador extends mainModel{

        /*--------- Controlador registrar producto - Controller register product ---------*/
        public function registrar_carrito_controlador(){


            if(!isset($_SESSION['cargo_sto'])){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"Debes ser un Usuatio para realizar esta operación, !REGISTRATE¡",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            $id_pro=mainModel::decryption($_POST['producto']);
            $id_pro=mainModel::limpiar_cadena($id_pro);
            $id_cli = $_SESSION["id_sto"];
            $Cantidad=$_POST['cantidad'];

            /*-- Comprobando privilegios - Checking privileges --*/

			if($_SESSION['cargo_sto']!="Usuario"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

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
                    "Titulo"=>"Producto no encontrado",
                    "Texto"=>"No hemos encontrado el producto en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{

                $producto=$check_product->fetch();
            }

            $check_carrito=mainModel::ejecutar_consulta_simple("SELECT * FROM carrito WHERE IDCLIENTE='$id_cli' AND IDPRODUCTO='$id_pro'");
            if($check_carrito->rowCount()<=0){
                $datos_carrito=[
                "IDCLIENTE"=>[
                    "campo_marcador"=>":Cliente",
                    "campo_valor"=>$id_cli
                ],
                "IDPRODUCTO"=>[
                    "campo_marcador"=>":Producto",
                    "campo_valor"=>$id_pro
                ],
                "PRECIO"=>[
                    "campo_marcador"=>":Precio",
                    "campo_valor"=>$producto['producto_precio_venta']
                ],
                "CANTIDAD"=>[
                    "campo_marcador"=>":Cantidad",
                    "campo_valor"=>$Cantidad
                ]
            ];


            /*-- Guardando datos del producto - Saving product data --*/
            $agregar_producto=mainModel::guardar_datos("carrito",$datos_carrito);

            if($agregar_producto->rowCount()==1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Producto Añadido!",
                    "Texto"=>"El producto se ha añadido al carrito con éxito",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido añadir el producto, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
            }

            }else{

                $carrito=$check_carrito->fetch();
                $datos_carrito=[
                "IDCLIENTE"=>[
                    "campo_marcador"=>":Cliente",
                    "campo_valor"=>$id_cli
                ],
                "IDPRODUCTO"=>[
                    "campo_marcador"=>":Producto",
                    "campo_valor"=>$id_pro
                ],
                "PRECIO"=>[
                    "campo_marcador"=>":Precio",
                    "campo_valor"=>$producto['producto_precio_venta']
                ],
                "CANTIDAD"=>[
                    "campo_marcador"=>":Cantidad",
                    "campo_valor"=>$carrito["CANTIDAD"] + $Cantidad
                ]
            ];
        $condicion=[
                "condicion_campo"=>"ID",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$carrito['ID']
            ];

           $agregar_producto=mainModel::actualizar_datos("carrito",$datos_carrito,$condicion);

           if($agregar_producto->rowCount()==1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Producto Añadido!",
                    "Texto"=>"El producto se ha añadido al carrito con éxito",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido añadir el producto",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
            }

            }

			$agregar_producto->closeCursor();
			$agregar_producto=mainModel::desconectar($agregar_producto);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


          public function paginador_carrito_controlador($pagina,$registros,$url,$orden){
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $id_cli = $_SESSION['id_sto'];

            $url=mainModel::limpiar_cadena($url);
            $orden=mainModel::limpiar_cadena($orden);
            $url=SERVERURL.$url."/";
            $tabla="";

            $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

            
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM carrito WHERE IDCLIENTE=$id_cli LIMIT $inicio,$registros";
         

            $conexion = mainModel::conectar();

            $carrito = $conexion->query($consulta);

            $carrito = $carrito->fetchAll();

            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);

            $tabla.='<div class="container-cards full-box">';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                $pag_inicio=$inicio+1;
                foreach($carrito as $carrito){

        $id_pro = mainModel::encryption($carrito['IDPRODUCTO']);
        $datos_producto=mainModel::datos_tabla("Unico","producto","producto_id",$id_pro);
        $producto=$datos_producto->fetch();

        $total_price=$producto['producto_precio_venta']-($producto['producto_precio_venta']*($producto['producto_descuento']/100));
        $totalpago = $total_price * $carrito["CANTIDAD"] + $producto['producto_costo_envio'];

                    $tabla.='
                         <div class="container" style="padding-top: 40px;">
        <div class="row">
            <div class="col-12 col-md-7 col-lg-8">
                <div class="container-fluid">
                    <h5 class="poppins-regular font-weight-bold full-box text-center">'.$producto['producto_nombre'].'</h5>
                    <div class="bag-item full-box">
                        <figure class="full-box">
                        <img src="'.SERVERURL.'vistas/assets/product/cover/'.$producto['producto_portada'].'" class="img-fluid" alt="producto_nombre">
                        </figure>
                        <div class="full-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-lg-6 text-center mb-4">
                                        <div class="row justify-content-center">
    <form class="FormularioAjax" action="'.SERVERURL.'ajax/carritoAjax.php" method="POST" data-form="delete" data-lang="'.LANG.'" > 
    <input type="hidden" name="modulo_carrito" value="actualizar">
    <input type="hidden" name="producto" value="'.mainModel::encryption($producto['producto_id']).'">  
    <input type="hidden" name="cliente" value="'.mainModel::encryption($_SESSION['id_sto']).'">   
                                            <div class="col-auto">
                                                <div class="form-outline mb-4">
                                                    <input type="number" value="'.$carrito["CANTIDAD"].'" class="form-control text-center" name="cantidad" pattern="[0-9]{1,10}" maxlength="10" style="max-width: 100px; ">
                                                    <label for="product_cant" class="form-label">Cantidad</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-success" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Actualizar cantidad" ><i class="fas fa-sync-alt fa-fw"></i></button>
                                            </div>
                                        </form>
                                     </div>
                                    </div>
                                    <div class="col-12 col-lg-4 text-center mb-4">
                                        <span class="poppins-regular font-weight-bold" >SUBTOTAL: '.number_format($total_price * $carrito["CANTIDAD"],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND) . ' ' . COIN_SYMBOL.'</span>
                                    </div>
                                    <div class="col-12 col-lg-2 text-center text-lg-end mb-4">
    <form class="FormularioAjax" action="'.SERVERURL.'ajax/carritoAjax.php" method="POST" data-form="delete" data-lang="'.LANG.'" > 
    <input type="hidden" name="modulo_carrito" value="eliminar">
    <input type="hidden" name="producto" value="'.mainModel::encryption($producto['producto_id']).'">         
                                    <button type="submit" class="btn btn-danger" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Quitar del carrito" >
                                            <span aria-hidden="true"><i class="far fa-trash-alt"></i></span>
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <hr>

                    <p class="text-justify">
                        <small>
                            En caso de que no se posea el producto en almacén, los datos del mismo fueran incorrectos o existieran cambios o restricciones por parte de la tienda (precio, inventario, u otras condiciones para la venta) <strong><?php echo COMPANY; ?></strong> se reserva el derecho de cancelar el pedido.
                        </small>
                    </p>
                </div> 
            </div>
            <div class="col-12 col-md-5 col-lg-4">
                <div class="full-box div-bordered">
                    <h5 class="text-center text-uppercase bg-success" style="color: #FFF; padding: 10px 0;">Resumen de la orden</h5>
                    <ul class="list-group bag-details">
                        <a class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                            Subtotal
                            <span>'.number_format($total_price * $carrito["CANTIDAD"],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND) . ' ' . COIN_NAME.'</span>
                        </a>
                        <a class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                            Descuento
                            <span>'.$producto['producto_descuento'].'%</span>
                        </a>
                        <a class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                            Envio
                            <span>'.number_format($producto['producto_costo_envio'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND) . ' ' . COIN_NAME.'</span>
                        </a>
                        <a class="list-group-item d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #E1E1E1;"></a>
                        <a class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                            Total
                            <span>'.$totalpago.' '. COIN_SYMBOL.'</span>
                        </a>
                    </ul>
                    <center>
                    <form method="POST" class="FormularioAjax" data-form="save" data-lang="'.LANG.'" action="'.SERVERURL.'ajax/pedidoAjax.php">
                                <input type="hidden" name="modulo_pedido" value="agregar">
                                <input type="hidden" name="producto" value="'.mainModel::encryption($producto['producto_id']).'">
                                <button type="submit" class="btn btn-primary">Confirmar pedido</button>
                                    </form>
                    </center>
                </div>
            </div>
        </div><hr>
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
                            <h4 class="alert-heading">Haga clic en el botón para listar nuevamente los productos que están registrados en el carrito.</h4>
                            <a href="'.$url.'" class="btn btn-primary btn-rounded btn-lg" data-mdb-ripple-color="dark">Haga clic acá para recargar el listado</a>
                        </div>
                    ';
                }else{
                    $tabla.='
                        <div class="container">
                            <p class="text-center" ><i class="fas fa-shopping-bag fa-5x"></i></p>
                            <h4 class="text-center poppins-regular font-weight-bold" >Carrito de compras vacío</h4>
                        </div>
                    ';
                }
            }

            $tabla.='</div>';

            if($total>0 && $pagina<=$Npaginas){
                $tabla.='<p class="text-end">Mostrando carrito <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
            }

            /*--Paginacion - Pagination --*/
            if($total>=1 && $pagina<=$Npaginas){
                $tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
            }

            return $tabla;
        } /*-- Fin controlador - End controller --*/




     
        /*--------- Controlador eliminar producto - Controller delete product ---------*/
        public function eliminar_carrito_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Usuario"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

            /*-- Recuperando id del producto - Retrieving product id - --*/
			$id_pro=mainModel::decryption($_POST['producto']);
			$id_pro=mainModel::limpiar_cadena($id_pro);
            $id_cli = $_SESSION["id_sto"];

            /*-- Comprobando producto en la BD - Checking producto in DB --*/
			$check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id_pro'");
			if($check_producto->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Producto no encontrado",
					"Texto"=>"El producto que intenta eliminar no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
            	$producto=$check_producto->fetch();
			}
			

            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id_cli'");
            if($check_cliente->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Usuario no encontrado",
                    "Texto"=>"El usuario no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $cliente=$check_cliente->fetch();
            }


            $check_carrito=mainModel::ejecutar_consulta_simple("SELECT * FROM carrito WHERE IDCLIENTE='$id_cli' AND IDPRODUCTO='$id_pro'");
            if($check_carrito->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se ha encontrado este producto en el carrito",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $carrito=$check_carrito->fetch();
            }

            /*-- Eliminando producto - Deleting product --*/
			$eliminar_producto=mainModel::eliminar_registro("carrito","ID",$carrito['ID']);

			if($eliminar_producto->rowCount()==1){
				$alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Producto eliminado!",
                    "Texto"=>"El producto ha sido eliminado del carrito exitosamente",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido eliminar el producto del carrito, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}

			$eliminar_producto->closeCursor();
			$eliminar_producto=mainModel::desconectar($eliminar_producto);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/

        /*--------- Controlador actualizar producto - Controller update product ---------*/
        public function actualizar_carrito_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
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
            }
			if($_SESSION['cargo_sto']!="Usuario"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

            /*-- Recuperando id del producto - Retrieving product id - --*/
			$id_pro=mainModel::decryption($_POST['producto']);
			$id_pro=mainModel::limpiar_cadena($id_pro);
            $id_cli=mainModel::decryption($_POST['cliente']);
            $id_cli=mainModel::limpiar_cadena($id_cli);

            /*-- Comprobando producto en la BD - Checking producto in DB --*/
			$check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id_pro'");
			if($check_producto->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Producto no encontrado",
					"Texto"=>"El producto que intenta actualizar no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
            	$campos=$check_producto->fetch();
			}


            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id_cli'");
            if($check_cliente->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Usuario no encontrado",
                    "Texto"=>"El usuario no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $cliente=$check_cliente->fetch();
            }


            $check_carrito=mainModel::ejecutar_consulta_simple("SELECT * FROM carrito WHERE IDCLIENTE='$id_cli' AND IDPRODUCTO='$id_pro'");
            if($check_carrito->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se ha encontrado este producto en el carrito",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $carrito=$check_carrito->fetch();
            }

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $Cantidad=$_POST['cantidad'];
        

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($Cantidad==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El campo cantidad esta vacio",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($Cantidad<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has colocado una cantidad valida",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
           

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
            $datos_carrito=[
                "IDCLIENTE"=>[
                    "campo_marcador"=>":Cliente",
                    "campo_valor"=>$id_cli
                ],
                "IDPRODUCTO"=>[
                    "campo_marcador"=>":Producto",
                    "campo_valor"=>$id_pro
                ],
                "PRECIO"=>[
                    "campo_marcador"=>":Precio",
                    "campo_valor"=>$campos['producto_precio_venta']
                ],
                "CANTIDAD"=>[
                    "campo_marcador"=>":Cantidad",
                    "campo_valor"=>$Cantidad
                ]
            ];

        $condicion=[
                "condicion_campo"=>"ID",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$carrito['ID']
            ];

         $actualizar_carrito=mainModel::actualizar_datos("carrito",$datos_carrito,$condicion);

           if($actualizar_carrito->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Producto Actualizado!",
                    "Texto"=>"El producto se ha actualizado con éxito",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido actualizar el producto",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
            }

            

            $actualizar_carrito->closeCursor();
            $actualizar_carrito=mainModel::desconectar($actualizar_carrito);

            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/
    }