<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CCP EN LINEA</title>

    <link rel="icon" href="<?php echo base_url();?>resources/img/logo.png" type="image/png" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url();?>resources/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resources/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resources/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo base_url();?>resources/js/jquery.js"></script>
    <script src="<?php echo base_url();?>resources/jquery-ui/jquery-ui.js"></script>
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
        <br>
        <div class="row text-center">          
            <div class="col-md-12">
                <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="200" height="200">
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <?php if($this->session->flashdata('flag')=='1'):?>                    
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error!</strong> Ud. ingresó erróneamente el código de la imágen. 
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif;?>

        <div class="row">
          <div class="col-md-12">
            <span class="enlace" onclick="window.location.href = 'https://ccppuno.org/'"><img src="<?php echo base_url();?>resources/img/casa.png" width="30" height="30">&nbsp;&nbsp;Ir al Portal Web</span>
          </div>
        </div>

        <br>
        <form action="<?php echo base_url();?>registro/insert" method="POST" class="needs-validation">
        <div class="alert alert-primary" style="background: #0a3080; padding: 10px; color: #fff;" role="alert">DATOS PERSONALES</div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control text-center" maxlength=8 name="dni" id="dni" value="<?php echo set_value("dni"); ?>" autofocus required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ruc">RUC:</label>
                    <input type="text" class="form-control" name="ruc" maxlength=11 value="<?php echo set_value("ruc"); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="genero">Género:</label>
                    <select class="custom-select d-block w-100" name="genero" required>
                        <option value="">Seleccione...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="fnacim">Nacionalidad:</label>
                    <select class="custom-select d-block w-100" name="nacionalidad" id="nacionalidad" required>
                        <?php foreach($nacionalidades as $nacionalidad):?>
                            <option value="<?php echo $nacionalidad->idnacional; ?>" <?php echo ($nacionalidad->idnacional=='0'?'selected':''); ?>><?php echo $nacionalidad->desnacional2; ?></option>
                        <?php endforeach;?>
                    </select>

                </div>
            </div>
        </div>
        <div class="row">                        
            <div class="col-md-4">
                <div class="form-group">
                    <label for="paterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" name="paterno" id="paterno" value="<?php echo set_value("paterno"); ?>" maxlength=25 required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="materno">Apellido Materno:</label>
                    <input type="text" class="form-control" name="materno" id="materno" value="<?php echo set_value("materno"); ?>" maxlength=25 required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" class="form-control" name="nombres" id="nombres" value="<?php echo set_value("nombres"); ?>" maxlength=30 required>
                </div>
            </div>
        </div>

        <div class="row">                        
            <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo set_value("email"); ?>" maxlength=40 required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="fijo">Teléfono Fijo:</label>
                    <input type="text" class="form-control" name="fijo" value="<?php echo set_value("fijo"); ?>" maxlength=10>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="movil">Teléfono Celular:</label>
                    <input type="text" class="form-control" name="movil" value="<?php echo set_value("movil"); ?>" maxlength=9 required>
                </div>
            </div>
        </div>
        <div class="row">               
            <div class="col-md-3">
                <div class="form-group">
                    <label for="fnacim">Fecha Nacimiento:</label>
                    <input type="date" class="form-control" name="fnacim" value="<?php echo set_value("fnacim"); ?>" required>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="lugar_nacim">Lugar Nacimiento:</label>
                    <input type="text" class="form-control" name="lugar_nacim" value="<?php echo set_value("lugar_nacim"); ?>" maxlength=50 required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="iddep1">Departamento:</label>
                    <select class="custom-select d-block w-100" name="iddep1" id="iddep1" onchange="cambiardep(1);" required>
                        <option value="">Seleccione...</option>
                        <?php foreach($departamentos as $departamento):?>
                            <option value="<?php echo $departamento->iddep; ?>"><?php echo $departamento->desdep; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="idprov1">Provincia:</label>
                    <div id="prov1">
                        <select class="custom-select d-block w-100" name="idprov1" id="idprov1" onchange="cambiarprov(1);" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="iddist1">Distrito:</label>
                    <div id="dist1">
                        <select class="custom-select d-block w-100" name="iddist1" id="iddist1" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">                        
            <div class="col-md-3">
                <div class="form-group">
                    <label for="direccion">Dirección Actual:</label>
                    <input type="text" class="form-control" name="direccion" value="<?php echo set_value("direccion"); ?>" maxlength=80 required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="barrio">Barrio/Urbanización:</label>
                    <input type="text" class="form-control" name="barrio" value="<?php echo set_value("barrio"); ?>" maxlength=40>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="iddep2">Departamento:</label>
                    <select class="custom-select d-block w-100" name="iddep2" id="iddep2" onchange="cambiardep(2);" required>
                        <option value="">Seleccione...</option>
                        <?php foreach($departamentos as $departamento):?>
                            <option value="<?php echo $departamento->iddep; ?>"><?php echo $departamento->desdep; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="idprov2">Provincia:</label>
                    <div id="prov2">
                        <select class="custom-select d-block w-100" name="idprov2" id="idprov2" onchange="cambiarprov(2);" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="iddist2">Distrito:</label>
                    <div id="dist2">
                        <select class="custom-select d-block w-100" name="iddist2" id="iddist2" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">                        
            <div class="col-md-6">
                <div class="form-group">
                    <label for="claboral">Centro Laboral:</label>
                    <input type="text" class="form-control" name="claboral" value="<?php echo set_value("claboral"); ?>" maxlength=200>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="iddep3">Departamento:</label>
                    <select class="custom-select d-block w-100" name="iddep3" id="iddep3" onchange="cambiardep(3);">
                        <option value="">Seleccione...</option>
                        <?php foreach($departamentos as $departamento):?>
                            <option value="<?php echo $departamento->iddep; ?>"><?php echo $departamento->desdep; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="idprov3">Provincia:</label>
                    <div id="prov3">
                        <select class="custom-select d-block w-100" name="idprov3" id="idprov3" onchange="cambiarprov(3);">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="iddist3">Distrito:</label>
                    <div id="dist3">
                        <select class="custom-select d-block w-100" name="iddist3" id="iddist3">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row">                        
            <div class="col-md-5">
                <div class="form-group">
                    <label for="ref_urgencia">Referencia en caso de urgencia:</label>
                    <input type="text" class="form-control" name="ref_urgencia" value="<?php echo set_value("ref_urgencia"); ?>" maxlength=100 required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="dir_urgencia">Dirección:</label>
                    <input type="text" class="form-control" name="dir_urgencia" value="<?php echo set_value("dir_urgencia"); ?>" maxlength=80>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="telefono_urgencia">Nº Teléfono:</label>
                    <input type="text" class="form-control" name="telefono_urgencia" value="<?php echo set_value("telefono_urgencia"); ?>" maxlength=20 required>
                </div>
            </div>
        </div>

        <br>
        <div class="alert alert-primary" style="background: #0a3080; padding: 10px; color: #fff;" role="alert">DATOS FAMILIARES</div>
        <strong><i>Datos del(a) cónyugue:</i></strong>
        <div class="row">                        
            <div class="col-md-3">
                <div class="form-group">
                    <label for="conyugue_dni">DNI:</label>
                    <input type="text" class="form-control" name="conyugue_dni" id="conyugue_dni" value="<?php echo set_value("conyugue_dni"); ?>" maxlength=8>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="conyugue_paterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" name="conyugue_paterno" id="conyugue_paterno" value="<?php echo set_value("conyugue_paterno"); ?>" maxlength=25>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="conyugue_materno">Apellido Materno:</label>
                    <input type="text" class="form-control" name="conyugue_materno" id="conyugue_materno" value="<?php echo set_value("conyugue_materno"); ?>" maxlength=25>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="conyugue_nombres">Nombres:</label>
                    <input type="text" class="form-control" name="conyugue_nombres" id="conyugue_nombres" value="<?php echo set_value("conyugue_nombres"); ?>" maxlength=30>
                </div>
            </div>
        </div>
        
        <strong><i>Datos de los hijos:</i></strong>
        <div class="form-row align-items-center">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="dni_hijo">DNI:</label>
                    <input type="text" class="form-control" name="dni_hijo" id="dni_hijo" value="" maxlength="8">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="paterno_hijo">Apellido Paterno:</label>
                    <input type="text" class="form-control" name="paterno_hijo" id="paterno_hijo" value="" maxlength=25>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="materno_hijo">Apellido Materno:</label>
                    <input type="text" class="form-control" name="materno_hijo" id="materno_hijo" value="" maxlength=25>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombres_hijo">Nombres:</label>
                    <input type="text" class="form-control" name="nombres_hijo" id="nombres_hijo" value="" maxlength=30>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="fecha_hijo">Fecha Nacimiento:</label>
                    <input type="date" class="form-control" name="fecha_hijo" id="fecha_hijo" value="">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label for="agregar">&nbsp;</label>
                    <button type="button" class="btn btn-success" id="btn-agregar">Agregar</button>
                </div>
            </div>

        </div>

        <div class="row">
        <div class="col-md-12">
          <div id="detalle_items">
          <table id="tbitems" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                    <th>DNI</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Apellido Nombres</th>
                    <th>Fecha Nacimiento</th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
          </div>    
        </div>
        </div>        


        <br>
        <div class="alert alert-primary" style="background: #0a3080; padding: 10px; color: #fff;" role="alert">DATOS PROFESIONALES</div>
        <div class="row">                        
            <div class="col-md-6">
                <div class="form-group">
                    <label for="buscar_univ1">Universidad de Estudio (buscar):</label>
                    <input type="hidden" name="iduniv1" id="iduniv1" value="" required>
                    <input type="text" class="form-control" name="buscar_univ1" id="buscar_univ1" value="" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="semestre_ingreso">Ingreso (Ej. 2015-I):</label>
                    <input type="text" class="form-control" name="semestre_ingreso" value="<?php echo set_value("semestre_ingreso"); ?>" maxlength=7 required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="semestre_egreso">Egreso (Ej. 2019-II):</label>
                    <input type="text" class="form-control" name="semestre_egreso" value="<?php echo set_value("semestre_egreso"); ?>" maxlength=7 required>
                </div>
            </div>
        </div>
        <div class="row">                        
            <div class="col-md-4">
                <div class="form-group">
                    <label for="buscar_univ2">Universidad que otorgó título (buscar):</label>
                    <input type="hidden" name="iduniv2" id="iduniv2" value="" required>
                    <input type="text" class="form-control" name="buscar_univ2" id="buscar_univ2" value="" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="num_resolucion">Resolución Rectoral Nº:</label>
                    <input type="text" class="form-control" name="num_resolucion" value="<?php echo set_value("num_resolucion"); ?>" maxlength=40 required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="fecha_titulo">Fecha:</label>
                    <input type="date" class="form-control" name="fecha_titulo" value="<?php echo set_value("fecha_titulo"); ?>" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="num_titulo">Título Nº:</label>
                    <input type="text" class="form-control" name="num_titulo" value="<?php echo set_value("num_titulo"); ?>" maxlength=20 required>
                </div>
            </div>

        </div>
        <br>
        <div class="alert alert-primary" style="background: #0a3080; padding: 10px; color: #fff;" role="alert">ESTUDIOS DE ESPECIALIZACIÓN</div>
        <div class="row">
            <div class="col-md-6">
                <label for="num_titulo">Especialidades disponibles (seleccione con doble click):</label>
                <select class="custom-select d-block w-100" name="espec1" id="espec1" size="6" style="width:160px">
                    <?php foreach($especs as $espec):?>
                        <option value="<?php echo $espec->idespec; ?>" <?php echo ($espec->idespec=='0'?'selected':''); ?>><?php echo $espec->desespec; ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="num_titulo">Especialidades seleccionadas:</label>
                <div id="espe"><select class="custom-select d-block w-100" name="espec2[]" id="espec2" multiple size="6" style="width:160px"></select></div>
            </div>

        </div>  

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="checkbox">
                        <label><input type="checkbox" value="" required> <strong>Acepto</strong>, <small>toda la información contenida en el presente formulario para la incorporación como miembro de la orden en el Colegio de Contadores Públicos de Puno, hacen referencia a documentos auténticos con valor legal, está de acuerdo a lo establecido en la Ley Nº13253, Ley Nº28951 y la Ley Nº30220 (Ley Universitaria) y normas conexas, en caso contrario me someto a las sanciones de Ley.</small></label>
                    </div>
                </div>
            </div>
        </div>
        <br>

                            

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-2">
                <div class="form-group">
                    <div id="img_captcha"><?php echo $captcha; ?></div>&nbsp;&nbsp;&nbsp;
                </div>
            </div>
            <div class="col-md-1">
            <div class="form-group">
                <img style="cursor:pointer;" height="36" width="36" src="<?php echo base_url();?>resources/img/refresh.png" alt="Refresh Image" onclick=refrescar_img(); style="border: 0px; vertical-align: bottom">
            </div>
        
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control text-center" name="captcha" id="captcha" maxlength=5 value="" placeholder="INGRESE EL TEXTO" required>
                </div>
            </div>
        </div>

        <br>
        
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success btn-lg btn-block" onclick=seleccionarTodo();>Enviar datos</button>
            </div>
            <div class="col-md-4"></div>
        </div>    
        </form>
    </div>

    <br><br><br><br>

    <div style="background:#0a3080; padding: 30px;">
      <div class="container">
        <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="100" height="100">
        
        <hr style="border-top: 1px solid #ccc;">
        <small style="color: #fff;">© 2020 Colegio de Contadores Públicos de Puno.</small>
      </div>
    </div>

  </body>
</html>

<script type="text/javascript">
    var base_url = "<?php echo base_url();?>";

    $(function(){
    $('#captcha').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
        });
    });

    function refrescar_img(){
        
        var ruta =  base_url + "registro/refresh_captcha";
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

    $("#buscar_univ1").autocomplete({
      source: function(request, response){
        url = "registro/getuniversidades";
        $.ajax({
          url:base_url+url,
          type:"POST",
          dataType:"json",
          data:{ valor: request.term},
          success: function(data){
            response(data);
          }
        });
      },
      minLength:1,
      select:function(event, ui){
        $("#iduniv1").val(ui.item.id);
      }

    });

    $("#buscar_univ2").autocomplete({
      source: function(request, response){
        url = "registro/getuniversidades";
        $.ajax({
          url:base_url+url,
          type:"POST",
          dataType:"json",
          data:{ valor: request.term},
          success: function(data){
            response(data);
          }
        });
      },
      minLength:1,
      select:function(event, ui){
        $("#iduniv2").val(ui.item.id);
      }

    });

    function cambiardep(num){
        n = num.toString();
        var_cod = $("#iddep"+n).val();
        
        var ruta =  base_url + "registro/provincias";
        $.ajax({
        url: ruta,
        data: "cod="+var_cod,
        type: "POST",
        success: function(data){
            registros = eval(data);

            html = '';
            html += "<select class='custom-select d-block w-100' name='idprov"+n+"' id='idprov"+n+"' onchange='cambiarprov("+n+");' "+(n!='3'?'required':'')+">";
            html += "<option value=''>Seleccione...</option>";
            for (var i=0; i < registros.length; i++) {
                html += "<option value='"+registros[i].idprov+"'>"+registros[i].desprov+"</option>";        
            }
            html += "</select>";
            
            $('#prov'+n).empty();
            $('#prov'+n).append(html);

            html = '';
            html += "<select class='custom-select d-block w-100' name='iddist"+n+"' id='iddist"+n+"' "+(n!='3'?'required':'')+">";
            html += "<option value=''>Seleccione...</option>";
            html += "</select>";

            $('#dist'+n).empty();
            $('#dist'+n).append(html);

        }
        }); 
    }

    function cambiarprov(num){
        n = num.toString();
        var_cod = $("#idprov"+n).val();        

        var ruta =  base_url + "registro/distritos";
        $.ajax({
        url: ruta,
        data: "cod="+var_cod,
        type: "POST",
        success: function(data){
            registros = eval(data);

            html = '';
            html += "<select class='custom-select d-block w-100' name='iddist"+n+"' id='iddist"+n+"' "+(n!='3'?'required':'')+">";
            html += "<option value=''>Seleccione...</option>";
            for (var i=0; i < registros.length; i++) {
                html += "<option value='"+registros[i].iddist+"'>"+registros[i].desdist+"</option>";        
            }
            html += "</select>";
            
            $('#dist'+n).empty();
            $('#dist'+n).append(html);
        }
        });
    }

    $('#espec1').on('dblclick',function(){
        
        id = $('#espec1').val();
        nombre = $("#espec1 option:selected").text();
        $("#espec2").append(new Option(nombre, id));
        $("#espec1 option:selected").remove();        

    });

    $('#espec2').on('dblclick',function(){
        
        id = $('#espec2').val();
        nombre = $("#espec2 option:selected").text();
        $("#espec1").append(new Option(nombre, id));
        $("#espec2 option:selected").remove();

    });



    
    $("#btn-agregar").on("click",function(){
      dni = $("#dni_hijo").val();
      paterno = $("#paterno_hijo").val();
      materno = $("#materno_hijo").val();
      nombres = $("#nombres_hijo").val();
      fecha = $("#fecha_hijo").val();

      if(dni == ''){
        alert("Error, ingrese el DNI del menor.");
        $("#dni_hijo").focus();
        return;
      }
      if(paterno == ''){
        alert("Error, ingrese el Apellido Paterno del menor.");
        $("#paterno_hijo").focus();
        return;
      }
      if(materno == ''){
        alert("Error, ingrese el Apellido Materno del menor.");
        $("#materno_hijo").focus();
        return;
      }
      if(nombres == ''){
        alert("Error, ingrese los Nombres del menor.");
        $("#nombres_hijo").focus();
        return;
      }
      if(fecha == ''){
        alert("Error, ingrese el la fecha de Nacimiento del menor.");
        $("#fecha_hijo").focus();
        return;
      }

      html = "<tr>";
      html += "<td><input type='hidden' name='dnis[]' value='"+dni+"'>"+dni+"</td>";
      html += "<td><input type='hidden' name='paternos[]' value='"+paterno+"'>"+paterno+"</td>";
      html += "<td><input type='hidden' name='maternos[]' value='"+materno+"'>"+materno+"</td>";
      html += "<td><input type='hidden' name='nombress[]' value='"+nombres+"'>"+nombres+"</td>";
      html += "<td><input type='hidden' name='fechas[]' value='"+fecha+"'>"+fecha+"</td>";
      html += "<td><button id='btn-remove' type='button' class='btn btn-danger btn-remove-item'><i class='fa fa-times' aria-hidden='true'></i></button></td>";
      html += "</tr>";

      $("#tbitems tbody").append(html);        

      $("#dni_hijo").val("");
      $("#paterno_hijo").val("");
      $("#materno_hijo").val("");
      $("#nombres_hijo").val("");
      $("#fecha_hijo").val("");

      $("#dni_hijo").focus();

    });

    $(document).on("click", ".btn-remove-item", function(){
      $(this).closest("tr").remove();
    });


   function seleccionarTodo()
    {
         $("#espe select option").attr("selected","selected"); 

    }

</script>
