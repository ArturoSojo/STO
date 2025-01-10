
     <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center white">
            <h1 class="service-title pad-bt15 mt-4">Contactenos</h1>
            <p class="sub-title pad-bt15">Puede enviarnos un correo o contactarnos directamente por nuestro número telefónico.</p>
            <hr class="bottom-line white-bg">
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="loction-info white">
              <p><i class="fa fa-map-marker fa-fw pull-left fa-2x mb-4" style="color:#715BF4;"></i><?php echo COUNTRY . " " . ADDRESS;?><br></p>
              <p><i class="fa fa-envelope fa-fw pull-left fa-2x mb-4" style="color:#715BF4;"></i><?php echo EMAIL; ?></i> </p>
              <p><i class="fa fa-phone fab-fw pull-left fa-2x mb-4" style="color:#715BF4;"></i>&nbsp; <?php echo PHONE;?></p>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="contact-form">
              <div id="sendmessage"></div>
              <div id="errormessage"></div>
              <h3>¡Envianos un Mensaje!</h3>
              <form class="FormularioAjax" action="<?php echo SERVERURL;?>ajax/correoAjax.php" method="POST" data-lang="<?php echo LANG;?>" >
                <input type="hidden" name="modulo_correo" value="enviar_correo_cliente">
                <div class="col-md-6 padding-right-zero">
                   <div class="form-group form-outline mb-2">
                 <input type="text" name="name" pattern="[a-zA-Z0-9- ]{1,49}" class="form-control" id="name" id="name" data-rule="minlen:4" data-msg="Por favor introduce al menos 4 carácteres." style="background: #fff" />
                 <label for="name" class="form-label">Nombre</label>
              <div class="validation"></div>
            </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-outline mb-2" style="float:top;">
                    <input type="email"  class="form-control" name="email" id="email" data-rule="email" data-msg="Por favor introduce un correo valido" style="background: #fff"/>
                    <label for="email" class="form-label">Correo</label>
                    <div class="validation"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group form-outline mb-2">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Por favor introduce al menos 8 carácteres para el asunto." style="background: #fff"/>
                    <label for="subject" class="form-label">Asunto</label>
                    <div class="validation"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group form-outline mb-4">
                    <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Por favor escribenos algo." id="mensaje" style="background: #fff"></textarea>
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <div class="validation"></div>
                 </div>
                <div class="text-center" style="margin-top:20px; margin-bottom:20px;"><button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Enviar</button></div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!---->