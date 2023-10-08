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
    <div class='row' align="center">
        <div class='col-md-12'>
        `<span style="font-weight: bold; font-size: 28px; color: #24387c; ">PASO Nº 2: ADJUNTAR ARCHIVOS</span>
        </div>
    </div>

    <br>
    <form action='<?php echo base_url();?>tramite/upload' enctype="multipart/form-data" method='POST'>
    <div id="form_registro">
    <div class='alert alert-primary' style="background: #24387c; padding: 10px; color: #fff;" role='alert'>ARCHIVO DEL TRÁMITE</div>

    <div class='row'>
        <div class='col-md-12'>
          <table id="tbpagos" class="table table-bordered">
            <tr>
                <th colspan="5"><i>Archivos del Trámite (escaneado en PDF)</i></th>
            </tr>
            <tr>
                <th>Nº</th>
                <th colspan="2">Denominación</th>
                <th>Archivo <small>(2Mb maximo = 2000Kb)</small></th>
                <th>Observaciones</th>
            </tr>
            <tr>
                <td>1</td>
                <td colspan="2"><?php echo $documento[0]->doc; ?></td>
                <td>
                    <label>Tipo archivo: <strong>.pdf</strong> <i class="fa fa-file-pdf"></i></label>
                    <div>
                        <input type="file" accept=".pdf" id="upfile_0" name="upfile_0" required>
                    </div>
                </td>
                <td>
                    <div id="obs_upfile_0" align="center"><span style="color:red; font-size:16px; font-weight:bold;">Pendiente...!!!</span></div>
                    <div align="center" id="tam_upfile_0"></div>
                </td>
            </tr>
            <tr>
                <th colspan="5"><i>Archivos de los Requisitos:</i></th>
            </tr>
            
            <?php $i=1; ?>
            <?php foreach($requisitos as $requisito):?>
                <tr>
                <td><?php echo $i++; ?></td>

                <?php if($requisito->tipo == '0'): ?>                
                <td colspan="2"><?php echo $requisito->desrequisito; ?></td>
                <td>
                    <label>Tipo archivo: <strong><?php echo $requisito->tipoarchivo; ?></strong> <i class="fa fa-file-pdf"></i></label>
                    <div>
                        <input type="file" accept="<?php echo $requisito->tipoarchivo; ?>" id="upfile_<?php echo $requisito->idrequisito; ?>" name="upfile_<?php echo $requisito->idrequisito; ?>" required>
                    </div>
                </td>
                <td>
                    <div align="center" id="obs_upfile_<?php echo $requisito->idrequisito; ?>"><span style="color:red; font-size:16px; font-weight:bold;">Pendiente...!!!</span></div>
                    <div align="center" id="tam_upfile_<?php echo $requisito->idrequisito; ?>"></div>
                </td>
                </tr>
                <?php endif;?>

                <?php if($requisito->tipo == '1'): ?>                
                <td colspan="2"><small><?php echo $requisito->desrequisito; ?></small>
                <div class="form-row align-items-center" style="padding: 4px;">
                    <div class="col-md-4">
                        <input type="text" class="form-control text-center" id="voucher_upfile_<?php echo $requisito->idrequisito; ?>" name="voucher_upfile_<?php echo $requisito->idrequisito; ?>" placeholder="Nº Operación" maxlength="8" required>
                    </div>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" id="fecha_upfile_<?php echo $requisito->idrequisito; ?>" name="fecha_upfile_<?php echo $requisito->idrequisito; ?>" placeholder="Fecha" required>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control text-right" id="importe_upfile_<?php echo $requisito->idrequisito; ?>" name="importe_upfile_<?php echo $requisito->idrequisito; ?>" placeholder="Importe" required>
                    </div>
                </div>
                </td>

                <td>
                    <label>Tipo archivo: <strong><?php echo $requisito->tipoarchivo; ?></strong> <i class="fa fa-file-pdf"></i></label>
                    <div>
                        <input type="file" accept="<?php echo $requisito->tipoarchivo; ?>" id="upfile_<?php echo $requisito->idrequisito; ?>" name="upfile_<?php echo $requisito->idrequisito; ?>" required>
                    </div>
                </td>
                <td>
                    <div align="center" id="obs_upfile_<?php echo $requisito->idrequisito; ?>"><span style="color:red; font-size:16px; font-weight:bold;">Pendiente...!!!</span></div>
                    <div align="center" id="tam_upfile_<?php echo $requisito->idrequisito; ?>"></div>
                </td>
                </tr>
                <?php endif;?>

            <?php endforeach;?>
                    
          </table>
        </div>
    </div>

    <br>
    <div class='row'>
        <div class='col-md-8' align="right"><div id="subiendo" style="display: none;"><img src="<?php echo base_url();?>resources/img/loading.gif" width="50" height="50">Subiendo archivos...</div></div>
        <div class='col-md-4' align="right">
            <button type="submit" class='btn btn-success'><i class='fa fa-upload'></i>&nbsp;Subir todos los archivos y Finalizar Trámite</button>
        </div>

    </div>


    </div>   
    </form>
    
    <br>
</div>


<script type='text/javascript'>
    var base_url = "<?php echo base_url();?>";

       
    $("input[type=file]").on('change',function(){

        id = $(this).attr('id');

        var sizeByte = this.files[0].size;
        var siezekiloByte = parseInt(sizeByte / 1024);

        if(sizeByte > 2097152){
           alert('El tamaño supera el limite permitido');
           $(this).val("");
           $("#obs_"+id).html("<span style='color:red; font-size:16px; font-weight:bold;'>Pendiente...!!!</span>");
           $("#tam_"+id).html(""); 

           $("#ok_"+id).val("0");
        }else{
           $("#tam_"+id).html("<small>Tamaño: "+siezekiloByte+" Kb</small>");
           $("#obs_"+id).html("<span style='color:green; font-size:16px; font-weight:bold;'>OK...!!!</span>");

           $("#ok_"+id).val("1");
        }
        
    });




</script>
