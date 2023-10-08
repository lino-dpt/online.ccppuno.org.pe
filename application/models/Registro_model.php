<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro_model extends CI_Model {

    public function getID($id)
    {
        $clave = substr($id,0,3);
        $idreg = substr($id,3);

        $query = "select idregistro id ";
        $query .= "from registro ";
        $query .= "where idregistro='$idreg' and clave='$clave'";

        $resultado = $this->db->query($query);
        return $resultado->row();

        
    }

    public function getNacionalidades()
	{
        $query = "select * from nacionalidad where flag='T'";
        $resultados = $this->db->query($query);
        return $resultados->result();
	}

    public function getEspecialidades()
    {
        $query = "select * from especializacion";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getUniversidades($valor)
	{
        $query = "select iduniv id, desuniv label from universidad where desuniv like '%$valor%' order by desuniv";
        $resultados = $this->db->query($query);
        return $resultados->result_array();
	}

    public function insert($data){
        $dni = $data['dni'];
        $ruc = $data['ruc'];
        $genero = $data['genero'];
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
        $clave = $data['clave'];
        

        $query = "insert into registro (dni, ruc, genero, idnacional, paterno, materno, nombres, email, fijo, movil, fecha_nacimiento, lugar_nacim, ubigeo1, direccion, barrio, ubigeo2, claboral, ubigeo3, ref_urgencia, dir_urgencia, telefono_urgencia, iduniv_egreso, semestre_ingreso, semestre_egreso, iduniv_titulo, num_resolucion, fecha_titulo, num_titulo, conyugue_dni, conyugue_paterno, conyugue_materno, conyugue_nombres, clave) ";
        $query .= "values('$dni','$ruc','$genero','$nacionalidad','$paterno','$materno','$nombres','$email','$fijo','$movil','$fnacim','$lugar_nacim','$iddist1','$direccion','$barrio','$iddist2','$claboral',".$iddist3.",'$ref_urgencia','$dir_urgencia','$telefono_urgencia','$iduniv1','$semestre_ingreso','$semestre_egreso','$iduniv2','$num_resolucion','$fecha_titulo','$num_titulo','$conyugue_dni','$conyugue_paterno','$conyugue_materno','$conyugue_nombres','$clave')";
        
        $this->db->query($query);
        
        return $this->db->insert_id();

    }

    public function insert_hijos($data){
        $idregistro = $data['idregistro'];
        $dni = $data['dni'];
        $paterno = $data['paterno'];
        $materno = $data['materno'];
        $nombres = $data['nombres'];
        $fecha = $data['fecha'];

        $query = "insert into registrohijos (idregistro, dni, paterno, materno, nombres, fecha_nacimiento) ";
        $query .= "values('$idregistro','$dni','$paterno','$materno','$nombres','$fecha')";
        return $this->db->query($query);
    }

    public function insert_especs($data){
        $idregistro = $data['idregistro'];
        $idespec = $data['idespec'];

        $query = "insert into registroespec (idregistro, idespec) ";
        $query .= "values('$idregistro','$idespec')";
        return $this->db->query($query);
    }


    public function getSolicitud($id, $clave)
    {   
        $query = "select r.dni, r.ruc, r.direccion, r.genero, r.paterno, r.materno, r.nombres, n.desnacional1, n.desnacional2, r.hora_insert, concat(u.distrito,'-',u.provincia,'-',u.departamento) lugar,  univ.desuniv uni ";
        $query .= "from registro r ";
        $query .= "left join ubigeo u on u.codigo = r.ubigeo2 ";
        $query .= "left join universidad univ on univ.iduniv = r.iduniv_titulo ";
        $query .= "left join nacionalidad n on n.idnacional = r.idnacional ";
        $query .= "where r.idregistro='$id' and r.clave='$clave'";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    public function getFicha($id, $clave)
    {   

        $query = "select r.*, DATE_FORMAT(r.hora_insert, '%d-%m-%Y %H:%i:%s') hora, n.desnacional1, n.desnacional2, u1.distrito dist1, u1.provincia prov1, u1.departamento dep1, u2.distrito dist2, u2.provincia prov2, u2.departamento dep2, u3.distrito dist3, u3.provincia prov3, u3.departamento dep3, univ1.desuniv uni1, univ2.desuniv uni2 ";
        $query .= "from registro r ";
        $query .= "left join ubigeo u1 on u1.codigo = r.ubigeo1 ";
        $query .= "left join ubigeo u2 on u2.codigo = r.ubigeo2 ";
        $query .= "left join ubigeo u3 on u3.codigo = r.ubigeo3 ";
        $query .= "left join universidad univ1 on univ1.iduniv = r.iduniv_egreso ";
        $query .= "left join universidad univ2 on univ2.iduniv = r.iduniv_titulo ";
        $query .= "left join nacionalidad n on n.idnacional = r.idnacional ";

        $query .= "where r.idregistro='$id' and r.clave='$clave'";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    public function getHijos($id)
    {
        $query = "select rh.dni, rh.paterno, rh.materno, rh.nombres, rh.fecha_nacimiento ";
        $query .= "from registrohijos rh ";
        $query .= "where rh.idregistro='$id'";

        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getEspecs($id)
    {
        $query = "select e.desespec ";
        $query .= "from registroespec re ";
        $query .= "left join especializacion e on e.idespec = re.idespec ";
        $query .= "where re.idregistro='$id'";

        $resultados = $this->db->query($query);
        return $resultados->result();
    }


}

