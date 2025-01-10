<section class="container-cart bg-white">
    <div class="container container-web-page">
        <h3 class="font-weight-bold poppins-regular text-uppercase">Pedidos</h3>
        <hr>
    </div>
<div class="container-fluid">
<div class="row">
        <div class="col-4" >
          <div class="list-group" id="list-tab" role="tablist">
            <h3 class="list-group-item">Pedidos </h3>
            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="tab" href="#list-home" role="tab" aria-controls="list-home">Pendientes</a>
            <a class="list-group-item list-group-item-action" id="list-done-list" data-toggle="tab" href="#list-done" role="tab" aria-controls="list-done">Entregados</a>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
            <label class="list-group-item"></label>
          </div>
        </div>
        <div class="col-8 servicios">
          <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
            <?php
            require_once "./controladores/pedidoControlador.php";
            $ins_pedido = new pedidoControlador();

            echo $ins_pedido->paginador_pedido_controlador($pagina[1],5,$pagina[0],"Pendientes");
            ?>
            </div>
            <div class="tab-pane fade" id="list-done" role="tabpanel" aria-labelledby="list-done-list">
            
            <?php
                  echo $ins_pedido->paginador_pedido_controlador($pagina[1],5,$pagina[0],"Entregados");
            ?>

            </div>
          </div>
        </div>
      </div>    
</div>


</section>