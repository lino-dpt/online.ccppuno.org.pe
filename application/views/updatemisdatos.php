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
        <form action="<?php echo base_url();?>agremiado/update" method="POST" class="needs-validation">
        <div class="alert alert-primary" style="background: #0a3080; padding: 10px; color: #fff;" role="alert">DATOS PERSONALES</div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control text-center" maxlength=8 name="dni" id="dni" value="<?php echo $registro[0]->dni; ?>" autofocus required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ruc">RUC:</label>
                    <input type="text" class="form-control" name="ruc" maxlength=11 value="<?php echo $registro[0]->ruc; ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="genero">Género:</label>
                    <select class='custom-select d-block w-100' name='genero' required>
                        <option value=''>Seleccione...</option>
                            <option value='Masculino' <?php echo ('Masculino'==$registro[0]->genero?'selected':''); ?>>Masculino</option>
                            <option value='Femenino' <?php echo ('Femenino'==$registro[0]->genero?'selected':''); ?>>Femenino</option>
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
                    <input type="text" class="form-control" name="paterno" id="paterno" value="<?php echo $registro[0]->paterno; ?>" maxlength=25 required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="materno">Apellido Materno:</label>
                    <input type="text" class="form-control" name="materno" id="materno" value="<?php echo $registro[0]->materno; ?>" maxlength=25 required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" class="form-control" name="nombres" id="nombres" value="<?php echo $registro[0]->nombres; ?>" maxlength=30 required>
                </div>
            </div>
        </div>

        <div class="row">                        
            <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $registro[0]->email; ?>" maxlength=40 required>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="fijo">Teléfono Fijo:</label>
                    <input type="text" class="form-control" name="fijo" value="<?php echo $registro[0]->fijo; ?>" maxlength=10>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="movil">Teléfono Celular:</label>
                    <input type="text" class="form-control" name="movil" value="<?php echo $registro[0]->movil; ?>" maxlength=9 required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="estadocivil">Estado Civil:</label>
                    <select class='custom-select d-block w-100' name='estadocivil' required>
                        <option value=''>Seleccione...</option>
                        <?php foreach($estadocivils as $estadocivil):?>
                            <option value='<?php echo $estadocivil->idecivil; ?>' <?php echo ($estadocivil->idecivil==$registro[0]->idecivil?'selected':''); ?>><?php echo $estadocivil->desestado; ?></option>
                        <?php endforeach;?>
                    </select>

                     </select>
                </div>
            </div>

        </div>
        <div class="row">               
            <div class="col-md-3">
                <div class="form-group">
                    <label for="fnacim">Fecha Nacimiento:</label>
                    <input type="date" class="form-control" name="fnacim" value="<?php echo $registro[0]->fecha_nacimiento; ?>" required>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="lugar_nacim">Lugar Nacimiento:</label>
                    <input type="text" class="form-control" name="lugar_nacim" value="<?php echo $registro[0]->lugar_nacim; ?>" maxlength=50 required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for='iddep1'>Departamento:</label>
                    <input type='hidden' name='ubigeo1' id='ubigeo1' value='<?php echo !empty(form_error("ubigeo1"))? set_value('ubigeo1') : $registro[0]->ubigeo1;?>'>
                    <select class='custom-select d-block w-100' name='iddep1' id='iddep1' onchange='cambiardep(1,"required");' required>
                        <option value=''>Seleccione...</option>
                        <?php foreach($departamentos as $departamento):?>
                            <option value='<?php echo $departamento->iddep; ?>' <?php echo ($departamento->iddep==substr($registro[0]->ubigeo1,0,2)?'selected':''); ?>><?php echo $departamento->desdep; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="idprov1">Provincia:</label>
                    <div id="prov1">
                        <select class="custom-select d-block w-100" name="idprov1" id="idprov1" onchange="cambiarprov(1,'required');" required>
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
                    <input type="text" class="form-control" name="direccion" value="<?php echo $registro[0]->direccion; ?>" maxlength=80 required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="barrio">Barrio/Urbanización:</label>
                    <input type="text" class="form-control" name="barrio" value="<?php echo $registro[0]->barrio; ?>" maxlength=40>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for='iddep2'>Departamento:</label>
                    <input type='hidden' name='ubigeo2' id='ubigeo2' value='<?php echo !empty(form_error("ubigeo2"))? set_value('ubigeo2') : $registro[0]->ubigeo2;?>'>
                    <select class='custom-select d-block w-100' name='iddep2' id='iddep2' onchange='cambiardep(2,"required");' required>
                        <option value=''>Seleccione...</option>
                        <?php foreach($departamentos as $departamento):?>
                            <option value='<?php echo $departamento->iddep; ?>' <?php echo ($departamento->iddep==substr($registro[0]->ubigeo2,0,2)?'selected':''); ?>><?php echo $departamento->desdep; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="idprov2">Provincia:</label>
                    <div id="prov2">
                        <select class="custom-select d-block w-100" name="idprov2" id="idprov2" onchange="cambiarprov(2,'required');" required>
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
                    <input type="text" class="form-control" name="claboral" value="<?php echo $registro[0]->claboral; ?>" maxlength=200>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for='iddep3'>Departamento:</label>
                    <input type='hidden' name='ubigeo3' id='ubigeo3' value='<?php echo !empty(form_error("ubigeo3"))? set_value('ubigeo3') : $registro[0]->ubigeo3;?>'>
                    <select class='custom-select d-block w-100' name='iddep3' id='iddep3' onchange='cambiardep(3,"");'>
                        <option value=''>Seleccione...</option>
                        <?php foreach($departamentos as $departamento):?>
                            <option value='<?php echo $departamento->iddep; ?>' <?php echo ($departamento->iddep==substr($registro[0]->ubigeo3,0,2)?'selected':''); ?>><?php echo $departamento->desdep; ?></option>
                        <?php endforeach;?>
                    </select>

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="idprov3">Provincia:</label>
                    <div id="prov3">
                        <select class="custom-select d-block w-100" name="idprov3" id="idprov3" onchange="cambiarprov(3,'');">
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
                    <input type="text" class="form-control" name="ref_urgencia" value="<?php echo $registro[0]->ref_urgencia; ?>" maxlength=100 required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="dir_urgencia">Dirección:</label>
                    <input type="text" class="form-control" name="dir_urgencia" value="<?php echo $registro[0]->dir_urgencia; ?>" maxlength=80>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="telefono_urgencia">Nº Teléfono:</label>
                    <input type="text" class="form-control" name="telefono_urgencia" value="<?php echo $registro[0]->telefono_urgencia; ?>" maxlength=20 required>
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
                    <input type="text" class="form-control" name="conyugue_dni" id="conyugue_dni" value="<?php echo $registro[0]->conyugue_dni; ?>" maxlength=8>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="conyugue_paterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" name="conyugue_paterno" id="conyugue_paterno" value="<?php echo $registro[0]->conyugue_paterno; ?>" maxlength=25>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="conyugue_materno">Apellido Materno:</label>
                    <input type="text" class="form-control" name="conyugue_materno" id="conyugue_materno" value="<?php echo $registro[0]->conyugue_materno; ?>" maxlength=25>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="conyugue_nombres">Nombres:</label>
                    <input type="text" class="form-control" name="conyugue_nombres" id="conyugue_nombres" value="<?php echo $registro[0]->conyugue_nombres; ?>" maxlength=30>
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
                    <label for="buscar_univ1">Universidad de Estudio (buscar y seleccionar):</label>
                    <input type="hidden" name="iduniv1" id="iduniv1" value="<?php echo $registro[0]->iduniv_egreso; ?>" required>
                    <input type="text" class="form-control" name="buscar_univ1" id="buscar_univ1" value="<?php echo $registro[0]->universidad1; ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="semestre_ingreso">Ingreso (Ej. 2015-I):</label>
                    <input type="text" class="form-control" name="semestre_ingreso" value="<?php echo $registro[0]->semestre_ingreso; ?>" maxlength=7>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="semestre_egreso">Egreso (Ej. 2019-II):</label>
                    <input type="text" class="form-control" name="semestre_egreso" value="<?php echo $registro[0]->semestre_egreso; ?>" maxlength=7>
                </div>
            </div>
        </div>
        <div class="row">                        
            <div class="col-md-4">
                <div class="form-group">
                    <label for="buscar_univ2">Universidad de título (buscar y selec.):</label>
                    <input type="hidden" name="iduniv2" id="iduniv2" value="<?php echo $registro[0]->iduniv_titulo; ?>" required>
                    <input type="text" class="form-control" name="buscar_univ2" id="buscar_univ2" value="<?php echo $registro[0]->universidad2; ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="num_resolucion">Resolución Rectoral Nº:</label>
                    <input type="text" class="form-control" name="num_resolucion" value="<?php echo $registro[0]->num_resolucion; ?>" maxlength=40>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="fecha_titulo">Fecha:</label>
                    <input type="date" class="form-control" name="fecha_titulo" value="<?php echo $registro[0]->fecha_titulo; ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="num_titulo">Título Nº:</label>
                    <input type="text" class="form-control" name="num_titulo" value="<?php echo $registro[0]->num_titulo; ?>" maxlength=20>
                </div>
            </div>

        </div>
        <br>
        <div class="alert alert-primary" style="background: #0a3080; padding: 10px; color: #fff;" role="alert">TEMAS O AREAS DE ESPECIALIZACIÓN</div>
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
                <div id="espe"><select class="custom-select d-block w-100" name="espec2[]" id="espec2" multiple size="6" style="width:160px" required></select></div>
            </div>

        </div>  
        <br>
        <div class="row">
            <div class="col-md-12">
                <label for="obs">¿Que cursos de especialización son de sus interés?:</label>
                <textarea class='form-control' id="obs" name="obs" rows="3"><?php echo $registro[0]->obs; ?></textarea>
            </div>
        </div>  


        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="checkbox">
                        <label><input type="checkbox" value="" required> <strong>Acepto</strong>, <small>toda la información contenida en el presente formulario para la actualización de mis datos como miembro de la orden en el CDR XVI Puno, hacen referencia a documentos auténticos con valor legal, está de acuerdo a lo establecido en la Ley Nº13253, Ley Nº28951 y la Ley Nº30220 (Ley Universitaria) y normas conexas, en caso contrario me someto a las sanciones de Ley.</small></label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success btn-lg btn-block" onclick=seleccionarTodo();>Actualizar mis Datos</button>
            </div>
            <div class="col-md-4"></div>
        </div>    
        </form>
    </div>

    <br><br><br><br>

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

    function cambiardep(num, flag_obligatorio){
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

            html = "";
            html += "<select class='custom-select d-block w-100' name='idprov"+n+"' id='idprov"+n+"' onchange='cambiarprov("+n+","+flag_obligatorio+");' "+flag_obligatorio+">";
            html += "<option value=''>Seleccione...</option>";
            for (var i=0; i < registros.length; i++) {
                html += "<option value='"+registros[i].idprov+"' " + (registros[i].idprov==var_idprov?'selected':'') + ">"+registros[i].desprov+"</option>";
            }
            html += "</select>";
            
            $('#prov'+n).empty();
            $('#prov'+n).append(html);

            html = "";
            html += "<select class='custom-select d-block w-100' name='iddist"+n+"' id='iddist"+n+"'>";
            html += "<option value=''>Seleccione...</option>";
            html += "</select>";

            $('#dist'+n).empty();
            $('#dist'+n).append(html);

        }
        }); 
    }

    function cambiarprov(num, flag_obligatorio){
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
            html += "<select class='custom-select d-block w-100' name='iddist"+n+"' id='iddist"+n+"' "+flag_obligatorio+">";
            html += "<option value=''>Seleccione...</option>";
            for (var i=0; i < registros.length; i++) {
                html += "<option value='"+registros[i].iddist+"' " + (registros[i].iddist==var_iddist?'selected':'') + ">"+registros[i].desdist+"</option>";
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



    $( document).ready(function() {
        cambiardep(1);
        cambiarprov(1);
        cambiardep(2);
        cambiarprov(2);
        cambiardep(3);
        cambiarprov(3);
        
    });

</script>
