<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CCP EN LINEA</title>

    <link rel="icon" href="<?php echo base_url();?>resources/img/logo.png" type="image/png" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url();?>resources/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resources/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resources/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo base_url();?>resources/js/jquery.js"></script>
    <script src="<?php echo base_url();?>resources/jquery-ui/jquery-ui.js"></script>
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

        <form action='<?php echo base_url();?>agremiado/upload' enctype="multipart/form-data" method='POST'>
        <div id="form_registro">
        <div class='alert alert-primary' style="background: #0a3080; padding: 10px; color: #fff;" role='alert'>SUBIR ARCHIVO</div>

        <div class='row'>
            <div class='col-md-12'>
              <table id="tbpagos" class="table table-bordered">
                <tr>
                    <th colspan="2">Denominación</th>
                    <th>Archivo <small>(2Mb maximo = 2000Kb)</small></th>
                    <th>Observaciones</th>
                </tr>
                <tr>
                    <td colspan="2">Foto a color tamaño carnet</td>
                    <td>
                        <label>Tipo archivo: <strong>.jpg, .png</strong></label>
                        <div>
                            <input type="file" accept=".jpg,.png" id="upfile" name="upfile" required>
                        </div>
                    </td>
                    <td>
                        <div id="obs_upfile" align="center"><span style="color:red; font-size:16px; font-weight:bold;">Pendiente...!!!</span></div>
                        <div align="center" id="tam_upfile"></div>
                    </td>
                </tr>
                


                        
              </table>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-12' align="center"><div id="subiendo" style="display: none;"><img src="<?php echo base_url();?>resources/img/loading.gif" width="50" height="50">Espere por favor, subiendo archivos...</div></div>
        </div>    
        <br>
        <div class='row'>
            <div class='col-md-4' align="right"></div>
            <div class='col-md-4' align="right">
                <button type="submit" class='btn btn-success btn-block' id="btn_submit"><i class='fa fa-upload'></i>&nbsp;Subir Archivo</button>
            </div>
            <div class='col-md-4' align="right"></div>
        </div>


        </div>   
        </form>


    </div>

    <br><br><br><br>

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

    $("#btn_submits").on('click',function(){
        
        $("#subiendo").show();
        $("input[type=file]").attr("disabled","disabled");
        $("#btn_submit").attr("disabled","disabled");
        
    });



</script>

