<?php
  
        require_once "./modelos/mainModel.php";

	class visitasControlador extends mainModel{

        /*--------- Controlador registrar administrador - Controller register administrator ---------*/
     public function paginador_visitas_controlador($pagina,$registros,$url){
            $pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
            $url=SERVERURL.DASHBOARD."/".$url."/";
			$tabla="";
            

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;


            $campos="*";
            $cargo = $_SESSION["cargo_sto"];
            

			$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM visitas ORDER BY ultima_visita DESC LIMIT $inicio,$registros";

			$conexion = mainModel::conectar();

			$visitas = $conexion->query($consulta);

			$visitas = $visitas->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);

            if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($visitas as $v){

          $id_cli = $v["cliente_id"];
          $cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id_cli'");
          $c = $cliente->fetch();

    $tabla.=' <div class="my-3 p-3 bg-white rounded shadow-sm">
                <h6 class="border-bottom border-gray pb-2 mb-0">Últimas Visitas</h6>

                <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-dark">
                                <tr class="text-center font-weight-bold">
                                    <th>Avatar</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Estado</th>
                                    <th>Última visita</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                              <tr class="text-center">
                          <td><img width="30px" src="'.SERVERURL.'vistas/assets/avatar/'.$c["cliente_foto"].'"></td>
                          <td>'.$c["cliente_nombre"].'</td>
                          <td>'.$c["cliente_apellido"].'</td>
                          <td>'.$v["estado"].'</td>
                          <td>'.$v["ultima_visita"].'</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

               </div>';
				
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
                    $tabla.='
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-boxes fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">Haga clic en el botón para listar nuevamente las notificaciones.</h4>
                            <a href="'.$url.'" class="btn btn-primary btn-rounded btn-lg" data-mdb-ripple-color="dark">Haga clic acá para recargar</a>
                        </div>
					';
				}else{
					$tabla.='
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-broadcast-tower fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">¡No hay notificaciones para mostrar!</h4>
                            <p class="mb-0">No hemos encontrado notificaciones registradas.</p>
                        </div>
					';
				}
			}

            $tabla.='</div> </div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-end">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			/*--Paginacion - Pagination --*/
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
			}

			return $tabla;
        } /*-- Fin controlador - End controller --*/




}