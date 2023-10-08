<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CCP EN LINEA</title>
  <link rel="icon" href="<?php echo base_url();?>resources/img/logo.png" type="image/png" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?php echo base_url();?>resources/css/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo base_url();?>resources/font-awesome/css/font-awesome.min.css">

  <script src="<?php echo base_url();?>resources/js/jquery.js"></script>
  <script src="<?php echo base_url();?>resources/css/bootstrap/js/bootstrap.min.js"></script>

  <style type="text/css">
    .enlace:hover {
      font-weight: bold;
      cursor:pointer;
    }
    .enlace:hover img {
      -webkit-transform: scale(1.3);
      transform: scale(1.3);
    }
  </style>
</head>
<body>
    <div class="container">
        <div class="row text-center">          
            <div class="col-md-12">
                <img src="<?php echo base_url();?>resources/img/portada.jpg" alt="" width="100%" height="340">
            </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <span class="enlace" onclick="window.location.href = 'https://ccppuno.org/'"><img src="<?php echo base_url();?>resources/img/regresar.png" width="30" height="30">&nbsp;&nbsp;Ir al Portal Web</span>
          </div>
        </div>
    </div>
    <br>

    <div id="consulta">
    <div class="container">
    <div class="row text-center">
    <div class="col-md-12">
      <h4>CONSTANCIA DE HABILIDAD EN LÍNEA</h4>
    </div>
    <br>
    <br>
    </div>
      <?php if($this->session->flashdata("error")):?>
        <div class="alert alert-danger">
          <p><?php echo $this->session->flashdata("error");?></p>
        </div>
      <?php endif ?>
 
      <form action="<?php echo base_url();?>habilidad/login" method="POST">
      <div class="row">
          <div class="col-md-2">
              <div class="form-group">
                  <label for="codigo">Matrícula:</label>
                  <input type="text" class="form-control text-center" placeholder="Nº Matrícula" name="matricula" maxlength="6" id="matricula" required autofocus>
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                  <label for="fnacimiento">Fecha Nacimiento:</label>
                  <input type="date" class="form-control" placeholder="Fecha" name="fnacimiento" id="fnacimiento" required>
              </div>
          </div>
          <div class="col-md-2">
              <div class="form-group">
                  <label for="codigo"><br></label>
                  <div id="img_captcha"><?php echo $captcha; ?></div>&nbsp;&nbsp;&nbsp;
              </div>
          </div>
          <div class="col-md-1">
          <div class="form-group">
              <label for="capcha_img"><br><br></label>
              <img style="cursor:pointer;" height="36" width="36" src="<?php echo base_url();?>resources/img/refresh.png" alt="Refresh Image" onclick=refrescar_img(); style="border: 0px; vertical-align: bottom">
          </div>
          </div>
          <div class="col-md-2">
              <div class="form-group">
                  <label for="capcha"><br></label>
                  <input type="text" class="form-control text-center" name="captcha" id="captcha" maxlength=5 value="" placeholder="INGRESE EL TEXTO" required>
              </div>
          </div>
          <div class="col-md-2">
              <div class="form-group">
                  <label for="consultar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                  <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-search"></span> Consultar</button>
              </div>
          </div>
      </div>
      </form>
    </div>
    </div>

    <div id="resultado"></div>

    <br><br><br><br>

    <div style="background: #000; padding: 30px;">
      <div class="container">
        <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="280" height="100">
        
        <hr style="border-top: 1px solid #ccc;">
        <small style="color: #fff;">© Colegio de Psicólogos del Perú - CDR XVI - Puno.</small>
      </div>
    </div>

  </body>
</html>

<script type="text/javascript">
  var base_url = "<?php echo base_url();?>";

  $('#matricula').keyup(function(e) {
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code==13) {
        $("#resultado").empty();
        if(this.value != '') 
          buscar_habilidad();
      }
  });


  $(function(){
    $('#captcha').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
        });
    });

  function refrescar_img(){
      var ruta =  base_url + "habilidad/refresh_captcha";
      $.ajax({
      url: ruta,
      type: "POST",
      success: function(data){
          $("#img_captcha").empty();
          $("#img_captcha").append(data);

          $("#captcha").focus();
      }
      }); 

  }

</script>
