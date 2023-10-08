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
    </div>
    <br><br>
   
    <div class="container">
      <div id="consulta">
        <div class='row'>
          <div class='col-md-3'></div>
          <div class='col-md-3'>
            <div class='form-group'>
              <label for="codigo">Nº DNI:</label>
              <input type='text' class='form-control text-center' placeholder='Nº DNI' name='dni' id='dni' maxlength='8' value="" autofocus>
            </div>
          </div>
          <div class='col-md-3'>
            <div class='form-group'>
              <br>
              <button style="padding: 12px;" type='button' id='btn' class='btn btn-success btn-flat' onclick=registrar_asistencia()><span class='fa fa-search'></span> Registrar ASISTENCIA</button>
            </div>
          </div>
          <div class='col-md-3'></div>
          </div>
        </div>
        <div id="resultado"></div>

        <br>

    </div>

   </body>
</html>

<script type="text/javascript">
  var base_url = "<?php echo base_url();?>";

  $("#dni").keypress(function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code==13) {
      registrar_asistencia();
    }
  });

  function registrar_asistencia() {
    
    $("#resultado").empty();

    dni = $("#dni").val();

    if(dni==""){
      alert("Error, ingrese Nro. DNI.");
      $("#dni").focus();
      return;
    } 

    var ruta =  base_url + "asistencia/gethabil_dni";
    $.ajax({
      url: ruta,
      data: "codigo="+dni,
      type: "POST",
      success: function(resp){
        
        $("#resultado").empty();
        
        data = JSON.parse(resp);
        
        html="";

        if(data['flag']){
          html+="<div class='row'>";
          html+="<div class='col-md-12'>";
          html+="</div>";
          html+="</div>";

          if(data['registrado']){
            html+="<div class='alert alert-danger text-center' role='alert'>";
            html+="<h6><strong>"+data['nombre']+"</strong></h6>";            
            html+="<h5><strong>¡ YA REGISTRO SU ASISTENCIA "+data['fecha_hora']+" !!!</strong></h5>";
            html+="</div>";

          }else{
              if(data['habil']){
                html+="<div class='alert alert-success text-center' role='alert'>";
                html+="<h5><strong>Se ha registrado la asistencia de:</strong></h5>";
                html+="<h5><strong>"+data['nombre']+"</strong></h5>";

                html+="</div>";
              }else{
                html+="<div class='alert alert-danger text-center' role='alert'>";
                html+="<h6><strong>"+data['nombre']+"</strong></h6>";            
                html+="<h5><strong>¡ NO HÁBIL !!!</strong></h5>";
                html+="</div>";
              }
          }
        }else{
            html+="<div class='alert alert-danger text-center' role='alert'>";
            html+="<h5><strong>¡ ERROR, no existe Colegiado con el DNI ingresado !!!</strong></h5>";
            html+="</div>";
        }

        $("#resultado").append(html);

        $("#dni").val("");
        $("#dni").focus();
      }
    });     

  }

</script>
