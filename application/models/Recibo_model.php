<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recibo_model extends CI_Model {


    public function ultimoID()
	{
        $query = "select max(idrecibo) ultimo from recibo";
        $resultado = $this->db->query($query);
        $row = $resultado->row();

        return $row->ultimo;
    }
    
    public function getRegistros($data)
	{
     
        $anio = $this->session->userdata("anio");

        $ini = $data['inicio'];
        $numero = $data['numero'];

        // Paginacion
        //-----------------------------------------------------------------------------------------------------------------------------------
        $query = "select count(*) numreg from recibo ";
        $query .= "where anio='$anio' and numero like '$numero%' ";

        $resultado = $this->db->query($query);
        $row = $resultado->row();
        $total = $row->numreg;

        $inicio = $ini;
        $cantidad = 20;

        $ini = 1;
        $fin = $cantidad;
        $page = 0;
        $pag_actual = 0;                                # pagina actual
        while(true){
            if($fin>$total)$fin=$total;
            $d=false; 
            if($ini==$inicio){
                $d=true;
                $pag_actual = $page;
            }
            $botones[$page]=array('ini'=>$ini,'d'=>$d);
            if($fin>=$total)break;

            $ini = $fin+1;
            $fin = $fin+$cantidad;
            
            $page++;
        }
        
        # creamos una variable si hay mas de 6 paginas
        $indice_alt = null;
        if($page>7){
            # en este caso solo mostramos 2 a la der e izq, ademas los extremos
            $tmp_indice = array();
            
            if($pag_actual != 0) array_push($tmp_indice, array('ini'=>$botones[0]['ini'],'d'=>false,'num'=>1));
            //if($pag_actual-3>0) array_push($tmp_indice, array('ini'=>$botones[$pag_actual-3]['ini'],'d'=>false,'num'=>$pag_actual-2));
            if($pag_actual-2>0) array_push($tmp_indice, array('ini'=>$botones[$pag_actual-2]['ini'],'d'=>false,'num'=>$pag_actual-1));
            if($pag_actual-1>0) array_push($tmp_indice, array('ini'=>$botones[$pag_actual-1]['ini'],'d'=>false,'num'=>$pag_actual-0));
            
            array_push($tmp_indice, array('ini'=>$botones[$pag_actual]['ini'],'d'=>true,'num'=>$pag_actual+1));
            
            if($pag_actual+1<$page) array_push($tmp_indice, array('ini'=>$botones[$pag_actual+1]['ini'],'d'=>false,'num'=>$pag_actual+2));
            if($pag_actual+2<$page) array_push($tmp_indice, array('ini'=>$botones[$pag_actual+2]['ini'],'d'=>false,'num'=>$pag_actual+3));
            //if($pag_actual+3<$page) array_push($tmp_indice, array('ini'=>$botones[$pag_actual+3]['ini'],'d'=>false,'num'=>$pag_actual+4));
            if($pag_actual != $page) array_push($tmp_indice, array('ini'=>$botones[$page]['ini'],'d'=>false,'num'=>$page+1));
            
            $indice_alt = $tmp_indice;
        }
        //-----------------------------------------------------------------------------------------------------------------------------------

        $query = "select r.idrecibo id, r.anio, concat(r.serie,'-',r.numero) numero, r.fecha, f.desforma, r.total1, r.total2, a.nummat codigo, concat(a.nombres,' ',a.paterno,' ',a.materno) nombre ";
        $query .= "from recibo r ";
        $query .= "left join formapago f on f.idforma = r.idforma ";
        $query .= "left join agremiado a on a.idagremiado = r.idagremiado ";
        $query .= "where r.anio='$anio' and r.numero like '$numero%' ";
        $query .= "order by r.idrecibo desc limit $inicio, $cantidad";

        $resultados = $this->db->query($query);


        # Salida
        $final = $inicio+$cantidad-1;
        if($final>$total)$final=$total;
        if($inicio>$final)$inicio=$final;

        $pagactual = array();

        $output = array(
            'registros'=>$resultados->result(),
            'indice'=>$botones,
            'indice_alt'=>$indice_alt,
            'pagactual'=>$pagactual
        );

        return $output;
	}

    public function getFormapagos()
    {
        $query = "select idforma, desforma ";
        $query .= "from formapago where idforma!='5'";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }

    public function getClientes($valor)
    {
        $query = "select idagremiado id, nummat, dni dni_ruc, concat(paterno,' ',materno,' ',nombres) label ";
        $query .= "from agremiado ";
        $query .= "where nummat like '".$valor."%'";
        $resultados = $this->db->query($query);
        return $resultados->result_array();
    }

    public function getProductos($valor)
    {
        $query = "select idconcepto id, desconcepto label, precio ";
        $query .= "from conceptopago ";
        $query .= "where flag='T' and desconcepto like '%".$valor."%' and precio > 0";
        $resultados = $this->db->query($query);
        return $resultados->result_array();
    }

    public function insert($data){
        $anio = $this->session->userdata("anio");
        $serie = $data['serie'];
        $idcliente = $data['idcliente'];
        $idforma = $data['idforma'];
        $total = $data['total'];
        $glosa = $data['glosa'];

        # Generamos el numero
        $query = "select max(numero) maxnum from recibo where serie='$serie'";
        $resultado = $this->db->query($query);
        $row = $resultado->row();
        $numero = str_pad($row->maxnum + 1, 6, '0', STR_PAD_LEFT);

        $query = "insert into recibo (serie, numero, anio, fecha, idagremiado, idforma, total1, obs) ";
        $query .= "values('$serie','$numero','$anio',CURRENT_DATE,'$idcliente','$idforma','$total','$glosa')";
        return $this->db->query($query);
    }

    public function insert_detalle($data){
        $idrecibo = $data['idrecibo'];
        $idproducto = $data['idproducto'];
        $precio = $data['precio'];
        $cantidad = $data['cantidad'];
        $cuota = $data['cuota'];

        if($idproducto == '5'){
            $query = "select idagremiado from recibo where idrecibo='$idrecibo'";
            $resultado = $this->db->query($query);
            $row = $resultado->row();
            $idagremiado = $row->idagremiado;

            $query = "select max(numero) maxnum from habilidad";
            $resultado = $this->db->query($query);
            $row = $resultado->row();
            $numero = str_pad($row->maxnum + 1, 6, '0', STR_PAD_LEFT);

            $query = "insert into habilidad (fecha, numero, vencimiento, idagremiado) ";
            $query .= "values(CURRENT_DATE,'$numero',DATE(DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH)),'$idagremiado')";
            $this->db->query($query);
        }

        $query = "insert into recibodetalle (idrecibo, idconcepto, precio, cantidad, cuotas) ";
        $query .= "values('$idrecibo','$idproducto','$precio','$cantidad','$cuota')";
        $this->db->query($query);

    }

    public function getVenta($id)
    {
        $query = "select r.idrecibo, '001' serie, r.numero, r.fecha, a.nummat, a.paterno, a.direccion ";
        $query .= "from recibo r ";
        $query .= "left join agremiado a on a.idagremiado = r.idagremiado ";
        $query .= "where r.idrecibo='$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    public function getVentadetalle($id)
    {
        $query = "select c.desconcepto nombre, rd.cantidad, rd.precio ";
        $query .= "from recibodetalle rd ";
        $query .= "left join conceptopago c on c.idconcepto = rd.idconcepto ";
        $query .= "where rd.idrecibo='$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    public function getResumenventa($desde, $hasta)
    {
        $query = "select f.desforma modalidad, c.desconcepto nombre, rd.precio, SUM(rd.cantidad) cantidad ";
        $query .= "FROM recibodetalle rd ";
        $query .= "LEFT join recibo r on r.idrecibo = rd.idrecibo ";
        $query .= "left JOIN conceptopago c on c.idconcepto = rd.idconcepto ";
        $query .= "LEFT JOIN formapago f ON f.idforma = r.idforma ";
        $query .= "WHERE r.fecha BETWEEN '$desde' AND '$hasta' ";
        $query .= "GROUP BY r.idforma, c.desconcepto, rd.precio ";
        $query .= "ORDER BY f.desforma, c.desconcepto";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }


    public function getReportegeneral($desde, $hasta)
    {
             
        $query = "SELECT tcb.destipocomp, cb.serie, v.numero, v.fecha, cli.nombre, sum(vd.precio*vd.cantidad) total, tp.destipopago ";
        $query .= "FROM ventadetalle vd ";
        $query .= "LEFT join venta v on v.idventa = vd.idventa ";
        $query .= "LEFT join comprobante cb on cb.idcomprobante = v.idcomprobante ";
        $query .= "LEFT JOIN tipocomprobante tcb on tcb.idtipocomprob = cb.idtipocomprob ";
        $query .= "left JOIN cliente cli on cli.idcliente = v.idcliente ";
        $query .= "LEFT JOIN tipopago tp ON tp.idtipopago = v.idtipopago ";
        $query .= "WHERE v.fecha BETWEEN '$desde' AND '$hasta' ";
        $query .= "GROUP BY tcb.destipocomp, cb.serie, v.idtipopago, v.numero ";
        $query .= "ORDER BY tcb.destipocomp, cb.serie, v.numero";



        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    public function getReportedetalle($desde, $hasta)
    {
             
        $query = "SELECT tcb.destipocomp, cb.serie, v.numero, v.fecha, cli.nombre cliente, c.nombre, vd.precio, vd.cantidad, tp.destipopago ";
        $query .= "FROM ventadetalle vd ";
        $query .= "LEFT join catalogo c on c.idcatalogo = vd.idcatalogo ";
        $query .= "LEFT join venta v on v.idventa = vd.idventa ";
        $query .= "LEFT join comprobante cb on cb.idcomprobante = v.idcomprobante ";
        $query .= "LEFT JOIN tipocomprobante tcb on tcb.idtipocomprob = cb.idtipocomprob ";
        $query .= "left JOIN cliente cli on cli.idcliente = v.idcliente ";
        $query .= "LEFT JOIN tipopago tp ON tp.idtipopago = v.idtipopago ";
        $query .= "WHERE v.fecha BETWEEN '$desde' AND '$hasta' ";
        $query .= "GROUP BY tcb.destipocomp, cb.serie, v.idtipopago, v.numero ";
        $query .= "ORDER BY tcb.destipocomp, cb.serie, v.numero";



        $resultado = $this->db->query($query);
        return $resultado->result();
    }














}

