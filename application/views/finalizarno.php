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


<div class='container'>

    <br>
    <br>
    <div class="row text-center">          
        <div class="col-md-12">
            <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="160" height="160">
        </div>
    </div>

    <br>
    <form action='<?php echo base_url();?>registro/insert' method='POST' class='needs-validation'>
    <div id="form_registro">

    <div class="alert alert-success" role="alert">
        <strong>FELICITACIONES..!!!</strong>, su trámite se ha realizado con ÉXITO, guarde el número de <strong>Registro Único de Trámite</strong> y la <strong>Clave generada</strong> que serán los datos con las que podrá consultar porteriormente el estado de su trámite. 
    </div>

    <table class="table table-bordered">
        <tr><td width="30%"><span style="font-style: italic; font-weight: bold">Registro Único de Trámite (RUT)</span></td><td width="70%"><strong><?php echo $documento[0]->idregistro; ?></strong></td></tr>
        <tr><td><span style="font-style: italic; font-weight: bold">Clave generada</span></td><td><strong><?php echo $documento[0]->clave; ?></strong></td></tr>
        <tr><td><span style="font-style: italic; font-weight: bold">Fecha y Hora</span><td><?php echo $documento[0]->hora_recepcion; ?></td></td>
    </table>

    <div class='row' align="center">
        <div class='col-md-12'>
            <button type="button" style="padding: 8px;" onclick="window.location.href='<?php echo base_url();?>acceso'" class='btn btn-success'><i class="fa fa-home"></i>&nbsp;Ir al Inicio para ver el estado de su Trámite)</button>
        </div>
    </div>

    <br>

    </div>   
    </form>
    
    <br>
</div>