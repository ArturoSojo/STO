<?php if ($_SESSION['cargo_sto'] == "Administrador") {?>
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-info-circle fa-fw"></i> &nbsp; Información de pedido
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
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/pedido-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar Pedido</a>
        </li>
    </ul>
</div>
<?php  }?>
<div class="container-fluid">
    <div class="dashboard-container" >
        <?php
            include "./vistas/inc/".LANG."/btn_go_back.php";
            
            $datos_pedido=$ins_login->datos_tabla("Unico","pedidos","pedido_id",$pagina[2]);
            if($datos_pedido->rowCount()==1){
                $campos=$datos_pedido->fetch();
                $total_price=$campos["pedido_costo"];

                $datos_producto=$ins_login->datos_tabla("Unico","producto","producto_id",$pagina[4]);
                $producto=$datos_producto->fetch();
                $datos_cliente=$ins_login->datos_tabla("Unico","cliente","cliente_id",$pagina[3]);
                $cliente=$datos_cliente->fetch();

        ?>
        <div class="product-list-img">
            <figure>
                <img src="<?php echo SERVERURL; ?>vistas/assets/product/cover/<?php echo $campos['pedido_foto'];?>" class="img-fluid">
        <div class="product-list-img">
           </figure>
       </div>                    
        <br>
        <fieldset class="mb-4">
            <legend><i class="fas fa-info"></i> &nbsp; Información del Pedido</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['pedido_codigo']; ?>" id="pedido_codigo" readonly >
                            <label for="pedido_codigo" class="form-label">Código</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['pedido_fecha']; ?>" id="producto_fecha" readonly >
                            <label for="pedido_fecha" class="form-label">Fecha</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['pedido_tipo_envio']; ?>" id="pedido_tipo_envio" readonly >
                            <label for="pedido_tipo_envio" class="form-label">Tipo de Envio</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo COIN_SYMBOL.number_format($total_price,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME; ?>" id="pedido_costo" readonly >
                            <label for="pedido_costo" class="form-label">Costo</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="fas fa-box"></i> &nbsp; Información del Producto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $producto['producto_nombre']; ?>"  id="producto_nombre" readonly >
                            <label for="producto_nombre" class="form-label">Nombre</label>
                        </div>
                    </div>
                     <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $producto['producto_tipo']; ?>" id="producto_tipo" readonly >
                            <label for="producto_tipo" class="form-label">Tipo de producto</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $producto['producto_presentacion']; ?>" id="producto_presentacion" readonly >
                            <label for="producto_presentacion" class="form-label">Presentación de producto</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $producto['producto_estado']; ?>" id="producto_estado" readonly >
                            <label for="producto_estado" class="form-label">Estado de producto</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $producto['producto_marca']; ?>" id="producto_marca" readonly >
                            <label for="producto_marca" class="form-label">Fabricante</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
         <?php if ($_SESSION['cargo_sto'] == "Usuario"){?>
           <?php
        $datos_empresa=$ins_login->datos_tabla("Normal","empresa","*",0);
            $campos=$datos_empresa->fetch();
    ?>
        <fieldset class="mb-4">
            <legend><i class="far fa-building"></i> &nbsp; Información de la empresa</legend>
            <div class="container-fluid">
                <div class="row">
                    
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9-]{4,30}" class="form-control" name="empresa_numero_documento_up" value="<?php echo $campos['empresa_tipo_documento'] . " " . $campos['empresa_numero_documento']; ?>" id="empresa_numero_documento" maxlength="30" readonly>
                            <label for="empresa_numero_documento" class="form-label">&nbsp; Número de documento de la Empresa</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{3,80}" class="form-control" name="empresa_nombre_up" value="<?php echo $campos['empresa_nombre']; ?>" id="empresa_nombre" maxlength="80" readonly >
                            <label for="empresa_nombre" class="form-label">Nombre de la Empresa</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="empresa_telefono_up" value="<?php echo $campos['empresa_telefono']; ?>" id="empresa_telefono" maxlength="20" readonly>
                            <label for="empresa_telefono" class="form-label">Teléfono</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-outline mb-4">
                            <input type="email" class="form-control" name="empresa_email_up" value="<?php echo $campos['empresa_email']; ?>" id="empresa_email" maxlength="47" readonly>
                            <label for="empresa_email" class="form-label">Email</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" class="form-control" name="empresa_direccion_up" value="<?php echo $campos['empresa_direccion']; ?>" id="empresa_direccion" maxlength="97" readonly>
                            <label for="empresa_direccion" class="form-label">Dirección</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="fas fa-coins"></i> &nbsp; Métodos de Pago</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="form-online mb-4">
                            <textarea class="form-control" name="Modos_de_Pago" style="height: 400px;" readonly> <?php echo $campos['metodos_de_pago']; ?></textarea>
                            <label for="Modos_de_Pago" class="form-label"><i></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <?php } if ($_SESSION['cargo_sto'] == "Administrador"){?>
        <fieldset class="mb-4">
            <legend><i class="fas fa-user"></i> &nbsp; Información del Cliente</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $cliente['cliente_nombre']; ?>" id="cliente_nombre" readonly >
                            <label for="cliente_nombre" class="form-label">Nombre</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $cliente['cliente_apellido']; ?>" id="cliente_apellido" readonly >
                            <label for="cliente_apellido" class="form-label">Apellido</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $cliente['cliente_genero']; ?>" id="cliente_genero" readonly >
                            <label for="cliente_genero" class="form-label">Genero</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $cliente['cliente_telefono']; ?>" id="cliente_telefono" readonly >
                            <label for="cliente_telefono" class="form-label">Teléfono</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $cliente['cliente_provincia']; ?>" id="cliente_provincia" readonly >
                            <label for="cliente_provincia" class="form-label">Estado</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $cliente['cliente_ciudad']; ?>" id="cliente_ciudad" readonly >
                            <label for="cliente_ciudad" class="form-label">Ciudad</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $cliente['cliente_direccion']; ?>" id="cliente_direccion" readonly >
                            <label for="cliente_direccion" class="form-label">Dirección</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $cliente['cliente_email']; ?>" id="cliente_email" readonly >
                            <label for="cliente_email" class="form-label">Correo</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

      
        <?php
        }
            }else{ include "./vistas/inc/".LANG."/error_alert.php";
        }
        
        ?>
    </div>
</div>