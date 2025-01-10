<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-search fa-fw"></i> &nbsp; Buscar pedido
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <?php if($_SESSION['cargo_sto']=="Administrador"){ ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/pedido-realizado-list/" ><i class="fas fa-calendar-check fa-fw"></i> &nbsp; Pedidos Realizados</a>
            </li>
        <?php } ?>

        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/pedido-list/" ><i class="fas fa-boxes fa-fw"></i> &nbsp; Pedidos Pendientes</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/pedido-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar Pedido</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php
        if(!isset($_SESSION['fecha_inicio_pedido']) && empty($_SESSION['fecha_inicio_pedido'])){
    ?>
    <form class="dashboard-container mb-4 FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" data-lang="<?php echo LANG; ?>" method="POST" autocomplete="off" style="padding-top: 40px">
        <input type="hidden" name="modulo" value="pedido">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="form-outline mb-4">
                        <label>Desde: </label>
                        <input type="date" class="form-control" name="fecha_inicio" placeholder="Fecha Inicial">
                    </div>
                    <div class="form-outline mb-4">
                        <label>Hasta:</label>
                        <input type="date" class="form-control" name="fecha_final" placeholder="Fecha Final">
                    </div>
                    <p class="text-center">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> &nbsp; Buscar</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
    <?php }else{ ?>
    <div class="dashboard-container mb-4">
        <form class="mb-4 FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" data-lang="<?php echo LANG; ?>" method="POST">
            <input type="hidden" name="modulo" value="pedido">
            <input type="hidden" name="eliminar_busqueda" value="eliminar">
            <p class="lead text-center roboto-condensed-regular">Resultados de la búsqueda </p>
            <p class="text-center">
                <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> &nbsp; Eliminar búsqueda</button>
            </p>
        </form>

        <?php
            require_once "./controladores/pedidoControlador.php";
            $ins_pedido = new pedidoControlador();

            echo $ins_pedido->administrador_paginador_pedido_controlador($pagina[2],15,$pagina[1],$_SESSION['fecha_inicio_pedido'],$_SESSION['fecha_final_pedido']);
        ?>
    </div>
    <?php } ?>
</div>