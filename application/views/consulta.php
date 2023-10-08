<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CCP PUNO ONLINE</title>
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
    <br><br><br>
    <div class="container">
        <div class="row text-center">          
            <div class="col-md-12">
                <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="280" height="280">
            </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <span class="enlace" onclick="window.location.href = 'https://ccppuno.org.pe/'"><img src="<?php echo base_url();?>resources/img/regresar.png" width="30" height="30">&nbsp;&nbsp;Ir al portal web www.ccppuno.org.pe</span>
          </div>
          <div class="col-md-4"></div>
        </div>
    </div>
    <br><br>
   
    <div class="container">
      <div id="consulta">
        <div class='row text-center'>
          <div class='col-md-12'>
            <h4>CONSULTA DE HABILITACIÓN</h4>
          </div>
        </div>
        <br>
        <div class='row'>
          <div class='col-md-3'></div>
          <div class='col-md-3'>
            <div class='form-group'>
              <label for="codigo">Nº Colegiatura ó DNI:</label>
              <input type='text' class='form-control text-center' placeholder='Nº Colegiatura ó DNI' name='matricula' id='matricula' maxlength='11' value="" autofocus>
            </div>
          </div>
          <div class='col-md-3'>
            <div class='form-group'>
              <br>
              <button style="padding: 12px;" type='button' id='btn' class='btn btn-success btn-flat' onclick=buscar_habilidad()><span class='fa fa-search'></span> Consultar HABILITACIÓN</button>
            </div>
          </div>
          <div class='col-md-3'></div>
          </div>
        </div>
        <div id="resultado"></div>

        <br>

    </div>

    <br><br><br><br>

    <div style="background: #fff; padding: 30px;">
      <div class="container">
        <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="110" height="110">
        
        <hr style="border-top: 1px solid #ccc;">
        <small style="color: #24387c;">© Colegio de Contadores Públicos de Puno.</small>
      </div>
    </div>

  </body>
</html>

<script type="text/javascript">
  var base_url = "<?php echo base_url();?>";

  $("#matricula").keypress(function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code==13) {
      buscar_habilidad();
    }
  });

  function buscar_habilidad() {
    
    $("#resultado").empty();

    matricula = $("#matricula").val();

    if(matricula==""){
      alert("Error, ingrese Nro. matrícula.");
      $("#matricula").focus();
      return;
    } 

    var ruta =  base_url + "habilidad/gethabil";
    $.ajax({
      url: ruta,
      data: "codigo="+matricula,
      type: "POST",
      success: function(resp){
        
        $("#resultado").empty();
        
        data = JSON.parse(resp);
        
        html="";

        if(data['flag']){

          html+="<div class='row'>";
          html+="<div class='col-md-12'>";
          html+="<table class='table table-bordered'>";
          html+="<tr>";
          html+="<td><span style='font-style: italic; font-weight: bold'>Nº Colegiatura</span></td>";
          html+="<td>"+data['matricula']+"</td>";
          html+="<td rowspan='6' align='center'><img src='"+base_url+"files/fotos/"+((data['flag_subirfoto']=='F')?data['matricula']+'.jpg':'sinfoto.png')+"' alt='' width='160' height='200'></td>";
          html+="</tr>";
          html+="<tr>";
          html+="<td><span style='font-style: italic; font-weight: bold'>Primer Apellido</span></td>";
          html+="<td>"+data['paterno']+"</td>";
          html+="</tr>";
          html+="<tr>";
          html+="<td><span style='font-style: italic; font-weight: bold'>Segundo Apellido</span></td>";
          html+="<td>"+data['materno']+"</td>";
          html+="</tr>";
          html+="<tr>";
          html+="<td><span style='font-style: italic; font-weight: bold'>Nombre(s)</span></td>";
          html+="<td>"+data['nombres']+"</td>";
          html+="</tr>";

          html+="</table>";
          html+="</div>";
          html+="</div>";

          if(data['habil']){
            html+="<div class='alert alert-success text-center' role='alert'>";
            html+="<h5><strong>¡ HÁBIL hasta "+data['hasta']+" !!!</strong></h5>";
            html+="</div>";
          }else{
            html+="<div class='alert alert-danger text-center' role='alert'>";
            html+="<h5><strong>¡ NO HÁBIL !!!</strong></h5>";
            html+="</div>";
          }
        }else{
            html+="<div class='alert alert-danger text-center' role='alert'>";
            html+="<h5><strong>¡ ERROR, no existe Colegiados con el código ingresado !!!</strong></h5>";
            html+="</div>";
        }

        $("#resultado").append(html);
      }
    });     

  }

</script>
