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
    <br>
    <div class="row text-center">          
        <div class="col-md-12">
            <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="160" height="160">
        </div>
    </div>

    <br>
    <div class='row'>
        <div class='col-md-12' align="center">
            <button type="button" onclick="window.location.href='<?php echo base_url();?>tramite/logout'" class='btn btn-success'><i class="fa fa-home"></i>&nbsp;Ir al Inicio (Nueva Búsqueda)</button>
        </div>    
    </div>   
    <br>
    <div class='alert alert-primary' style="background: #24387c; padding: 10px; color: #fff;" role='alert'>DATOS DEL DOCUMENTO</div>
    <div class='row'>
        <div class='col-md-12'>
            <table class="table table-bordered">
                <tr>
                    <td width="30%"><span style="font-style: italic; font-weight: bold">Registro Único de Trámite (RUT)</span></td>
                    <td><?php echo $documento[0]->idregistro; ?></td>
                    <td width="30%"><span style="font-style: italic; font-weight: bold">Fecha y Hora de recepción (mesa partes)</span></td>
                    <td><?php echo $documento[0]->hora_recepcion; ?></td>
                </tr>
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">Trámite</span></td>
                    <td colspan="3"><?php echo $documento[0]->doc; ?></td>
                </tr>
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">Asunto</span></td>
                    <td colspan="3"><?php echo $documento[0]->asunto; ?></td>
                </tr>
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">Interesado</span></td>
                    <td colspan="3"><?php echo $documento[0]->interesado; ?></td>
                </tr>
                <tr>
                    <td><span style="font-style: italic; font-weight: bold">Estado Actual del Documento</span></td>
                    <td colspan="3"><?php echo $documento[0]->desestado; ?></td>
                </tr>
            </table>
        </div>    
    </div>

    <div class='alert alert-primary' style="background: #24387c; padding: 10px; color: #fff;" role='alert'>SEGUIMIENTO DEL TRÁMITE</div>

    <div class='row'>
        <div class='col-md-12'>
            <table class="table table-bordered table-hover" style="font-size: 13px;">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Fecha de Trámite</th>
                        <th>De</th>
                        <th>A</th>
                        <th>Estado</th>
                        <th>Fecha de Atención</th>
                        <th>Nº Proveido</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    <?php foreach($movimientos as $mov):?>
                    <tr title="<?php echo $mov->etiqueta; ?>">
                        <td><?php echo $i++; ?></td>
                        <td align="center"><?php echo $mov->hora_recepcion; ?></td>
                        <td><?php echo $mov->origen; ?></td>
                        <td><?php echo $mov->destino; ?></td>
                        <td><?php echo $mov->desestado; ?></td>
                        <td align="center"><?php echo $mov->hora_atencion; ?></td>
                        <td align="center"><?php echo $mov->numero_proveido; ?></td>
                        <td><?php echo $mov->obs; ?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

        </div>    
    </div>   

    <br>

    <div class='row'>
        <div class='col-md-12' align="center">
            <!-- <button type="button" onclick="window.location.href='<?php echo base_url();?>tramite/logout'" class='btn btn-info'><i class="fa fa-print"></i>&nbsp;Imprimir seguimiento de Trámite</button> -->
        </div>    
    </div>   

</div>