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
      <?php if(true):?>
      
        <?php if($this->session->userdata("subir_foto") == 'T'):?>
          <center><img src="<?php echo base_url();?>files/fotos/sinfoto.png" alt="" width="140" height="160"></center>
        <?php endif;?>
        <?php if($this->session->userdata("subir_foto") == 'F'):?>
          <center><img src="<?php echo base_url().'files/fotos/'.$this->session->userdata('id').'.'.$this->session->userdata('extension_foto');?>" alt="" width="160" height="180"></center>
        <?php endif;?>

      <br>
      <div class="row">          

          <div class="col-md-12">  
              <table class="table table-bordered">
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Contraseña de Acceso</span></td>
                  <td><button type="button" class="btn btn-info" onclick=cambiar();><span class="fa fa fa-key"></span>&nbsp;Cambiar mi Contraseña</button></td>
                </tr>  

                <tr>
                  <td><span style="font-style: italic; font-weight: bold">DNI</span></td>
                  <td><?php echo $registro[0]->dni; ?></td>
                </tr>  
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Matrícula</span></td>
                  <td><?php echo $registro[0]->nummat; ?></td>
                </tr>  
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Colegiado</span></td>
                  <td><?php echo $registro[0]->nombre; ?></td>
                </tr>
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Dirección</span></td>
                  <td><?php echo $registro[0]->direccion; ?></td>
                </tr>
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Email</span></td>
                  <td><?php echo $registro[0]->email; ?></td>
                </tr>
                <tr>
                  <td><span style="font-style: italic; font-weight: bold">Teléfono</span></td>
                  <td><?php echo $registro[0]->movil; ?></td>
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
    </div>
    <br><br><br><br><br>


</body>
</html>

<!-- Modal -->
<div class="modal hide fade" id="cambiar" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Cambiar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">                        
          <div class="col-md-12">
            <div class="form-group">
                <label for="anterior">Contraseña Anterior:</label>
                <input type="password" class="form-control" name="anterior" id="anterior" value="">
            </div>
          </div>
        </div>
        <div class="row">                        
          <div class="col-md-12">
            <div class="form-group">
                <label for="nuevo">Contraseña Nueva:</label>
                <input type="password" class="form-control" name="nuevo" id="nuevo" value="">
            </div>
          </div>
        </div>
        <div class="row">                        
          <div class="col-md-12">
            <div class="form-group">
                <label for="renuevo">Repita Contraseña Nueva:</label>
                <input type="password" class="form-control" name="renuevo" id="renuevo" value="">
            </div>
          </div>

        </div>
          
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick=guardar_cambio(); id="bt_crear">Guardar Contraseña</button>
          <button type="button" class="btn btn-secondary" id="_cerrar" data-dismiss="modal">Cerrar</button>
        </div>  
    </div>
  </div>
</div>

<script type="text/javascript">
  var base_url = "<?php echo base_url();?>";

   function cambiardep(num){
        n = num.toString();
        var_cod = $('#iddep'+n).val();

        var_idprov = $('#ubigeo'+n).val();
        var_idprov = var_idprov.substr(0, 4);

        var ruta =  base_url + 'agremiado/provincias';
        $.ajax({
        url: ruta,
        data: 'cod='+var_cod,
        async: false,
        type: 'POST',
        success: function(data){
            registros = eval(data);
            var_idprov1 = '2109';

            html = "";
            html += "<select class='custom-select d-block w-100' name='idprov"+n+"' id='idprov"+n+"' onchange='cambiarprov("+n+");' required>";
            html += "<option value=''>Seleccione...</option>";
            for (var i=0; i < registros.length-1; i++) {
                html += "<option value='"+registros[i].idprov+"' " + (registros[i].idprov==var_idprov?'selected':'') + ">"+registros[i].desprov+"</option>";
            }
            html += "</select>";
            
            $('#prov'+n).empty();
            $('#prov'+n).append(html);

            html = "";
            html += "<select class='custom-select d-block w-100' name='iddist"+n+"' id='iddist"+n+"' required>";
            html += "<option value=''>Seleccione...</option>";
            html += "</select>";

            $('#dist'+n).empty();
            $('#dist'+n).append(html);

        }
        }); 
    }

    function cambiarprov(num){
        n = num.toString();
        var_cod = $('#idprov'+n).val();        

        var_iddist = $('#ubigeo'+n).val();

        var ruta =  base_url + 'agremiado/distritos';
        $.ajax({
        url: ruta,
        data: 'cod='+var_cod,
        async: false,
        type: 'POST',
        success: function(data){
            registros = eval(data);

            html = "";
            html += "<select class='custom-select d-block w-100' name='iddist"+n+"' id='iddist"+n+"' required>";
            html += "<option value=''>Seleccione...</option>";
            for (var i=0; i < registros.length-1; i++) {
                html += "<option value='"+registros[i].iddist+"' " + (registros[i].iddist==var_iddist?'selected':'') + ">"+registros[i].desdist+"</option>";
            }
            html += "</select>";
            
            $('#dist'+n).empty();
            $('#dist'+n).append(html);
        }
        });
    }


  $( document).ready(function() {
      cambiardep(2);
      cambiarprov(2);
      cambiardep(3);
      cambiarprov(3);
      
  });

  function cambiar(){
    $("#cambiar").modal({backdrop: 'static', keyboard: false});
    $('#anterior').focus();
  }

  function guardar_cambio(){
      var_anterior = $('#anterior').val();
      var_nuevo = $('#nuevo').val();
      var_renuevo = $('#renuevo').val();

      if(var_anterior == ""){
        alert("Error, Ingrese su contraseña anterior.");
        $('#anterior').focus();
        return;
      }

      if(var_nuevo == ""){
        alert("Error, Ingrese su nueva contraseña.");
        $('#nuevo').focus();
        return;
      }

      if(var_renuevo == ""){
        alert("Error, Ingrese la repetición de su contraseña.");
        $('#renuevo').focus();
        return;
      }


      if(var_nuevo != var_renuevo){
        alert("Error, Nueva y Repetir contraseña deben de ser iguales.");
        $('#nuevo').focus();
        return;

      }

      var ruta =  base_url + 'agremiado/cambiar';
      $.ajax({
      url: ruta,
      data: 'anterior='+var_anterior+'&nuevo='+var_nuevo,
      type: 'POST',
      success: function(resp){
        data = JSON.parse(resp);

        if(!data['flag']){
          alert(data['msg']);  
          $("#anterior").focus();  
        }else{
          alert(data['msg']);  
          $('#anterior').val("");
          $('#nuevo').val("");
          $('#renuevo').val("");

          $("#_cerrar").click();  
        }
      }
      });


  }


  /*window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
  }, 2000);*/

</script>
