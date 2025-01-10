<main role="main" class="container">
  <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm" style="background-color:#6f42c1;">
    <img class="fa fa-symfony">
    <div class="lh-100" >
      <h6 class="mb-0 text-white lh-100"><li class="fas fa-bell fa-2x"></li> &nbsp; Notificaciones</h6>
    </div>
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Notificaciones recientes</h6>
<?php
            require_once "./controladores/notificacionControlador.php";
            $ins_noti = new notificacionControlador();

             echo $ins_noti->paginador_notificacion_controlador($pagina[2],5,$pagina[1]);
        ?>
   </div>
 </main>