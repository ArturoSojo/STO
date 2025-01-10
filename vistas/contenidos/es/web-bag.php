<section class="container-cart bg-white">
    <div class="container container-web-page">
        <h3 class="font-weight-bold poppins-regular text-uppercase">Carrito de compras</h3>
        <hr>
    </div>   
     <?php
            require_once "./controladores/carritoControlador.php";
            $ins_carrito = new carritoControlador();

            echo $ins_carrito->paginador_carrito_controlador($pagina[1],5,$pagina[0],"");
        ?>

</section>