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

    .rojo {
      color: red;
    }

  </style>
</head>
<body>
    <div class="container">

      <div class="row text-center">
        <div class="col-md-12">
          <h4>NUEVO PAGO EN LÍNEA</h4>
        </div>
      </div>

      <div class="row">          

      </div>

      <form action='<?php echo base_url();?>pago/upload' enctype="multipart/form-data" method='POST'>
      <input type="hidden" name="idpago" id="idpago" value="<?php echo $idpago; ?>">
      <div class='row'>
        <div class='col-md-12'>
          <table id="tbarchivos" class="table table-bordered">
            <tr>
                <th colspan="5"><i>Voucher de Depósito (escaneado en PDF ó imágen JPG, PNG)</i></th>
            </tr>
            <tr>
                <th>Voucher</th>
                <th>Archivo <small>(2Mb maximo = 2000Kb)</small></th>
                <th>Observaciones</th>
            </tr>
            <tr>
              <td><small></small>
                  <div style="padding: 5px;"><input type="text" class="form-control text-center" id="voucher_upfile_0" name="voucher_upfile_0" placeholder="Nº Operación" maxlength="8" required></div>
                  <div style="padding: 5px;"><input type="date" class="form-control" id="fecha_upfile_0" name="fecha_upfile_0" placeholder="Fecha" required></div>
                  <div style="padding: 5px;"><input type="text" class="form-control text-right" id="importe_upfile_0" name="importe_upfile_0" placeholder="Importe" required></div>
              </td>
              <td>
                  <label>Tipo archivo: <strong>.pdf, .jpg, .png</strong> <i class="fa fa-file-pdf"></i></label>
                  <div>
                      <input type="file" accept=".pdf,.jpg,.png" id="upfile_0" name="upfile_0" required>
                  </div>
              </td>
              <td>
                  <div id="obs_upfile_0" align="center"><span style="color:red;">Pendiente...!!!</span></div>
                  <div align="center" id="tam_upfile_0"></div>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class='row'>
          <div class='col-md-12' align="center">
              <button type="submit" class='btn btn-success'><i class='fa fa-upload'></i>&nbsp;Subir archivo y Finalizar</button>
          </div>

      </div>


    </form>                  
      



      

     
    </div>
    <br><br><br><br><br>

  </body>
</html>

<script type='text/javascript'>
    var base_url = "<?php echo base_url();?>";

       
    $("input[type=file]").on('change',function(){

        id = $(this).attr('id');

        var sizeByte = this.files[0].size;
        var siezekiloByte = parseInt(sizeByte / 1024);

        if(sizeByte > 2097152){
           alert('El tamaño supera el limite permitido');
           $(this).val("");
           $("#obs_"+id).html("<span style='color:red; font-size:16px; font-weight:bold;'>Pendiente...!!!</span>");
           $("#tam_"+id).html(""); 

           $("#ok_"+id).val("0");
        }else{
           $("#tam_"+id).html("<small>Tamaño: "+siezekiloByte+" Kb</small>");
           $("#obs_"+id).html("<span style='color:green; font-size:16px; font-weight:bold;'>OK...!!!</span>");

           $("#ok_"+id).val("1");
        }
        
    });




</script>
