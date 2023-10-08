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

</head>
<body>
    <div class="container">
      <?php if($estado=='SI'):?>
        <?php if($datos[0]->idformato=='1'):?>
          <div class="container">
              <div class="row text-center">          
                  <div class="col-md-12">
                      <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="140" height="140">
                  </div>
              </div>
          </div>
          <br>    

          <div class="alert alert-success text-center" role="alert">
              <h5><strong>¡ CERTIFICADO VÁLIDO !!!</strong></h5>
          </div>

          <div class="row">          
              <div class="col-md-12">  
                <table class="table table-bordered">
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Registro</span></td>
                        <td><?php echo $datos[0]->reg; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Emisión</span></td>
                        <td colspan="5"><?php echo $datos[0]->fecha; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Otorgado a</span></td>
                        <td colspan="5"><?php echo $datos[0]->nombre; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Por haber</span></td>
                        <td colspan="5"><?php echo $datos[0]->obsrol . ' ' . $datos[0]->destipo; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Denominación</span></td>
                        <td colspan="5"><?php echo $datos[0]->descurso; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Detalle</span></td>
                        <td colspan="5"><?php echo $datos[0]->detalle; ?></td>
                    </tr>

                </table>
              </div>    
          </div>
        <?php endif;?>

        <?php if($datos[0]->idformato=='2'):?>
          <div class="container">
              <div class="row text-center">          
                  <div class="col-md-12">
                      <img src="<?php echo base_url();?>resources/img/logo_junta.jpg" alt="" width="160" height="160">
                  </div>
              </div>
          </div>
          <br>    
          
          <div class="alert alert-success text-center" role="alert">
              <h5><strong>¡ DIPLOMA VÁLIDO !!!</strong></h5>
          </div>

          <div class="row">          
              <div class="col-md-12">  
                <table class="table table-bordered">
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Registro</span></td>
                        <td><?php echo $datos[0]->reg; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Fecha Emisión</span></td>
                        <td colspan="5"><?php echo $datos[0]->lugar_fecha; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Otorgado a</span></td>
                        <td colspan="5"><?php echo $datos[0]->nombre; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Por haber</span></td>
                        <td colspan="5"><?php echo $datos[0]->obsrol . ' ' . $datos[0]->destipo; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Denominación</span></td>
                        <td colspan="5"><?php echo $datos[0]->descurso; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Horas</span></td>
                        <td colspan="5"><?php echo $datos[0]->totalhoras; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-style: italic; font-weight: bold">Detalle</span></td>
                        <td colspan="5"><?php echo $datos[0]->detalle; ?></td>
                    </tr>

                </table>
              </div>    
          </div>
        <?php endif;?>
      <?php endif;?>

      <?php if($estado=='NO'):?>
      <div class="container">
          <div class="row text-center">          
              <div class="col-md-12">
                  <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="140" height="140">
              </div>
          </div>
      </div>
      <br>    

      <div class="alert alert-danger text-center" role="alert">
          <h5><strong>¡ NO VÁLIDO !!!</strong></h5>
      </div>
      <?php endif;?>
       
    
    </div>
  </body>
</html>
