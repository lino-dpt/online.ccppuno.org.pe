<link rel="icon" href="<?php echo base_url();?>resources/img/logo.png" type="image/png" />


<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<link rel="stylesheet" href="<?php echo base_url();?>resources/jquery-ui/jquery-ui.css">
<!-- Bootstrap -->
<link rel="stylesheet" href="<?php echo base_url();?>resources/css/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo base_url();?>resources/font-awesome/css/font-awesome.min.css">

<!-- jQuery -->
<script src="<?php echo base_url();?>resources/js/jquery.js"></script>

<!-- jQuery-UI -->
<script src="<?php echo base_url();?>resources/jquery-ui/jquery-ui.js"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url();?>resources/css/bootstrap/js/bootstrap.min.js"></script>

<style type="text/css">

    .rojo{
        color: red;
        font-weight: bold;
    }
    
</style>

<div class='container'>
    <br>    
    <div class='row' align="center">
        <div class='col-md-12'>
        `<span style="font-weight: bold; font-size: 28px; color: #24387c; ">PASO Nº 1: DATOS GENERALES DEL TRÁMITE</span>
        </div>
    </div>

    <br>
    
    <form action='<?php echo base_url();?>tramite/insertno' method='POST' class='needs-validation'>


    <div class='alert alert-primary' style="background: #24387c; padding: 10px; color: #fff;" role='alert'>DATOS DEL INTERESADO</div>
    <div class='row'>
        <div class='col-md-2'>
        <div class='form-group'>
            <label for='tpersona'>Tipo Persona</label>
            <select class='custom-select d-block w-100' name='tpersona'>
                <option value='NATURAL'>NATURAL</option>
             </select>
        </div>
        </div>
        <div class='col-md-2'>
            <div class='form-group'>
                <label for='numdoc'>Nº Doc. Identidad <span class="rojo">*</span></label>
                <input type='text' class='form-control text-center' name='numdoc' id='numdoc' value='' maxlength="11" autofocus required>
            </div>
        </div>
        <div class='col-md-4'>
            <div class='form-group'>
                <label for='email'>Email <span class="rojo">*</span></label>
                <input type='email' class='form-control' name='email' value='' required>
            </div>
        </div>
        <div class='col-md-4'>
            <div class='form-group'>
                <label for='celular'>Teléfono Celular (sólo un número) <span class="rojo">*</span></label>
                <input type='text' class='form-control' name='celular' value='' maxlength="9" required>
            </div>
        </div>
    </div>
    <div class='row'>                        
        <div class='col-md-4'>
            <div class='form-group'>
                <label for='paterno'>Apellido Paterno <span class="rojo">*</span></label>
                <input type='text' class='form-control' name='paterno' id='paterno' value='' required>
            </div>
        </div>

        <div class='col-md-4'>
            <div class='form-group'>
                <label for='materno'>Apellido Materno <span class="rojo">*</span></label>
                <input type='text' class='form-control' name='materno' id='materno' value='' required>
            </div>
        </div>

        <div class='col-md-4'>
            <div class='form-group'>
                <label for='nombres'>Nombres <span class="rojo">*</span></label>
                <input type='text' class='form-control' name='nombres' id='nombres' value='' required>
            </div>
        </div>
    </div>

    <div id="form_registro">
    <div class='alert alert-primary' style="background: #24387c; padding: 10px; color: #fff;" role='alert'>DATOS DEL DOCUMENTO</div>
    <div class='row'>
        <div class='col-md-5'>
            <div class='form-group'>
                <label for='idtupa'>Trámite <span class="rojo">*</span></label>
                <select class='custom-select d-block w-100' name='idtupa' id='idtupa' required>
                    <option value=''>Seleccione...</option>
                    <?php foreach($tupas as $tupa):?>
                        <option value='<?php echo $tupa->idtupa; ?>'><?php echo $tupa->destupa; ?></option>
                    <?php endforeach;?>
                 </select>
            </div>
        </div>
        <div class='col-md-4'>
            <div class='form-group'>
                <label for='numero_documento'>Nº de Documento</label>
                <input type='text' class='form-control' name='numero_documento' id='numero_documento' value=''>
            </div>
        </div>
        <div class='col-md-3'>
            <div class='form-group'>
                <label for='fecha_documento'>Fecha del Documento</label>
                <input type='date' class='form-control text-center' name='fecha_documento' id='fecha_documento' value="">
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-md-12'>
            <div class='form-group'>
                <label for='asunto'>Asunto <span class="rojo">*</span></label>
                <input type='text' class='form-control' name='asunto' id='asunto' value='' required>
            </div>
        </div>
     </div>
    <div class='row'>
        <div class='col-md-12'>
            <div class='form-group'>
                <label for='fnacim'>Observaciones</label>
                <textarea class='form-control' id="obs" name="obs"></textarea>
            </div>
        </div>
     </div>
     <span class="rojo">(*) Datos obliogarorios</span>
    
    <hr>

    <div class='row'>
        <div class='col-md-6' align="left">
            <button type="button" onclick="window.location.href='<?php echo base_url();?>acceso'" class='btn btn-success'><i class="fa fa-angle-double-left"></i>&nbsp;Volver a anterior</button>
        </div>
        <div class='col-md-6' align="right">
            <button type='submit' class='btn btn-success'>Pasar a siguiente&nbsp;<i class="fa fa-angle-double-right"></i></button>
        </div>

    </div>


    </div>   
    </form>
    
    <br>
</div>

<script type="text/javascript">
    


</script>