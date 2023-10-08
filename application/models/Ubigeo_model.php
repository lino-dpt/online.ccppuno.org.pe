<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ubigeo_model extends CI_Model {

	public function getDepartamentos()
	{
        $query = "SELECT distinct SUBSTRING(codigo,1,2) iddep, departamento desdep FROM ubigeo ORDER BY desdep";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }


	public function getProvincias($cod)
	{
        $query = "SELECT distinct SUBSTRING(codigo,1,4) idprov, provincia desprov FROM ubigeo where SUBSTRING(codigo,1,2)='$cod' ORDER BY idprov, desprov";
        $resultados = $this->db->query($query);

		$i=0;
        $lista = array();

        foreach($resultados->result() as $resultado){
			$lista[$i] = array(
				'idprov'=>$resultado->idprov,
				'desprov'=>$resultado->desprov
				);
			$i++;	
        }
        
        return json_encode($lista);
    }

	public function getDistritos($cod)
	{
        $query = "SELECT distinct codigo iddist, distrito desdist FROM ubigeo where SUBSTRING(codigo,1,4)='$cod' ORDER BY iddist, desdist";
        $resultados = $this->db->query($query);

		$i=0;
        $lista = array();

        foreach($resultados->result() as $resultado){
			$lista[$i] = array(
				'iddist'=>$resultado->iddist,
				'desdist'=>$resultado->desdist
				);
			$i++;	
        }
        
        return json_encode($lista);
    }


}

