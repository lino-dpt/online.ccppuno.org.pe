<div class="container-fluid">
	<?php if(false):?>
	<div class="alert alert-info" role="alert">
	    <strong>Por seguridad Ud. debe cambiar su contraseña periodicamente..!!!</strong>,  hágalo haciendo click en el siguiente botón: <button type="button" class="btn btn-info" onclick=cambiar();><span class='fa fa-key'>&nbsp;Cambiar Contraseña</span></button>
	</div>
	<?php endif;?>

	<?php if($this->session->userdata("actualizar_datos") == 'T'):?>
	<div class="alert alert-danger" role="alert">
	    <strong>Ud. debe de realizar la actualización de sus datos</strong>,  ello puede hacerlo haciendo click en el siguiente botón: <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url();?>agremiado/updatemisdatos'"><span class='fa fa-address-card'>&nbsp;&nbsp;Actualzar mis datos</span></button>
	</div>
	<?php endif;?>

	<?php if($this->session->userdata("actualizar_datos") == 'F'):?>
	<div class="alert alert-success" role="alert">
	    <strong>El CDR XVI Puno le agradece por realizar la actualización de datos, </strong>dichos datos nos ayudará a tener mayor contacto con Ud. y brindarle una mejor atención.
	</div>
	<?php endif;?>

	<?php if($this->session->userdata("subir_foto") == 'T'):?>
	<div class="alert alert-danger" role="alert">
	    <strong>Requerimos de una Foto tamaño carnet en formato JPG ó PNG, por favor subirlo en el siguiente enlace: <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url();?>agremiado/subirfoto'"><span class='fa fa-address-card'>&nbsp;&nbsp;Subir Foto</span></button>
	</div>
	<?php endif;?>



	<br><br><br><br><br>
    
</div>


<!-- Modal -->
<div class="modal hide fade" id="cambiar" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Cambiar Contraseña</h5>
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
          	
          	<?php if($this->session->userdata("cambiar_clave") == 'T'):?>
          		<a href="<?php echo base_url();?>auth/logout" class="btn btn-danger">Cerrar</a>
			<?php endif;?>          	

          	<?php if($this->session->userdata("cambiar_clave") == 'F'):?>
          		<button type="button" class="btn btn-secondary" id="_cerrar" data-dismiss="modal">Cerrar</button>
			<?php endif;?>          	

        </div>  
    </div>
  </div>
</div>

<script type="text/javascript">

	var base_url = "<?php echo base_url();?>";

	var cambiar_clave = "<?php echo $this->session->userdata("cambiar_clave");?>";
	
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

	      //$("#_cerrar").click();  
	      window.location.href = base_url;
	    }
	  }
	  });
	}

	if(cambiar_clave == 'T'){
		cambiar();
	}
		
</script>
