<nav class="full-box navbar-info">
    <a href="javascript:void(0);" class="float-start" onclick="show_nav_lateral()">
        <i class="fas fa-exchange-alt"></i>
    </a>
    <a href="<?php echo SERVERURL;?>" title="Web" >
        <i class="fas fa-home"></i>
    </a>
<a href="<?php echo SERVERURL.DASHBOARD."/notificacion/".$ins_login->encryption($_SESSION['id_sto']);?>/" class="header-button full-box" title="Notificaciones" >
    <i class="fas fa-bell"></i>
    <?php      
    $notificacion=$ins_login->datos_tabla("Normal","notificaciones WHERE receptor_id='0' AND estado='Sin leer'","*",0);
    ?>
    <span class="badge bg-danger rounded-pill bag-count" ><?php echo $notificacion->rowCount();?></span>
    <a href="<?php echo SERVERURL.DASHBOARD."/admin-update/".$ins_login->encryption($_SESSION['id_sto']); ?>/" title="Cuenta" >
        <i class="fas fa-user-cog"></i>
    </a>
    <a href="javascript:void(0);" onclick="cerrar_sesion_administrador()" title="Cerrar sesión" >
        <i class="fas fa-sign-out-alt"></i>
    </a>
</nav>