<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CCP PUNO ONLINE</title>
  <link rel="icon" href="<?php echo base_url();?>resources/img/logo.png" type="image/png" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="<?php echo base_url();?>resources/jquery-ui/jquery-ui.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url();?>resources/css/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>resources/font-awesome/css/font-awesome.min.css">

  <!-- jQuery -->
  <script src="<?php echo base_url();?>resources/js/jquery.js"></script>

  <!-- jQuery-UI -->
  <script src="<?php echo base_url();?>resources/jquery-ui/jquery-ui.js"></script>

  <!-- Bootstrap -->
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

<body class="text-center">
  <div class="container">
    <div class="login-box">
      <br>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <form action="<?php echo base_url();?>tramite/login" method="post" class="form-signin">
          <img class="mb-4" src="resources/img/logo.png" alt="" width="180" height="180">
          <br>
        

          <strong>Si Ud. desea presentar un NUEVO trámite haga click en el siguiente botón:</strong>
          <br><br>
          <div class="container">
            <div class="row">                
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <button type="button" onclick="window.location.href='<?php echo base_url();?>tramite/nuevo'" class="btn btn-success btn-block btn-flat" style="padding: 10px;"><span style="font-size: 20px;" class="fa fa-file-o">&nbsp;&nbsp;Nuevo Trámite</button>
              </div>
              <div class="col-md-3"></div>
            </div>
          </div>  

          <br><br>

          <span>Si Ud. ya tiene un trámite en curso, puede hacer la consulta del estado de su documento:</span>
          <br><br>
          <div class="row">                
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <?php if($this->session->flashdata("error")):?>
                <div class="alert alert-danger">
                  <p><?php echo $this->session->flashdata("error");?></p>
                </div> 
              <?php endif ?>
            </div>
            <div class="col-md-3"></div>
          </div>  

          <div class="row">                
            <div class="col-md-3"></div>
            <div class="col-md-6 border" style="padding: 50px;">
              <div class="form-group">
                <input type="text" class="form-control text-center" placeholder="Registro Único de Trámite (RUT)" name="registro" autofocus required maxlength="6">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group">
                <input type="text" class="form-control text-center" placeholder="Clave generada (5 dígitos)" name="clave" required maxlength="5">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>

              <button type="submit" class="btn btn-primary btn-block btn-flat"><span class="fa fa-search" style="font-size: 18px;">&nbsp;Consultar Trámite</span></button>
             </div>
            <div class="col-md-3"></div>
          </div>
          <br/>
          <div class="row">
              <div class="col-md-12">
                <span class="enlace" onclick="window.location.href = 'https://cdrxvipuno.org.pe/'"><img src="<?php echo base_url();?>resources/img/regresar.png" width="30" height="30">&nbsp;&nbsp;Ir al portal web www.cdrxvipuno.org.pe</span>
              </div>
          </div>
        </form>

      </div>
      <!-- /.login-box-body -->


    </div>

    <!-- /.login-box -->
  </div>

  <br><br><br>

  <div style="background: #fff; padding: 30px;" align="left">
    <div class="container">
      <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="110" height="110">
      
      <hr style="border-top: 1px solid #ccc;">
      <small style="color: #24387c;">© Colegio de Psicólogos del Perú - CDR XVI - Puno.</small>
    </div>
  </div>

  <script src="resources/js/jquery.js"></script>
  <script src="resources/css/bootstrap/js/bootstrap.min.js"></script>


  

  </body>
</html>
