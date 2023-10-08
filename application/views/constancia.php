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
          <h4>CERTIFICADO DE HABILITACIÓN EN LÍNEA</h4>
        </div>
      </div>

      <?php if(true):?>
      <div class="row">          
          <div class="col-md-12">  
              <table class="table table-bordered">
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">DNI</span></td>
                  <td><?php echo $registro[0]->dni; ?></td>
                </tr>  
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Colegiatura</span></td>
                  <td><?php echo $registro[0]->nummat; ?></td>
                </tr>  
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Colegiado</span></td>
                  <td><?php echo $registro[0]->nombre; ?></td>
                </tr>
                <tr>
                  <td colspan="2" align="center">
                    <?php if($registro[0]->flag=='SI'):?>
                    <div class="alert alert-success" role="alert">
                        <h5>¡En éste momento Ud. se encuentra HÁBIL!!!</h5>
                        <?php echo $registro[0]->hora; ?>
                    </div>
                    <?php endif;?>
                  
                    <?php if($registro[0]->flag=='NO'):?>
                    <div class="alert alert-danger" role="alert">
                        <h5>¡En éste momento Ud. se encuentra NO HÁBIL!!!</h5>
                        <?php echo $registro[0]->hora; ?>
                    </div>
                    <?php endif;?>

                  </td>
                </tr>


              </table>
          </div>    
      </div>
      <?php endif;?>

      <br>

      <div class="row" style="padding: 5px;">
        <div class="col-md-12">
          <small>* Para obtener un CERTIFICADO DE HABILITACIÓN en Línea, primero tiene que hacer el pago correspondiente.</small>
          <input type="hidden" name="id" id="id" value="<?php echo $registro[0]->id; ?>">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div id="detalle_items" align="center"><img src="<?php echo base_url();?>resources/img/loading.gif" width="60" height="60">Cargando...</div>
        </div>
      </div>
    </div>
    <br><br><br><br><br>


  </body>
</html>

<!-- Modal -->
<div class="modal hide fade" id="habilidad" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Certificado de Habilitación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe src="" id="preview_habilidad" width="100%" height="680"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="document.getElementById('preview_habilidad').src='';">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var base_url = "<?php echo base_url();?>";

  function select_option(flag) {
    
    $("#resultado_"+flag).empty();
    $("#matricula_"+flag).val("");

    $("#consulta_"+flag).removeAttr('style');
    $("#consulta_"+!flag).css("display", "none");
    $("#matricula_"+flag).focus();
  }

  $('#matricula_true').keyup(function(e) {
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code==13) {
        $("#resultado_true").empty();
        if(this.value != '') 
          buscar_habilidad();
      }
  });

  function buscar_habilidad() {
    $("#resultado_true").empty();

    matricula = $("#matricula_true").val();

    if(matricula==""){
      alert("Error, ingrese Nro. colegiatura.");
      $("#matricula_true").focus();
      return;
    } 

    var ruta =  base_url + "habilidad/gethabil";
    $.ajax({
      url: ruta,
      data: "codigo="+matricula,
      type: "POST",
      success: function(resp){
        
        $("#resultado_true").empty();
        
        data = JSON.parse(resp);
        
        html="";

        if(data['flag']){

          html+="<div class='row'>";
          html+="<div class='col-md-12'>";
          html+="<table class='table table-bordered'>";
          html+="<tr>";
          html+="<td><span style='font-style: italic; font-weight: bold'>Apellidos y nombres</span></td>";
          html+="<td colspan='5'>"+data['nombre']+"</td>";
          html+="</tr>";
          html+="</table>";
          html+="</div>";
          html+="</div>";

          if(data['habil']){
            html+="<div class='alert alert-success text-center' role='alert'>";
            html+="<h5><strong>¡ HÁBIL hasta el "+data['hasta']+" !!!</strong></h5>";
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

        $("#resultado_true").append(html);
      }
    });     

  }

  function buscar_constancia() {

    matricula = $("#matricula_false").val();
    fnacimiento = $("#fnacimiento").val();
  }

  
  $(function(){
    $('#captcha').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
        });
  });

  function refrescar_img(){
      
      var ruta =  base_url + "habilidad/refresh_captcha";
      $.ajax({
      url: ruta,
      type: "POST",
      success: function(data){
          $("#img_captcha").empty();
          $("#img_captcha").append(data);

          $("#captcha").focus();
      }
      }); 
  }

  function imprimir(id, clave){
    var ruta = "<?php echo base_url();?>" + "habilidad/imprimir/"+id+"/"+clave;
    var PDF = document.getElementById("preview_habilidad");
    PDF.src = ruta;
    $("#habilidad").modal({backdrop: 'static', keyboard: false});
  }

  function nueva_constancia(id){

    if(!confirm("Se va a generar una NUEVA Constancia de Habilidad.")){
      return;
    } 

    var ruta =  base_url + "habilidad/insert";
    $.ajax({
      url: ruta,
      data: "id="+id,
      type: "POST",
      success: function(data){
        if(data != 0)
          alert(data);
        else
          load_detalle();
    }
    });
  }

  function load_detalle(id){

    id = $("#id").val();

    $.ajax({
        url: base_url + "habilidad/getdetalle",
        type: "POST",
        data: "id="+id,
        dataType:"json",
        success: function(resp){
          reg = eval(resp);
          $('#detalle_items').empty();


          html = "<table id='tbdetalle' class='table table-bordered table-striped table-hover' style='font-size:13px;'>";
          html += "<thead>";
          html += "<tr>";
          html += "<th>Nº Constancia</th>";
          html += "<th>Fecha y Hora</th>";
          html += "<th>Recibo</th>";
          html += "<th>Modalidad Pago</th>";
          html += "<th>Estado</th>";
          html += "<th>Opciones</th>";
          html += "</tr>";
          html += "</thead>";
          html += "<tbody>";

          for (var i=0; i < reg.registros.length; i++) {
            html += "<tr>";
            html += "<td>"+reg.registros[i].numero+"</td>";
            html += "<td>"+reg.registros[i].hora_insert+"</td>";
            html += "<td>"+reg.registros[i].recibo+"</td>";
            html += "<td>"+reg.registros[i].desforma+"</td>";
            html += "<td>VIGENTE</td>";
            html += "<td>";
            html += "<div class='form-group'>";

            if(true){
              html += "<span title='Imprimir Certificado' style='cursor: pointer;' onclick=imprimir("+reg.registros[i].id+",'"+reg.registros[i].print+"');>&nbsp;<i class='fa fa-print fa-2x'></i></span>";
            }else{
              html += "<strong>"+reg.registros[i].print+"</strong>";
            }
            
            html += "</div>";
            html += "</td>";
            html += "</tr>";
            
          }


          html += "</tbody>";
          html += "</table>";


          $('#detalle_items').append(html);
        }
    });

  }

  load_detalle();

</script>
