<?php
  
        require_once "./modelos/mainModel.php";

	class notificacionControlador extends mainModel{

        /*--------- Controlador registrar administrador - Controller register administrator ---------*/
     public function paginador_notificacion_controlador($pagina,$registros,$url){
            $pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
            $url=SERVERURL.DASHBOARD."/".$url."/";
			$tabla="";
            

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;


            $campos="*";
            $cargo = $_SESSION["cargo_sto"];
            

			if($cargo == "Administrador"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM notificaciones WHERE receptor_id=0 ORDER BY id DESC LIMIT $inicio,$registros";

			$look_up=[
                "estado"=>[
                    "campo_marcador"=>":Estado",
                    "campo_valor"=>"Leído"
                ]
            ];
   
            $condicion=[
                "condicion_campo"=>"receptor_id",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>0
            ];

			$visto = mainModel::actualizar_datos("notificaciones",$look_up,$condicion);

			}else if ($cargo == "Usuario") {
				$id_usu = $_SESSION["id_sto"];

				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM notificaciones WHERE receptor_id='$id_usu'ORDER BY id DESC LIMIT $inicio,$registros";
			$look_up=[
                "estado"=>[
                    "campo_marcador"=>":Estado",
                    "campo_valor"=>"Leído"
                ]
            ];
   
            $condicion=[
                "condicion_campo"=>"receptor_id",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id_usu
            ];

				$visto = mainModel::actualizar_datos("notificaciones",$look_up,$condicion);
			}

			$conexion = mainModel::conectar();

			$notificaciones = $conexion->query($consulta);

			$notificaciones = $notificaciones->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);

            if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($notificaciones as $n){


			if ($n["concepto"] == "Pedido Entregado"){

    $tabla.='<div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>'.$n["concepto"].'</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <i>'.$n["fecha"].'</i>
        <strong class="d-block text-gray-dark">!'.$n["concepto"].'¡</strong>
        '.$n["asunto"].'
      </p>
    </div>';
}else if($n["concepto"] == "Pedido Anulado") {

    $tabla.='<div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>'.$n["concepto"].'</title><rect width="100%" height="100%" fill="#e83e8c";/><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <i>'.$n["fecha"].'</i>
        <strong class="d-block text-gray-dark">!'.$n["concepto"].'¡</strong>
         '.$n["asunto"].'
      </p>
    </div>';
  }else if($n["concepto"] == "Pedido Solicitado") {

    $tabla.='<div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>'.$n["concepto"].'</title><rect width="100%" height="100%" fill="#6f42c1"/><text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <i>'.$n["fecha"].'</i>
        <strong class="d-block text-gray-dark">!'.$n["concepto"].'¡</strong>
         '.$n["asunto"].'';if ($cargo == "Administrador") {
         
          $tabla.='&nbsp;<a href="'.SERVERURL.DASHBOARD.'/pedido-list/">Ver pedidos</a>';}
      $tabla.='</p>
    </div>
					';
		 }		
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