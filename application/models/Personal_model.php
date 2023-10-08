<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal_model extends CI_Model {

    public function getRegistros()
    {
        $query = "select u.idusuario id, u.login, u.nombre, r.desrol ";
        $query .= "from usuario u ";
        $query .= "left join rol r on r.idrol = u.idrol";

        $resultados = $this->db->query($query);
        return $resultados->result();
    }

	public function login($username, $password)
	{
        $query = "select p.idpersonal id, p.dni, p.nombres, concat(p.nombres,' ',p.materno,' ',p.materno) nombre, r.desrol, o.idoficina, o.desoficina ";
        $query .= "from personal p ";
        $query .= "left join rol r on r.idrol = p.idrol ";
        $query .= "left join oficina o on o.idoficina = p.idoficina ";
        $query .= "where p.flag_web='T' and p.dni='".$username."' and clave='".$password."'";

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

}
