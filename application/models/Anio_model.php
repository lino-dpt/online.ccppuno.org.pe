<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anio_model extends CI_Model {

    public function getAnios()
    {
        $query = "select anio idanio from anio order by idanio";
        $resultados = $this->db->query($query);
        return $resultados->result();

    }

}
