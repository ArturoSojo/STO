<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-boxes fa-fw"></i> &nbsp; Pedidos
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <?php if($_SESSION['cargo_sto']=="Administrador"){ ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/pedido-realizado-list/" ><i class="fas fa-calendar-check fa-fw"></i> &nbsp; Pedidos Realizados</a>
            </li>
        <?php } ?>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/pedido-list/" ><i class="fas fa-list fa-fw"></i> &nbsp; Pedidos Pendientes</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/pedido-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar Pedido</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <div class="full-box dashboard-container">
        <?php
            require_once "./controladores/pedidoControlador.php";
            $ins_venta = new pedidoControlador();

            echo $ins_venta->administrador_paginador_pedido_controlador($pagina[2],15,$pagina[1],"","");
        ?>
    </div>
</div>