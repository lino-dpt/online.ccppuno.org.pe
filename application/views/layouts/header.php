<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NET++ Software V1.0</title>


  <link rel="icon" href="<?php echo base_url();?>resources/img/logo.jpeg" type="image/png" />


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
<body>
    <div class="container-fluid">
      <div class="row" align="center">
        <div class="col-md-12">
            <a href="<?php echo base_url();?>dashboard" class='navbar-brand'><strong>Net++ V1.1</strong> [ Bienvenido: <?php echo $this->session->userdata("matricula") . " " . ucwords(strtolower($this->session->userdata("nombre"))); ?> ]</a>
        </div>
      </div>
      <br>
      <div class="row" align="center">
      <?php if($this->session->userdata("cambiar_clave") == 'F' && $this->session->userdata("actualizar_datos") == 'F'):?>
        <div class="col-md-2">
          <span class="enlace" onclick="window.location.href = '<?php echo base_url();?>agremiado/misdatos'"><img src="<?php echo base_url();?>resources/img/contacto.png" width="50" height="50">&nbsp;&nbsp;&nbsp;Mis Datos</span>
        </div>
        <div class="col-md-3">
          <span class="enlace" onclick="window.location.href = '<?php echo base_url();?>pago'"><img src="<?php echo base_url();?>resources/img/dinero.png" width="50" height="50">&nbsp;&nbsp;&nbsp;Todos Mis Pagos en línea</span>
        </div>
        <div class="col-md-3">
          <span class="enlace" onclick="window.location.href = '<?php echo base_url();?>habilidad/constancia'"><img src="<?php echo base_url();?>resources/img/diploma.png" width="50" height="50">&nbsp;&nbsp;&nbsp;Constancia Habilidad</span>
        </div>
      <?php endif;?>

      <div class="col-md-4">
        <span class="enlace" onclick="window.location.href = '<?php echo base_url();?>/auth/logout'"><img src="<?php echo base_url();?>resources/img/salida.png" width="50" height="50">&nbsp;&nbsp;&nbsp;Cerrar Sesión</span>
      </div>
      </div>


      <hr>
    </div>



  