<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificado_model extends CI_Model {

    public function getCertificado($id)
    {
        $query = "select p.dni, concat(p.nombres,' ',p.paterno,' ',p.materno) nombre, c.descurso, c.detalle, c.destipo, c.fecha, c.horas, c.creditos, i.prefijo, i.reg, i.clave, r.obs obsrol, c.idformato, c.totalhoras, c.lugar_fecha ";
        $query .= "from inscritos i ";
        $query .= "left join rolinscrito r on r.idrol = i.idrol ";
        $query .= "left join curso c on c.curso_idnumber = i.curso_idnumber ";
        $query .= "left join participante p on p.dni = i.dni ";
        $query .= "where concat(i.reg,i.clave)='$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }

    public function getConsulta($codigo)
    {
     
        $query = "select a.nummat matricula, a.dni, concat(a.paterno,' ',a.materno,' ',a.nombres) nombre, a.fecha_incorpora ";
        $query .= "from agremiado a ";
        $query .= "where (a.nummat = '$codigo' or a.dni = '$codigo')";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }

    public function getHabil($matricula)
    {
     
        $query = "SELECT max(vd.cuotas) ultimo ";
        $query .= "FROM ventadetalle vd ";
        $query .= "LEFT JOIN venta v ON v.idventa = vd.idventa ";
        $query .= "LEFT JOIN agremiado a ON a.idagremiado = v.idagremiado ";
        $query .= "WHERE a.nummat = '$matricula' AND vd.idconcepto = '1' "; 

        $resultado = $this->db->query($query);
        $row = $resultado->row();

        if(!is_null($row->ultimo)){
            $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
            $anio = substr($row->ultimo, 0, 4);
            $idmes = substr($row->ultimo, -2);
            $mes = $meses[intval($idmes)-1];
        }else{
            $mes="";
            $anio="";
        }

        return $mes.$anio;

    }

}
