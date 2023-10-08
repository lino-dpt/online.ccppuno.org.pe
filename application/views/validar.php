<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CDR XVI PUNO ONLINE</title>
  <link rel="icon" href="<?php echo base_url();?>resources/img/logo.jpeg" type="image/png" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?php echo base_url();?>resources/css/bootstrap/css/bootstrap.css">
  <script src="<?php echo base_url();?>resources/js/jquery.js"></script>
  <script src="<?php echo base_url();?>resources/css/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
    <br>    
    <div class="container">
        <div class="row text-center">          
            <div class="col-md-12">
                <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="160" height="160">
            </div>
        </div>
    </div>
    <br>    
    <div class="container">
        
        <?php if(!isset($datos[0]->matricula)):?>
          <div class='alert alert-danger text-center' role='alert'>
            <h3><strong>CERTIFICADO NO VÁLIDO...!!!</strong></h3>
          </div>
        <?php endif;?>

        <?php if(isset($datos[0]->matricula)):?>
          <div class="alert alert-success text-center" role="alert">
              <h5><strong>¡ CERTIFICADO VÁLIDO... !!!</strong></h5>
          </div>
          <div class="row">          
              <div class="col-md-12">  
                  <table class="table table-bordered">
                    <tr>
                      <td><span style="font-style: italic; font-weight: bold">DNI</span></td>
                      <td><?php echo $datos[0]->dni; ?></td>
                    </tr>  
                    <tr>
                      <td><span style="font-style: italic; font-weight: bold">Colegiatura</span></td>
                      <td><?php echo $datos[0]->matricula; ?></td>
                    </tr>  
                    <tr>
                      <td><span style="font-style: italic; font-weight: bold">Colegiado</span></td>
                      <td><?php echo $datos[0]->nombre; ?></td>
                    </tr>
                    <tr>
                      <td><span style="font-style: italic; font-weight: bold">Nro.&nbsp;Certificado</span></td>
                      <td><?php echo $datos[0]->numero; ?></td>
                    </tr>
                    <tr>
                      <td><span style="font-style: italic; font-weight: bold">Fecha&nbsp;Emisión</span></td>
                      <td><?php echo $datos[0]->fecha; ?></td>
                    </tr>
                    <tr>
                      <td><span style="font-style: italic; font-weight: bold">Fecha&nbsp;Caducidad</span></td>
                      <td><?php echo $datos[0]->vence; ?></td>
                    </tr>

                  </table>
              </div>    
        
          </div>
          
        <?php endif;?>
        

    </div>


  </body>
</html>
