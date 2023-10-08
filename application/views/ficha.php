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
                <img src="<?php echo base_url();?>resources/img/portada.jpg" alt="" width="100%" height="380">
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <span class="enlace" onclick="window.location.href = 'https://ccppuno.org/'"><img src="<?php echo base_url();?>resources/img/casa.png" width="30" height="30">&nbsp;&nbsp;Ir al Portal Web</span>
          </div>
        </div>

        <br>

        <?php if(isset($flag_registro)):?>
          <div class="alert alert-success text-center" role="alert">
              <h5><strong>¡ REGISTRO REALIZADO CON ÉXITO !!!</strong></h5>
          </div>
          <span>Imprima los siguientes documentos (Solicitud y Ficha de Matrícula), luego escanee ambos en UN SOLO ARCHIVO (es decir un archivo PDF con dos páginas ) en formato PDF y dicho archivo lo adjunta en el TRÁMITE VIRTUAL conjuntamente con todos los requisitos para la inscripción.</span>
          <br>
        <?php endif;?>
        <?php if(!isset($flag_registro)):?>
          <div class='alert alert-danger text-center' role='alert'>
            <h5><strong>¡ERROR, REGISTRO NO VÁLIDO...!!!</strong></h5>
          </div>
        <?php endif;?>
        <br>
        <div class="row">          
            <div class="col-md-12">  
                <table class="table table-bordered">
                  <tr>
                    <td><span style="font-style: italic; font-weight: bold">Solicitud de Ingreso</span></td>
                    <td align="center"><button type="button" class="btn btn-info btn-block" onclick=imprimir_solicitud("<?php echo $registro; ?>");><span class="fa fa fa-print"></span>&nbsp;Imprimir Solicitud</button></td>
                    <td>Imprimir, firmar (lapicero azul), poner huella dactilar luego escanear en formato PDF</td>
                  </tr>  

                  <tr>
                    <td><span style="font-style: italic; font-weight: bold">Ficha de Matrícula</span></td>
                    <td align="center"><button type="button" class="btn btn-info btn-block" onclick=imprimir_ficha("<?php echo $registro; ?>");><span class="fa fa fa-print"></span>&nbsp;Imprimir Ficha</button></td>
                    <td>Imprimir, firmar (lapicero azul) y luego escanear en formato PDF</td>
                  </tr>  

                </table>
            </div>    
        </div>


        <br>
        <div class="row" id="imprimir" style="display: none;">
          <div class="col-md-12">                
            <iframe src="" id="preview" style="height:800px;width:100%;"></iframe>
          </div>
        </div>
    </div>

    <br><br><br><br>

    <div style="background: #0a3080; padding: 30px;">
      <div class="container">
        <img src="<?php echo base_url();?>resources/img/logo-white.png" alt="" width="280" height="100">
        
        <hr style="border-top: 1px solid #ccc;">
        <small style="color: #fff;">© 2020 Colegio de Contadores Públicos de Puno.</small>
      </div>
    </div>
        
  </body>
</html>

  <script>
    var base_url = "<?php echo base_url();?>";
    var id_ficha = "<?php echo $registro; ?>";
    var flag_registro = "<?php echo (isset($flag_registro)?"SI":"NO"); ?>";
    
    // Imprimir PDF 
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    function imprimir_solicitud(id){
      url = base_url + "registro/imprimir_solicitud/"+id;
      var PDF = document.getElementById("preview");
      PDF.src = url;
      $("#imprimir").show();
    }

    function imprimir_ficha(id){
      url = base_url + "registro/imprimir_ficha/"+id;
      var PDF = document.getElementById("preview");
      PDF.src = url;
      $("#imprimir").show();
    }

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //if(flag_registro=='SI')
      //imprimir_solicitud(id_ficha);
  </script>
