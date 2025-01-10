<main role="main" class="container">
  <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm" style="background-color:#6f42c1;">
    <img class="fa fa-symfony">
    <div class="lh-100" >
      <h6 class="mb-0 text-white lh-100"><li class="fas fa-visit fa-2x"></li> &nbsp; Últimas Visitas</h6>
    </div>
  </div>

    <?php
            require_once "./controladores/visitasControlador.php";
            $ins_visita = new visitasControlador();

             echo $ins_visita->paginador_visitas_controlador($pagina[2],5,$pagina[1]);
        ?>
 </main>