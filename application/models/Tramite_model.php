<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tramite_model extends CI_Model {


    public function acceso($registro, $clave)
    {
        $query = "select idregistro ";
        $query .= "from tramite_registro ";
        $query .= "where idregistro='".$registro."' and clave='".$clave."'";

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
        $query = "SELECT r.idregistro, r.asunto, DATE_FORMAT(r.hora_recepcion, '%d-%m-%Y %H:%i:%s') hora_recepcion, concat(td.destdoct,': ',t.destupa) doc, concat(r.nombres,' ',r.paterno,' ',r.materno) interesado, e.desestado ";
        $query .= "FROM tramite_registro r ";
        $query .= "LEFT JOIN tramite_tupa t ON t.idtupa = r.idtupa ";
        $query .= "LEFT JOIN tramite_tdoctramite td ON td.idtdoct = t.idtdoct ";
        $query .= "LEFT JOIN tramite_estado e ON e.idestado = r.idestado ";
        $query .= "WHERE r.idregistro = '$id'";

        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getMovimiento($id)
    {
        $query = "SELECT mov.idmov, DATE_FORMAT(mov.hora_tramite, '%d-%m-%Y %H:%i:%s') hora_tramite, DATE_FORMAT(mov.hora_recepcion, '%d-%m-%Y %H:%i:%s') hora_recepcion, DATE_FORMAT(mov.hora_atencion, '%d-%m-%Y %H:%i:%s') hora_atencion, mov.numero_proveido, mov.obs, ofi1.desoficina origen, ofi2.desoficina destino, est.desestado, mov.obs etiqueta ";
        $query .= "FROM tramite_movimiento mov ";
        $query .= "LEFT JOIN tramite_oficina ofi1 ON ofi1.idoficina = mov.idoficina_origen ";
        $query .= "LEFT JOIN tramite_oficina ofi2 ON ofi2.idoficina = mov.idoficina_destino ";
        $query .= "LEFT JOIN tramite_estado est ON est.idestado = mov.idestado ";
        $query .= "WHERE mov.idregistro = '$id' ";
        $query .= "ORDER BY mov.idmov";

        $resultados = $this->db->query($query);
        return $resultados->result();
    }


    public function getTupa()
    {
        $query = "select * from tramite_tupa where flag='T'";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getTareas()
    {
        $query = "select * from tarea where flag='T'";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getTdocumentos()
    {
        $query = "select * from tramite_tdoctramite";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getDocumento($id)
    {
        $query = "SELECT concat(td.destdoct,': ',t.destupa,' ',t.obs) doc ";
        $query .= "FROM tramite_registrono rn ";
        $query .= "LEFT JOIN tramite_tupa t ON t.idtupa = rn.idtupa ";
        $query .= "LEFT JOIN tramite_tdoctramite td ON td.idtdoct = t.idtdoct ";
        $query .= "WHERE rn.idreg = '$id'";

        $resultados = $this->db->query($query);
        return $resultados->result();
    }
    
    public function getFinalizado($id)
    {
        $query = "SELECT idregistro, clave, DATE_FORMAT(hora_recepcion, '%d/%m/%Y %H:%i:%s') hora_recepcion ";
        $query .= "FROM tramite_registro ";
        $query .= "WHERE idreg = '$id'";

        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getRequisitos($id)
    {
        $query = "SELECT tr.idrequisito, r.desrequisito, r.tipoarchivo, r.tipo ";
        $query .= "FROM tramite_tuparequisito tr ";
        $query .= "LEFT JOIN tramite_tupa t ON t.idtupa = tr.idtupa ";
        $query .= "LEFT JOIN tramite_requisito r ON r.idrequisito = tr.idrequisito ";
        $query .= "WHERE tr.idtupa = '$id' ";
        $query .= "order by tr.idrequisito";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getRegistros($data)
	{
        $anio = $this->session->userdata("anio");

        $pagina = $data['pagina'];
        $registro = $data['registro'];
        $fecha = $data['fecha'];
        $numdoc = $data['numdoc'];
        $asunto = $data['asunto'];

        $cantidad = 20;

        if ($pagina == 1) {
            $inicio = 0;
        }
        else {
            $inicio = ($pagina - 1) * $cantidad;
        }
    
        $query = "select count(*) numreg from registro ";
        $query .= "where idregistro like '$registro%' and fecha like '$fecha%' and num_doc like '$numdoc' and asunto like '$asunto%'";
        $resultado = $this->db->query($query);
        $row = $resultado->row();
        $total = $row->numreg;

        $query = "select r.idregistro id, r.fecha, r.asunto, r.tpresentacion, r.tipotramite, t.destupa, i.nombre, o.desoficina, e.desestado ";
        $query .= "from registro r ";
        $query .= "left join estado e on e.idestado = r.idestado ";
        $query .= "left join tupa t on t.idtupa = r.idtupa ";
        $query .= "left join interesado i on i.idinteresa = r.idinteresa ";
        $query .= "left join oficina o on o.idoficina = r.idoficina ";
        $query .= "where r.idregistro like '$registro%' and r.fecha like '$fecha%' and r.num_doc like '$numdoc%' and r.asunto like '$asunto%'";
        $query .= "order by r.idregistro limit $inicio, $cantidad";

        $resultados = $this->db->query($query);
        
        $total_paginas = ceil($total / $cantidad);
        $num_paginas = 0;
        $paginas = array();

        if($total_paginas > 5){
            if($pagina <= 5) 
                $jj = 1;
            else
                $jj=$pagina-2;

            for($j=0; $j < 5; $j++){
                $paginas[$j] = array('p' => $jj++);
                $num_paginas++;
            }
        }else{
            for($j=0; $j<$total_paginas; $j++){
                $paginas[$j] = array('p' => $j+1);
                $num_paginas++;
            }
        }

        $output = array(
            'registros'=>$resultados->result(),
            'paginas'=>$paginas,
            'actual'=> $pagina-0,
            'num_paginas'=> $num_paginas,
            'total'=>$total_paginas
        );
       
        return $output;
	}
    
    public function insertno($data){

        $tpersona = $data['tpersona'];
        $numdoc = $data['numdoc'];
        $paterno = strtoupper($data['paterno']);
        $materno = strtoupper($data['materno']);
        $nombres = strtoupper($data['nombres']);
        $email = strtolower($data['email']);
        $celular = $data['celular'];
        $numero_documento = $data['numero_documento'];
        $fecha_documento = $data['fecha_documento'];
        $asunto = strtoupper($data['asunto']);
        $obs = $data['obs'];
        $idtupa = $data['idtupa'];

        $query = "insert into tramite_registrono (tpersona, numdoc, paterno, materno, nombres, email, celular, numero_documento, fecha_documento, asunto, obs, idtupa, estado) ";
        $query .= "values('$tpersona','$numdoc','$paterno','$materno','$nombres','$email','$celular','$numero_documento','$fecha_documento','$asunto','$obs','$idtupa','1')";
        
        $this->db->query($query);
        
        return $this->db->insert_id();

    }

    public function insert($id){
        $query = "select * from tramite_registrono where idreg='$id'";
        $resultado = $this->db->query($query);
        $row = $resultado->row();

        $tpersona = $row->tpersona;
        $numdoc = $row->numdoc;
        $paterno = $row->paterno;
        $materno = $row->materno;
        $nombres = $row->nombres;
        $email = $row->email;
        $celular = $row->celular;
        $numero_documento = $row->numero_documento;
        $fecha_documento = $row->fecha_documento;
        $asunto = $row->asunto;
        $obs = $row->obs;
        $idtupa = $row->idtupa;

        $this->load->library('utilitarios');
        $util = new Utilitarios();
        $clave = $util->generar_clave(5);

        $query = "insert into tramite_registro (fecha,clave,tpersona, numdoc, paterno, materno, nombres, email, celular, numero_documento, fecha_documento, asunto, obs, idtupa, idreg,tpresentacion,tipotramite,idoficina,idestado) ";
        $query .= "values(CURRENT_DATE,'$clave','$tpersona','$numdoc','$paterno','$materno','$nombres','$email','$celular','$numero_documento','$fecha_documento','$asunto','$obs','$idtupa','$id','NO-PRESENCIAL','EXTERNO','1','1')";
        
        $this->db->query($query);
        
        return $this->db->insert_id();

    }

    public function insert_requisito($data){
        
        $id = $data['id'];
        $idrequisito = $data['idrequisito'];
        $tipo = $data['tipo'];
        $extension = $data['extension'];
        $voucher = $data['voucher'];
        $fecha = $data['fecha'];
        $importe = $data['importe'];
        
        $query = "insert into tramite_registrorequisito (idregistro,idrequisito,tipo,voucher,fecha,importe,extension) ";
        $query .= "values('$id','$idrequisito','$tipo','$voucher','$fecha','$importe','$extension')";
        
        $this->db->query($query);
    }

}

