<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CCP EN LINEA</title>
  <link rel="icon" href="<?php echo base_url();?>resources/img/logo.jpeg" type="image/png" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?php echo base_url();?>resources/css/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo base_url();?>resources/font-awesome/css/font-awesome.min.css">
  <script src="<?php echo base_url();?>resources/js/jquery.js"></script>
  <script src="<?php echo base_url();?>resources/css/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
        <div class="row text-center">          
            <div class="col-md-12">
                <img src="<?php echo base_url();?>resources/img/logo.jpeg" alt="" width="280" height="280">
            </div>
        </div>
    </div>
    <br>    
    <div class="container">
      <?php if($estado=='SI'):?>
      <div class="alert alert-success text-center" role="alert">
          <h5><strong>¡ CREDENCIAL VÁLIDO !!!</strong></h5>
      </div>
      <?php endif;?>
      <?php if($estado=='NO'):?>
      <div class="alert alert-danger text-center" role="alert">
          <h5><strong>¡ CREDENCIAL NO VÁLIDO !!!</strong></h5>
      </div>
      <?php endif;?>

      <?php if($estado=='SI'):?>
      <div class="row">          
          <div class="col-md-12">  
            <table class="table table-bordered">
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">DNI</span></td>
                    <td colspan="5"><?php echo $datos[0]->dni; ?></td>
                </tr>
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">Matrícula</span></td>
                    <td colspan="5"><?php echo $datos[0]->matricula; ?></td>
                </tr>
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">Titular</span></td>
                    <td colspan="5"><?php echo $datos[0]->nombre; ?></td>
                </tr>
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">Incorporación</span></td>
                    <td colspan="5"><?php echo $datos[0]->fecha_incorpora; ?></td>
                </tr>
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">Estado</span></td>
                    <td colspan="5"><?php echo $datos[0]->desestado; ?></td>
                </tr>

            </table>
          </div>    
      </div>
      <?php endif;?>
    
    </div>
  </body>
</html>
