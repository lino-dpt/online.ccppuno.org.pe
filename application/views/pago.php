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
    <br>
    <div class="container">
      <div class="row text-center">
        <div class="col-md-12">
          <h4>MIS PAGOS EN LÍNEA</h4>
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
                  <td><span style="font-style: italic; font-weight: bold">Nº Colegiatura</span></td>
                  <td><?php echo $registro[0]->nummat; ?></td>
                </tr>  
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Colegiado</span></td>
                  <td><?php echo $registro[0]->nombre; ?></td>
                </tr>
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Última cuota ordinaria</span></td>
                  <td><?php echo $ultimo; ?></td>
                </tr>

              </table>
          </div>    
      </div>
      <?php endif;?>

      <div class="row" style="padding: 5px;">
        <div class="col-md-12">
          
        <small>* Aquí se muestran el estado de todos tus registros de pago mediante depósito en cuentas del CDR XVI Puno que tienen que ser validados.</small>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div id="detalle_pendiente" align="center"><img src="<?php echo base_url();?>resources/img/loading.gif" width="60" height="60">Cargando...</div>
        </div>
      </div>

      <br>
      <div class="row" style="padding: 5px;">
        <div class="col-md-4">
          <a href="<?php echo base_url();?>pago/pagar" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Registrar Pago (Vía Internet)</a>
          <input type="hidden" name="id" id="id" value="<?php echo $registro[0]->id; ?>">
        </div>
        <div class="col-md-3">
          <span style="cursor: pointer; color: blue;" onclick=verpagos(<?php echo $registro[0]->id; ?>); class="fa fa-file-pdf-o ">&nbsp;&nbsp;Descargar todos los pagos (PDF)</span>
        </div>
        <div class="col-md-2">
          <select class="custom-select d-block w-100" name="anio" id="anio" onchange=load_detalle();>
            <option value="">Todos</option>
            <?php foreach($anios as $periodo):?>
                <option value="<?php echo $periodo->idanio; ?>" <?php echo (($periodo->idanio == '2020') ? "selected" : ""); ?> ><?php echo $periodo->idanio; ?></option>
            <?php endforeach;?>
          </select>
        </div>
        <div class="col-md-3">
          <select class="custom-select d-block w-100" name="tipo" id="tipo" onchange=load_detalle();>
            <option value="" selected>Todos</option>
            <option value="INTERNET">Efectivo</option>
            <option value="INTERNET">POS</option>
            <option value="INTERNET">Tarjeta (Internet)</option>
            <option value="INTERNET">Depósito en Cuenta</option>
          </select>
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
<div class="modal hide fade" id="pago" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe src="" id="preview_pago" width="100%" height="680"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="document.getElementById('preview_pago').src='';">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var base_url = "<?php echo base_url();?>";

  /*function select_option(flag) {
    
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
  });*/

  /*function buscar_habilidad() {
    $("#resultado_true").empty();

    matricula = $("#matricula_true").val();

    if(matricula==""){
      alert("Error, ingrese Nro. matrícula.");
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

  }*/

 /* $(function(){
    $('#captcha').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
        });
  });*/

  /*function refrescar_img(){
      
      var ruta =  base_url + "pago/refresh_captcha";
      $.ajax({
      url: ruta,
      type: "POST",
      success: function(data){
          $("#img_captcha").empty();
          $("#img_captcha").append(data);

          $("#captcha").focus();
      }
      }); 
  }*/

  function imprimir(id, clave){
    var ruta = "<?php echo base_url();?>" + "pago/imprimir/"+id+"/"+clave;
    var PDF = document.getElementById("preview_pago");
    PDF.src = ruta;
    $("#pago").modal({backdrop: 'static', keyboard: false});
  }

 /* function nueva_constancia(id){

    if(!confirm("Se va a generar una NUEVA Constancia de Habilidad.")){
      return;
    } 

    var ruta =  base_url + "pago/insert";
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
  }*/

  function load_pendiente(){

    id = $("#id").val();

    $.ajax({
        url: base_url + "pago/getpendiente",
        type: "POST",
        data: "id="+id,
        dataType:"json",
        success: function(resp){
          reg = eval(resp);
          $('#detalle_pendiente').empty();
          html = "<table id='tbdetalle' class='table table-bordered' style='font-size:13px;'>";
          html += "<thead>";
          html += "<tr>";
          html += "<th>Nº</th>";
          html += "<th>ID</th>";
          html += "<th>Fecha y Hora</th>";
          html += "<th>Importe (S/)</th>";
          html += "<th>Estado</th>";
          html += "<th>Observación</th>";
          html += "<th>Opciones</th>";
          html += "</tr>";
          html += "</thead>";
          html += "<tbody>";

          for (var i=0; i < reg.registros.length; i++) {
            html += "<tr>";
            html += "<td>"+(i+1)+"</td>";
            html += "<td>"+reg.registros[i].id+"</td>";
            html += "<td>"+reg.registros[i].hora+"</td>";
            html += "<td>"+reg.registros[i].total+"</td>";
            html += "<td>PENDIENTE</td>";
            html += "<td></td>";
            html += "<td>";
            html += "&nbsp;<a style='color:red;' title='Anular' href='#' onclick=eliminar("+reg.registros[i].id+");>&nbsp;<i class='fa fa-times fa-2x'></i></a>";
            html += "</td>";
            html += "</tr>";
          }

          html += "</tbody>";
          html += "</table>";


          $('#detalle_pendiente').append(html);
        }
    });

  }

  function eliminar(id){
    if(!confirm("Esta seguro que desea ELIMINAR el registro de pago?")) return;

    $.ajax({
        url: base_url + "pago/declinarpago",
        type: "POST",
        data: "id="+id,
        success: function(resp){
          
          load_pendiente();
          
        }
    });

  }


  function load_detalle(){

    id = $("#id").val();
    anio = $("#anio").val();
    tipo = $("#tipo").val();

    $.ajax({
        url: base_url + "pago/getdetalle",
        type: "POST",
        data: "id="+id+"&anio="+anio+"&tipo="+tipo,
        dataType:"json",
        success: function(resp){
          reg = eval(resp);
          $('#detalle_items').empty();


          html = "<table id='tbdetalle' class='table table-bordered table-striped table-hover' style='font-size:13px;'>";
          html += "<thead>";
          html += "<tr>";
          html += "<th>Año</th>";
          html += "<th>Número</th>";
          html += "<th>Fecha</th>";
          html += "<th>Importe (S/)</th>";
          html += "<th>Forma Pago.</th>";
          html += "<th>Obs.</th>";
          html += "<th>Opciones</th>";
          html += "</tr>";
          html += "</thead>";
          html += "<tbody>";

          total = 0.00;
          for (var i=0; i < reg.registros.length; i++) {
            html += "<tr>";
            html += "<td>"+reg.registros[i].anio+"</td>";
            html += "<td>"+reg.registros[i].numero+"</td>";
            html += "<td>"+reg.registros[i].fecha+"</td>";
            html += "<td>"+reg.registros[i].importe+"</td>";
            html += "<td>"+reg.registros[i].desforma+"</td>";
            html += "<td></td>";
            html += "<td>";
            html += "<div class='form-group'>";

            //if(reg.registros[i].print!=''){
              html += "<span title='Imprimir' style='cursor: pointer;' onclick=imprimir("+reg.registros[i].id+",'"+reg.registros[i].print+"');>&nbsp;<i class='fa fa-print fa-2x'></i></span>";
            //}
            
            html += "</div>";
            html += "</td>";
            html += "</tr>";
            
            total += parseFloat(reg.registros[i].importe);
          }

          html += "<tr>";
          html += "<td colspan=5 align='right'><h5>TOTAL S/.</h5></td>";
          html += "<td colspan=2 align='center'><h5>"+total.toFixed(2)+"</h5></td>";
          html += "</tr>";

          html += "</tbody>";
          html += "</table>";


          $('#detalle_items').append(html);
        }
    });

  }

  function verpagos(id){
    
      var ruta = "<?php echo base_url();?>" + "agremiado/historialpagos/"+id;

      window.open(ruta,'_blank');
           
  }

  load_pendiente();
  load_detalle();

</script>
