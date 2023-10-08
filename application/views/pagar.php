<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CDR XVI ONLINE</title>
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
        <div class="col-md-2" style="padding: 6px;">
         <span style="cursor:pointer; padding: 10px;" onclick="window.location.href = '<?php echo base_url();?>pago'"><img src="<?php echo base_url();?>resources/img/regresar.png" width="20" height="20">&nbsp;&nbsp;Regresar</span>
        </div>
      </div>

      <?php if(true):?>
      <div class="row">          
          <div class="col-md-12">  
              <input type="hidden" name="idcliente" id="idcliente" value="<?php echo $registro[0]->id; ?>">
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
                  <td><span style="font-style: italic; font-weight: bold">Última cuota ordinaria</span></td>
                  <td><?php echo $ultimo; ?></td>
                </tr>
              </table>
          </div>    
      </div>
      <?php endif;?>
      
      <div class="row">          
        <div class="col-md-7">  
          <label><span class="rojo">(*)</span> Conceptos de Pago (puede agregar uno o más conceptos) :</label>
          <input type="hidden" name="id_concepto=" id="id_concepto" value="">
          <input type="hidden" name="des_concepto=" id="des_concepto" value="">
          <select class="custom-select d-block w-100" name="idconcepto" id="idconcepto" style="font-size:18px; font-weight: bold;" autofocus onchange=sel_concepto();>
            <option value="">Seleccione...</option>
            <?php foreach($conceptos as $concepto):?>
                <option value="<?php echo $concepto->idconcepto; ?>"><?php echo $concepto->desconcepto; ?></option>
            <?php endforeach;?>
          </select>
        </div>  

        <div class="col-md-3">
          <div class="row" id="cantidades">
            <div class="form-group">
              <label>Cantidad :</label>
              <input type="hidden" name="precio" id="precio" value="">
              <input type="number" class="form-control text-center" style="font-size:20px; font-weight: bold;" name="cantidad" id="cantidad" value="" disabled>
            </div>
          </div>
          <div class="row" id="cuotas" style="display: none;">
            <div class="form-group">
              <select class="custom-select" name="anio" id="anio" size="5" style="width:120px" onchange=calcular_cuota();>
                <option value="2021">2023</option>
                <option value="2021">2022</option>
                <option value="2020" selected>2021</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
              </select>
            </div>
            &nbsp;
            <div class="form-group">
              <select class="custom-select" name="mes" id="mes" multiple size="5" style="width:160px" onchange=calcular_cuota();>
                <?php foreach($meses as $mes):?>
                    <option value="<?php echo $mes->idmes; ?>"><?php echo $mes->desmes; ?></option>
                <?php endforeach;?>
              </select>
            </div>

            <div class="form-group">
              <input type="hidden" name="precio" id="precio" value="">
              <input type="text" class="form-control text-center" style="font-size:18px; font-weight: bold;" name="importe" id="importe" value="0.00" readonly>
            </div>

          </div>
        </div>    
        <div class="col-md-2">
            <div class="form-group">
                <label>.</label>
                <button id="btn-agregar" type="button" class="btn btn-success btn-block" style="font-size:18px; font-weight: bold; padding: 7px" value="" disabled><span class="fa fa-plus"></span> Agregar</button>    
            </div>
        </div>
      </div>      
     

      <div class="row">
        <div class="col-md-12">
          <div id="detalle_items">
          <table id="tbpagos" class="table table-bordered table-striped table-hover">
              <thead>
                  <th>Denominación</th>
                  <th>Precio Unit. (S/)</th>
                  <th>Cantidad</th>
                  <th>Importe (S/)</th>
                  <th>&nbsp;</th>
              </thead>
              <tbody>
              </tbody>
          </table>
          </div>    
        </div>
      </div>

      <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-4 text-right" style="padding: 5px;"><span class="rojo">(**)</span><strong> Total (pago depósito en cuenta) S/</strong></div>
          <div class="col-md-3" style="padding: 2px;">
              <input type="text" class="form-control text-right" style="font-size:16px; font-weight: bold;" name="total1" id="total1" value="0.00" readonly="readonly" >
          </div>
          <div class="col-md-3">
            <button id="btn-pagar-deposito" type="button" class="btn btn-primary btn-block" style="font-size:16px; font-weight: bold; padding: 7px" value=""><span class="fa fa-file-text"></span>&nbsp;&nbsp;Registrar Pago (Depósito)</button>
          </div>

      </div>

      <br>
      <small>* Para pagar cuotas ordinarias mensuales, puede elejir uno o más meses (presionando la tecla Control + Click ó haciendo Click y arrastrando el mouse). </small>
      <br>
      <small>** En ésta modalidad, Ud. ya debe de tener los vouchers de depósito escaneados los mismos que serán validados con la entidad bancaria correspondiente (24 horas)</small>
      <br>

      <!-- Incluyendo Culqi Checkout -->
      <script src="https://checkout.culqi.com/js/v3"></script>

      <script>
        Culqi.publicKey = 'pk_test_VsqiAHh9viaxuRFd';
      </script>

      <script>
        
        Culqi.options({
            style: {
              logo: 'https://online.ccppuno.org/logo-ccpp.png',
              maincolor: '#ff0000',
              buttontext: '#ffffff',
              maintext: '#4A4A4A',
              desctext: '#4A4A4A'
            }
        });
  
      </script>



      

     
    </div>
    <br><br><br><br><br>

  </body>
</html>

<!-- Modal -->
<div class="modal hide fade" id="adjuntar" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Adjuntar Voucher de Depósito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action='<?php echo base_url();?>pago_deposito/upload' enctype="multipart/form-data" method='POST'>
        <div class='row'>
          <div class='col-md-12'>
            <table id="tbarchivos" class="table table-bordered">
              <tr>
                  <th colspan="5"><i>Voucher de Depósito (escaneado en PDF ó imágen JPG, PNG)</i></th>
              </tr>
              <tr>
                  <th>Voucher</th>
                  <th>Archivo</th>
                  <th>2Mb máx.</th>
              </tr>
              <tr>
                <td><small></small>

                    <div style="padding: 5px;"><input type="text" class="form-control text-center" id="voucher_upfile_" name="voucher_upfile_" placeholder="Nº Operación" maxlength="8" required></div>
                    <div style="padding: 5px;"><input type="date" class="form-control" id="fecha_upfile_" name="fecha_upfile_" placeholder="Fecha" required></div>
                    <div style="padding: 5px;"><input type="text" class="form-control text-right" id="importe_upfile_" name="importe_upfile_" placeholder="Importe" required></div>

                </td>

                  <td>
                      <label>Tipo archivo: <strong>.pdf, .jpg, .png</strong> <i class="fa fa-file-pdf"></i></label>
                      <div>
                          <input type="file" accept=".pdf" id="upfile_0" name="upfile_0" required>
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
                <button type="submit" class='btn btn-success'><i class='fa fa-upload'></i>&nbsp;Subir archivos y Finalizar</button>
            </div>

        </div>


      </form>                  




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="document.getElementById('preview_habilidad').src='';">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var base_url = "<?php echo base_url();?>";

 
  function imprimir(id, clave){
    var ruta = "<?php echo base_url();?>" + "habilidad/imprimir/"+id+"/"+clave;
    var PDF = document.getElementById("preview_habilidad");
    PDF.src = ruta;
    $("#habilidad").modal({backdrop: 'static', keyboard: false});
  }

  $(document).on("click", ".btn-remove-item", function(){
    $(this).closest("tr").remove();
    sumar();
    //if($("#total").val() <= 0){
        
        //document.getElementById("btguadar").disabled = true;
    //}    

    $("#idconcepto").focus();
  }); 


  function sumar(){
    total = 0;
    $("#detalle_items table tbody tr").each(function(){
      total += Number($(this).find("td:eq(3)").children("input").val());
    });

    $("input[name=total1]").val(total.toFixed(2));

    tipo_cambio = 3.266;
    
    comision_variable = parseFloat(total*0.042);
    comision_fija = parseFloat(0.30*tipo_cambio);
    comision_variable = comision_variable.toFixed(2);
    comision_fija = comision_fija.toFixed(2);

    comision_ = parseFloat(comision_variable) + parseFloat(comision_fija);

    igv = comision_*0.18;
    igv = igv.toFixed(2);

    comision = parseFloat(comision_) + parseFloat(igv);

    importe_total = parseInt((total+comision)*100);

    $("input[name=total2]").val(comision.toFixed(2));
    $("input[name=total3]").val((total + comision).toFixed(2));

    Culqi.settings({
      title: 'Colegio de Contadores',
      currency: 'PEN',
      description: 'Pago de cuotas ordinarias.',
      amount: importe_total
    });


  }


  $('#btn-pagar-deposito').on('click', function(e) {


      //$("#adjuntar").modal("show");
      
      var total = $("#total1").val();
      
      if(total <= 0){
        alert("Error, por favor agregue los conceptos de Pago.");
        $("#idconcepto").focus();        
        return;
      }

      var idcliente = $("#idcliente").val();

      var _idprod = new Array();      
      $("input[class=_idprod]").each(function(){
          _idprod.push($(this).val());
      })
      var _prec = new Array();      
      $("input[class=_prec]").each(function(){
          _prec.push($(this).val());
      })
      var _cant = new Array();      
      $("input[class=_cant]").each(function(){
          _cant.push($(this).val());
      })
      var _cuot = new Array();      
      $("input[class=_cuot]").each(function(){
          _cuot.push($(this).val());
      })

      $.ajax({
        url: base_url + "pago/cargo_deposito",
        type: "POST",
        async: true,
        data: "total="+total+"&idcliente="+idcliente+"&idprod="+JSON.stringify(_idprod)+"&prec="+JSON.stringify(_prec)+"&cant="+JSON.stringify(_cant)+"&cuot="+JSON.stringify(_cuot),
        success: function(resp){
          window.location.href = base_url + "pago/attach/"+resp;  

        }
      });
      

  });


  $('#btn-pagar-tarjeta').on('click', function(e) {
      var total = $("#total3").val();
      
      if(total <= 0){
        alert("Error, por favor agregue los conceptos de Pago.");
        $("#idconcepto").focus();        
        return;
      }
      

      // Abre el formulario con la configuración en Culqi.settings
      Culqi.open();
      e.preventDefault();
  });

  function culqi() {
    if (Culqi.token) { // ¡Objeto Token creado exitosamente!
      var token = Culqi.token.id;
      var email = Culqi.token.email;
      var total = $("#total3").val();
      var idcliente = $("#idcliente").val();


      //alert('Se ha creado un tokencito :' + token);

      //En esta linea de codigo debemos enviar el "Culqi.token.id"
      //hacia tu servidor con Ajax

      var _idprod = new Array();      
      $("input[class=_idprod]").each(function(){
          _idprod.push($(this).val());
      })
      var _prec = new Array();      
      $("input[class=_prec]").each(function(){
          _prec.push($(this).val());
      })
      var _cant = new Array();      
      $("input[class=_cant]").each(function(){
          _cant.push($(this).val());
      })
      var _cuot = new Array();      
      $("input[class=_cuota]").each(function(){
          _cuot.push($(this).val());
      })

      $.ajax({
        url: base_url + "pago/cargo",
        type: "POST",
        data: "token="+token+"&total="+total+"&email="+email+"&idcliente="+idcliente+"&idprod="+JSON.stringify(_idprod)+"&prec="+JSON.stringify(_prec)+"&cant="+JSON.stringify(_cant)+"&cuot="+JSON.stringify(_cuot),
        success: function(resp){
          alert("El pago se ha realizado con EXITO.");
          window.location.href = base_url + "pago/login";  
        }
      });


    } else { // ¡Hubo algún problema!
        // Mostramos JSON de objeto error en consola
        console.log(Culqi.error);
        alert(Culqi.error.user_message);
    }
  };


  function sel_concepto() {
    
    cadena = $("#idconcepto").val();
    var_array = cadena.split("*");

    idconcepto = var_array[0];
    desconcepto = var_array[1];
    precio = var_array[2];

    $("#id_concepto").val(idconcepto);
    $("#des_concepto").val(desconcepto);
    $("#precio").val(precio);

    if(idconcepto == '0'){
        $("#cuotas").show();
        $("#cantidades").hide();
        
        document.getElementById("btn-agregar").disabled = false;

        $("#anio").val("2020");  
        $("#mes").val("");  
        $("#anio").focus();

    }else{
      $("#cuotas").hide();
      $("#cantidades").show();

      $("#cantidad").val(1);
      document.getElementById("cantidad").disabled = false;
      document.getElementById("btn-agregar").disabled = false;
      $("#btn-agregar").focus();
    }
    
    
  }

  $("#btn-agregar").on("click",function(){
    
    idconcepto = $("#id_concepto").val();

    cadena = "";
    flag_habil = false;

    if(idconcepto == '0'){
      meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"];
      anio = $("#anio").val();
      cadena = anio+'-'+$("#mes").val().toString();
      selectedMes = cadena.split(',');

      cantidad = selectedMes.length;
      precio = parseFloat($("#precio").val());

      detalle = (cantidad > 1 ? meses[0]+"-"+meses[cantidad-1]+" de "+anio + "." : meses[0] +" de "+anio + ".");

      desconcepto = $("#des_concepto").val() + ': ' + detalle;

    }else{

      if(idconcepto == '5'){
        var idcliente = $("#idcliente").val();
        $.ajax({
          url: base_url + "habilidad/gethabil_id",
          type: "POST",
          async: false,
          data: "id="+idcliente,
          success: function(resp){
            data = JSON.parse(resp);
            flag_habil = data['flag'];
          }
        });
      }

      /*if(!flag_habil){
        alert("Error, NO podermos otorgarle una constancia de Habildiad, \n Ud. NO se encuenta hábil, regularice sus cuotas ordinarias.");
        $("#cantidad").val("");
        $("#precio").val("");
        $("#idconcepto").val("");
        $("#id_concepto").val("");
        $("#des_concepto").val("");
        $("#idconcepto").focus();

        return;
      }*/

      desconcepto = $("#des_concepto").val();
      cantidad = $("#cantidad").val();
      precio = parseFloat($("#precio").val());
      
      if(cantidad <= 0){
        alert("Ingrese la cantidad mayor a cero.");
        $("#cantidad").focus();  
        return;
      }

    }
    
    subtotal = cantidad*precio;

    html = "<tr>";
    html += "<td><input type='hidden' name='idprod[]' value='"+idconcepto+"' class='_idprod'><input type='hidden' name='cuot[]' value='"+cadena+"' class='_cuot'>"+desconcepto+"</td>";
    html += "<td><input type='hidden' name='prec[]' value='"+precio.toFixed(2)+"' class='_prec'><input type='text' class='form-control text-right' name='preci' value='"+precio.toFixed(2)+"' readonly></td>";
    html += "<td><input type='hidden' name='cant[]' value='"+cantidad+"' class='_cant'><input type='text' class='form-control text-center cant' name='canti' value='"+cantidad+"' readonly></td>";
    html += "<td><input type='text' class='form-control text-right' value='"+subtotal.toFixed(2)+"' readonly></td>";
    html += "<td><button id='btn-remove' type='button' class='btn btn-danger btn-remove-item'><i class='fa fa-times' aria-hidden='true'></i></button></td>";
    html += "</tr>";

    $("#tbpagos tbody").append(html);
    sumar();

    $("#anio").val("");
    $("#mes").val("");
    $("#importe").val("");

    $("#cantidad").val("");
    $("#precio").val("");
    $("#idconcepto").val("");
    $("#id_concepto").val("");
    $("#des_concepto").val("");

    document.getElementById("btn-agregar").disabled = true;
    document.getElementById("cantidad").disabled = true;
    
    $("#cuotas").hide();
    $("#cantidades").show();

    $("#idconcepto").focus();
    
  });


  function calcular_cuota(){

    precio = parseFloat($("#precio").val());
    cadena = $("#mes").val().toString();
    selectedMes = cadena.split(',');
    importe = parseFloat(selectedMes.length*precio);
    $("#importe").val(importe.toFixed(2));


  }

</script>
