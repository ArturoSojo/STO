
<section  class="container-cart bg-white section">
    <div class="container container-web-page">
       <div class="heading">
           <h3 class="font-weight-bold poppins-regular text-uppercase">Favoritos</h3>
          </div>
        <div class="sub-heading">
           <h3 style="margin-bottom:50px; "><span>Acá usted puede ver sus productos favoritos</span></h3>
          </div>
        <hr>
    </div>

    <?php 
        require_once "./controladores/favoritoControlador.php";
        $ins_favorito = new favoritoControlador();

        echo $ins_favorito->paginador_favorito_controlador($pagina[1],5,$pagina[0]);
     ?>
    
</section>
