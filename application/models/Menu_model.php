<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

	public function getMenu()
	{
		# Seleccionamos todos los menus
		$query  = "select idmenuapp, desmenuapp ";
		$query .= "from menuapp ";
        $query .= "where flag='T' order by orden";
        
        $menus = $this->db->query($query);

		$i=0; // Cantidad de menus
        $lista = array();
        foreach ($menus->result() as $menu){
			$idmenuapp = $menu->idmenuapp;
			$desmenuapp = $menu->desmenuapp;

            $query  = "select A.dessmenuapp, A.action, 'w' acceso ";
            $query .= "from smenuapp as A ";
            $query .= "where ";
            $query .= "A.flag='T' and ";
            $query .= "A.idmenuapp='$idmenuapp' order by A.orden";

            $submenus = $this->db->query($query);
			
			$j = 0; // Cantidad de submenus por menu
            $sublista = array();
            foreach ($submenus->result() as $submenu){
				$sublista[$j] = array(
					'dessmenuapp'=>$submenu->dessmenuapp,
					'action'=>$submenu->action
					);
				$j++;
			}
			if($j!=0){
				$lista[$i] = array(
					'desmenuapp'=>$desmenuapp,
					'items'=>$sublista
					);
				$i++;	
			}
        }
        
        return json_encode($lista);

		//echo json_encode($lista);

        /*$query = "select m.desmenuapp, sm.dessmenuapp ";
        $query .= "from menuapp m "; 
        $query .= "left join smenuapp sm on sm.idmenuapp = m.idmenuapp "; 
        $query .= "where m.flag='T' and sm.flag = 'T'";

        $resultados = $this->db->query($query);
        return $resultados->result();*/






    }

}

