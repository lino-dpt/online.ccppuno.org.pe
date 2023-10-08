<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agremiado_model extends CI_Model {

    public function login($username, $password)
    {
        $query = "select a.idagremiado id, a.dni, a.nombres, concat(a.nombres,' ',a.paterno,' ',a.materno) nombre, flag_actualizar, flag_cambiarclave, flag_subirfoto, extension_foto, nummat ";
        $query .= "from agremiado a ";
        $query .= "where a.flag_app='T' and a.login='".$username."' and a.password='".$password."'";

        $resultados = $this->db->query($query);

        $reg = "";
        if($resultados->num_rows() > 0){
            $flag = true;
            $reg = $resultados->row();
        }else{
            $flag = false;
        }

        $output = array(
            'flag'=> $flag,
            'registro'=> $reg
        );

        return $output;  
    }

    public function getRegistro($id)
    {
     
        $query = "select a.idagremiado id, a.nummat, a.dni, concat(a.paterno,' ',a.materno,' ',a.nombres) nombre, a.email, a.direccion, a.movil, a.fijo, a.barrio, a.ubigeo2, a.ubigeo3, a.ref_urgencia, a.dir_urgencia, a.telefono_urgencia, a.claboral, if(concat(substring(DATE_SUB(CURRENT_DATE,INTERVAL 2 MONTH),1,4),substring(DATE_SUB(CURRENT_DATE,INTERVAL 2 MONTH),6,2))>substring(ultimopago,1,6),'NO','SI') flag, current_timestamp hora, a.paterno, a.materno, a.nombres ";
        $query .= "from agremiado a ";
        $query .= "where a.idagremiado = '$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }


    public function getTodosdatos($id)
    {
     
        $query = "select a.*, u1.desuniv universidad1, u2.desuniv universidad2 ";
        $query .= "from agremiado a ";
        $query .= "left join universidad u1 on u1.iduniv = a.iduniv_egreso ";
        $query .= "left join universidad u2 on u2.iduniv = a.iduniv_titulo ";
        $query .= "where a.idagremiado = '$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }

	public function buscarRegistro($tipo, $codigo)
	{
        $query = "select idcliente id, numdoc, nombre ";
        $query .= "from cliente ";
        $query .= "where idtcliente='$tipo' and numdoc='$codigo' limit 1"; 

        $resultado = $this->db->query($query);
        return $resultado->result();
        
	}


    public function update($data){

        $id = $this->session->userdata("id");

        $dni = $data['dni'];
        $ruc = $data['ruc'];
        $genero = $data['genero'];
        $estadocivil = $data['estadocivil'];
        $nacionalidad = $data['nacionalidad'];
        $paterno = strtoupper($data['paterno']);
        $materno = strtoupper($data['materno']);
        $nombres = strtoupper($data['nombres']);
        $email = strtolower($data['email']);
        $fijo = $data['fijo'];
        $movil = $data['movil'];
        $fnacim = $data['fnacim'];
        $lugar_nacim = strtoupper($data['lugar_nacim']);
        $iddist1 = $data['iddist1'];
        $direccion = strtoupper($data['direccion']);
        $barrio = strtoupper($data['barrio']);
        $iddist2 = $data['iddist2'];
        $claboral = strtoupper($data['claboral']);

        $iddist3 = ($data['iddist3']==''?"NULL":"'".$data['iddist3']."'");
        
        $ref_urgencia = strtoupper($data['ref_urgencia']);
        $dir_urgencia = strtoupper($data['dir_urgencia']);
        $telefono_urgencia = $data['telefono_urgencia'];
        $iduniv1 = $data['iduniv1'];
        $semestre_ingreso = strtoupper($data['semestre_ingreso']);
        $semestre_egreso = strtoupper($data['semestre_egreso']);
        $iduniv2 = $data['iduniv2'];
        $num_resolucion = strtoupper($data['num_resolucion']);
        $fecha_titulo = $data['fecha_titulo'];
        $num_titulo = $data['num_titulo'];
        $conyugue_dni = $data['conyugue_dni'];
        $conyugue_paterno = $data['conyugue_paterno'];
        $conyugue_materno = $data['conyugue_materno'];
        $conyugue_nombres = $data['conyugue_nombres'];

        $obs = $data['obs'];
       

        $query = "update agremiado set ";
        $query .= "flag_actualizar = 'F', ";
        $query .= "dni = '$dni', ";
        $query .= "ruc = '$ruc', ";
        $query .= "genero = '$genero', ";
        $query .= "idecivil = '$estadocivil', ";
        $query .= "idnacional = '$nacionalidad', ";
        $query .= "paterno = '$paterno', ";
        $query .= "materno = '$materno', ";
        $query .= "nombres = '$nombres', ";
        $query .= "email = '$email', ";
        $query .= "fijo = '$fijo', ";
        $query .= "movil = '$movil', ";
        $query .= "fecha_nacimiento = '$fnacim', ";
        $query .= "lugar_nacim = '$lugar_nacim', ";
        $query .= "ubigeo1 = '$iddist1', ";
        $query .= "direccion = '$direccion', ";
        $query .= "barrio = '$barrio', ";
        $query .= "ubigeo2 = '$iddist2', ";
        $query .= "claboral = '$claboral', ";
        $query .= "ubigeo3 = ".$iddist3.", ";
        $query .= "ref_urgencia = '$ref_urgencia', ";
        $query .= "dir_urgencia = '$dir_urgencia', ";
        $query .= "telefono_urgencia = '$telefono_urgencia', ";
        $query .= "iduniv_egreso = '$iduniv1', ";
        $query .= "semestre_ingreso = '$semestre_ingreso', ";
        $query .= "semestre_egreso = '$semestre_egreso', ";
        $query .= "iduniv_titulo = '$iduniv2', ";
        $query .= "num_resolucion = '$num_resolucion', ";
        $query .= "fecha_titulo = '$fecha_titulo', ";
        $query .= "num_titulo = '$num_titulo', ";
        $query .= "conyugue_dni = '$conyugue_dni', ";
        $query .= "conyugue_paterno = '$conyugue_paterno', ";
        $query .= "conyugue_materno = '$conyugue_materno', ";
        $query .= "conyugue_nombres = '$conyugue_nombres', ";
        $query .= "obs = '$obs' ";
        $query .= "where idagremiado='$id'";

        $this->session->set_userdata('actualizar_datos','F');

        return $this->db->query($query);
             

    }

    public function insert_hijos($data){
        $idregistro = $data['idregistro'];
        $dni = $data['dni'];
        $paterno = $data['paterno'];
        $materno = $data['materno'];
        $nombres = $data['nombres'];
        $fecha = $data['fecha'];

        $query = "insert into agremiadohijos (idagremiado, dni, paterno, materno, nombres, fecha_nacimiento) ";
        $query .= "values('$idregistro','$dni','$paterno','$materno','$nombres','$fecha')";
        return $this->db->query($query);
    }

    public function insert_especs($data){
        $idregistro = $data['idregistro'];
        $idespec = $data['idespec'];

        $query = "insert into agremiadoespec (idagremiado, idespec) ";
        $query .= "values('$idregistro','$idespec')";
        return $this->db->query($query);
    }

    /*public function update($data){

        $id = $this->session->userdata("id");

        $email = strtolower($data['email']);
        $fijo = $data['fijo'];
        $movil = $data['movil'];
        $direccion = strtoupper($data['direccion']);
        $barrio = strtoupper($data['barrio']);
        $iddist2 = $data['iddist2'];
        $claboral = strtoupper($data['claboral']);
        $iddist3 = $data['iddist3'];
        $ref_urgencia = strtoupper($data['ref_urgencia']);
        $dir_urgencia = strtoupper($data['dir_urgencia']);
        $telefono_urgencia = $data['telefono_urgencia'];

        $query = "update agremiado set ";
        $query .= "email = '$email', ";
        $query .= "fijo = '$fijo', ";
        $query .= "movil = '$movil', ";
        $query .= "direccion = '$direccion', ";
        $query .= "barrio = '$barrio', ";
        $query .= "ubigeo2 = '$iddist2', ";
        $query .= "claboral = '$claboral', ";
        $query .= "ubigeo3 = '$iddist3', ";
        $query .= "ref_urgencia = '$ref_urgencia', ";
        $query .= "dir_urgencia = '$dir_urgencia', ";
        $query .= "telefono_urgencia = '$telefono_urgencia' ";
        $query .= "where idagremiado='$id'";

        return $this->db->query($query);
    }*/

    public function cambiar($data){

        $id = $this->session->userdata("id");
        
        $anterior = sha1($data['anterior']);
        $nuevo = sha1($data['nuevo']);


        $query = "select * ";
        $query .= "from agremiado ";
        $query .= "where idagremiado='$id' and password='$anterior'";
        $resultados = $this->db->query($query);

        if($resultados->num_rows() > 0){
            $query = "update agremiado set ";
            $query .= "password = '$nuevo', ";
            $query .= "flag_cambiarclave = 'F' ";
            $query .= "where idagremiado='$id' and password='$anterior'";
            $this->db->query($query);

            $this->session->set_userdata('cambiar_clave','F');

            $flag = true;
            $msg = "La contraseña se ha cambiado correctamente.";
        }else{
            $flag = false;
            $msg = "La contraseña anterior no coincide.";
        }

        $output = array(
            'flag'=> $flag,
            'msg'=> $msg
        );

        return $output;  

    }

    public function getColegiado($id)
    {
        $query = "select a.dni, concat(a.prefijo,'-',a.nummat) matricula, a.fecha_incorpora, concat(a.paterno,' ',a.materno,' ',a.nombres) nombre, e.desestado ";
        $query .= "from agremiado a ";
        $query .= "left join estadoagremiado e on e.idestado = a.idestado ";
        $query .= "where concat(a.prefijo,'-',a.nummat,a.clave)='$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }

    public function getEstadocivil()
    {
        $query = "select * from estadocivil";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }


    public function setSubirfoto($id,$extension){

        $query = "update agremiado set flag_subirfoto = 'F', extension_foto='$extension' where idagremiado = '$id'";
        $this->db->query($query);
    }

    public function getHistorialpagos($id)
    {
        $query = "select v.anio, v.fecha, v.idserie, v.numero, c.desconcepto nombre, vd.cantidad, vd.precio, vd.obs ";
        $query .= "from ventadetalle vd ";
        $query .= "left join venta v on v.idventa = vd.idventa ";
        $query .= "left join conceptopago c on c.idconcepto = vd.idconcepto ";
        $query .= "where v.idagremiado='$id' ";
        $query .= "order by v.anio desc, v.fecha desc ";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

}

