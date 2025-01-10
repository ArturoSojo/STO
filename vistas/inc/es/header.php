<header class="header full-box bg-white">
    <div class="header-brand full-box">
        <a href="<?php echo SERVERURL; ?>index/">
            <img src="<?php echo SERVERURL; ?>vistas/assets/img/logo.gif" alt="<?php echo COMPANY; ?>" class="img-fluid">
        </a>
    </div>

    <div class="header-options full-box">
        <nav class="header-navbar full-box poppins-regular font-weight-bold scroll" onclick="show_menu_mobile()" >
            <ul class="list-unstyled full-box" >
                <li>
                    <a href="<?php echo SERVERURL; ?>index/" >Inicio</a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>product/all/" >Productos</a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>contactenos/all/" >Contactanos</a>
                </li>

                <?php if(!isset($_SESSION['cargo_sto'])){ ?>
                <li>
                    <a href="<?php echo SERVERURL; ?>registration/" >Regístrate</a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>signin/" >Iniciar</a>
                </li>
                <?php }else{?>
                   <?php if($_SESSION['cargo_sto'] == "Usuario"){ ?> 
            <a href="<?php echo SERVERURL; ?>bag/" class="header-button full-box text-center" title="Carrito" >
            <i class="fas fa-shopping-bag"></i>
            <?php
            $my_id=$_SESSION["id_sto"];
            $carrito=$ins_login->datos_tabla("Normal","carrito WHERE IDCLIENTE='$my_id'","*",0);
             ?>
            <span class="badge bg-primary rounded-pill bag-count" ><?php echo $carrito->rowCount(); ?></span>
            </a>
            <a href="<?php echo SERVERURL;?>favorito/" class="header-button full-box text-center" title="Favoritos" >
            <i class="fas fa-star"></i>
             <?php
            $my_id=$_SESSION["id_sto"];
            $favorito=$ins_login->datos_tabla("Normal","favorito WHERE cliente_id='$my_id'","*",0);
             ?>
            <span class="badge bg-warning rounded-pill bag-count" ><?php echo $favorito->rowCount();?></span>
            </a>
            <a href="<?php echo SERVERURL.DASHBOARD."/notificacion/".$ins_login->encryption($_SESSION['id_sto']);?>/" class="header-button full-box text-center" title="Notificaciones" >
            <i class="fas fa-bell"></i>
            <?php
            $my_id=$_SESSION["id_sto"];
            $notificacion=$ins_login->datos_tabla("Normal","notificaciones WHERE receptor_id='$my_id' AND estado='Sin leer'","*",0);
             ?>
            <span class="badge bg-danger rounded-pill bag-count" ><?php echo $notificacion->rowCount();?></span>
            </a>
            <a href="<?php echo SERVERURL; ?>pedido/" class="header-button full-box text-center" title="Pedidos" >
            <i class="fas fa-truck-loading"></i>
            <?php
            $my_id=$_SESSION["id_sto"];
            $pedido = $ins_login->datos_tabla("Normal","pedidos WHERE pedido_estado_envio='Procesando' AND cliente_id='$my_id'","*",0);
             ?>
            <span class="badge bg-success rounded-pill bag-count" ><?php echo $pedido->rowCount();?></span>
            </a>
        <?php }?>
            <?php } ?>
            </ul>
        </nav>
   

        <?php if(isset($_SESSION['cargo_sto']) && ($_SESSION['cargo_sto']=="Administrador" || $_SESSION['cargo_sto']=="Usuario")){ ?>
            <div class="header-button full-box text-center" id="userMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo $_SESSION['usuario_sto']; ?>" >
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="dropdown-menu div-bordered popup-login" aria-labelledby="userMenu">
                <p class="text-center" style="padding-top: 10px;">
                    <i class="fas fa-user-circle fa-3x"></i><br>
                    <small><?php echo $_SESSION['usuario_sto']; ?></small>
                </p>
                <a class="dropdown-item" href="<?php echo SERVERURL.DASHBOARD; ?>/home/">
                    <i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard
                </a>
                <?php if ($_SESSION['cargo_sto'] == "Usuario") {?>
                    <a class="dropdown-item" href="<?php echo SERVERURL.DASHBOARD.'/client-update/'.mainModel::encryption($_SESSION['id_sto']); ?>"><i class="fas fa-user-alt"></i> &nbsp; Cuenta</a>
                <?php  } ?>

                <a class="dropdown-item" href="javascript:void(0);" onclick="cerrar_sesion_administrador()">
                    <i class="fas fa-sign-out-alt"></i> &nbsp; Cerrar sesión
                </a>
            </div>
        <?php } ?>



        <a href="javascript:void(0);" class="header-button full-box text-center d-lg-none" title="Menú" onclick="show_menu_mobile()" >
            <i class="fas fa-bars"></i>
        </a>
    </div>
</header>