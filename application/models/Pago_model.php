<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago_model extends CI_Model {

    
    public function getConstancia($clave)
    {
     
        $query = "select h.idhabilidad id, h.numero, h.fecha, concat(prefijo,'-',nummat) matricula, a.dni, concat(a.paterno,' ',a.materno,' ',a.nombres) nombre, a.fecha_incorpora ";
        $query .= "from habilidad h ";
        $query .= "left join agremiado a on a.idagremiado = h.idagremiado ";
        $query .= "where h.clave = '$clave'";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }

    public function getDetalle($id, $anio, $tipo)
    {

        $query = "SELECT v.idventa id, v.anio, v.idserie, concat(v.idserie,'-',v.numero) numero, sum(round(vd.cantidad*vd.precio,2)) importe, DATE_FORMAT(v.fecha, '%d/%m/%Y') fecha, f.desforma, IF(v.idforma='5',v.clave,'') print ";
        $query .= "from ventadetalle vd ";
        $query .= "left join venta v on v.idventa = vd.idventa ";
        $query .= "left join formapago f on f.idforma = v.idforma ";
        $query .= "where v.anio like '$anio%' and v.idagremiado = '$id' and v.idsede like '$tipo%' ";
        $query .= "GROUP BY v.idventa, v.anio, v.idserie, v.numero ";
        $query .= "order by v.anio, v.idserie, v.numero desc";


        $resultados = $this->db->query($query);

        $output = array(
            'registros'=>$resultados->result()
        );

        return $output;

    }

    public function getPendiente($id)
    {

        $query = "SELECT pd.idpago id, DATE_FORMAT(pd.hora,'%d/%m/%Y %H:%i:%s') hora, pd.total ";
        $query .= "from pago_deposito pd ";
        $query .= "where pd.estado!='1' and pd.idagremiado = '$id'";
        $query .= "order by pd.hora desc";

        $resultados = $this->db->query($query);

        $output = array(
            'registros'=>$resultados->result()
        );

        return $output;

    }


    public function getDatos($id,$clave)
    {
        $query = "select h.numero, h.fecha, h.clave, h.vigencia, concat(prefijo,'-',nummat) matricula, a.paterno, a.materno, a.nombres, concat(v.idserie,'-',v.numero) recibo, DATE_ADD(h.fecha, INTERVAL h.vigencia MONTH) vence ";
        $query .= "from habilidad h ";
        $query .= "left  join agremiado a on a.idagremiado = h.idagremiado ";
        $query .= "left  join ventadetalle vd on vd.iddetalle = h.iddetalle ";
        $query .= "left  join venta v on v.idventa = vd.idventa ";
        $query .= "where h.idhabilidad='$id' and h.clave='$clave'";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    /*public function insert($id){
        $query = "select nummat from agremiado where idagremiado='$id'";
        $resultados = $this->db->query($query);
        $row = $resultados->row();
        $num_matricula = $row->nummat;

        $query = "select * from habilidad where idagremiado='$id' and isnull(iddetalle)";
        $resultados = $this->db->query($query);
        $num_registros = $resultados->num_rows();

        if($num_registros <= 0){
            $row = $resultados->row();
            $data = $this->getHabil($num_matricula);

            if($data['habil']){
                $this->load->library('utilitarios');
                $util=new Utilitarios();
                $clave = $util->generar_clave(20);

                $query = "select max(substring(numero,2,5)) maxnum from habilidad";
                $resultado = $this->db->query($query);
                $row = $resultado->row();
                $numero = "E".str_pad($row->maxnum + 1, 5, '0', STR_PAD_LEFT);

                $query = "insert into habilidad (fecha, numero, idagremiado, clave) ";
                $query .= "values(CURRENT_DATE,'$numero','$id','$clave')";

                $this->db->query($query);

                return 0;
            }else{
                return "ERROR, Ud. no se encuentra Hábil.";
            }
        }else{
            return "ERROR, Ud. no puede generar otra Constancia.";
        }


    }*/

    public function getAnios()
    {
        $query = "select anio idanio from anio order by idanio";
        $resultados = $this->db->query($query);
        return $resultados->result();

    }

    public function getMeses()
    {
        $query = "select idmes, desmes from mes order by idmes";
        $resultados = $this->db->query($query);

        return $resultados->result();

    }


    public function getConceptos()
    {
        $query = "select concat(idconcepto,'*',desconcepto,'*',precio) idconcepto, concat(desconcepto,': S/',precio) desconcepto, precio from conceptopago where flag_web='T' order by idconcepto";
        $resultados = $this->db->query($query);
        return $resultados->result();

    }

    public function insertCulqi($data)
    {
        $id_cargo = $data['id_cargo'];
        $id_token = $data['id_token'];
        $total = $data['total'];
        $moneda = $data['moneda'];
        $email = $data['email'];
        $total_comision = $data['total_comision'];
        $total_impuesto = $data['total_impuesto'];
        $total_deposito = $data['total_deposito'];
        $mensaje_tipo = $data['mensaje_tipo'];
        $idcliente = $data['idcliente'];
        
        $query = "insert into culqi (idtoken, idcargo, total, moneda, email, comision, impuesto, deposito, estado, idagremiado) ";
        $query .= "values('$id_token','$id_cargo','$total','$moneda','$email','$total_comision','$total_impuesto','$total_deposito','$mensaje_tipo','$idcliente')";

        $this->db->query($query);

        return $this->db->insert_id();
    }

    // Deposito pendiente a verificar
    public function insert_deposito($data){
        $idcliente = $data['idcliente'];
        $total = $data['total'];

        $query = "insert into pago_deposito (idagremiado, total) ";
        $query .= "values('$idcliente','$total')";

        $this->db->query($query);

        return $this->db->insert_id();        
    }

    public function insert_detalle_deposito($data){
        $idventa = $data['idventa'];
        $idproducto = $data['idproducto'];
        $precio = $data['precio'];
        $cantidad = $data['cantidad'];
        $cuota = $data['cuota'];

        $query = "insert into pago_detalle (idpago, idconcepto, precio, cantidad, cuotas) ";
        $query .= "values('$idventa','$idproducto','$precio','$cantidad','$cuota')";
        $this->db->query($query);
    }

    public function insert($data){
        $this->load->library('utilitarios');
        $util = new Utilitarios();
        $clave = $util->generar_clave(10);

        $idcliente = $data['idcliente'];
        //$idculqi = $data['idculqi'];
        $total = $data['total'];

        $sede = "INTERNET";
        $anio = date("Y");

        $idserie = "003"; // Serie para internet
        $idctacte = "";
        $idforma = "5"; // Forma de pago vía internet

        # Generamos el numero
        $query = "select max(numero) maxnum from venta where idserie='$idserie'";
        $resultado = $this->db->query($query);
        $row = $resultado->row();
        $numero = str_pad($row->maxnum + 1, 6, '0', STR_PAD_LEFT);

        //$query = "insert into venta (idsede, idserie, numero, anio, fecha, idctacte, idagremiado, idforma, total1, obs, clave, idculqi) ";
        //$query .= "values('$sede','$idserie','$numero','$anio',CURRENT_DATE,'$idctacte','$idcliente','$idforma','$total','','$clave','$idculqi')";

        $query = "insert into venta (idsede, idserie, numero, anio, fecha, idctacte, idagremiado, idforma, total1, obs, clave) ";
        $query .= "values('$sede','$idserie','$numero','$anio',CURRENT_DATE,'$idctacte','$idcliente','$idforma','$total','','$clave')";

        
        $this->db->query($query);

        return $this->db->insert_id();        
                
    }










    

    public function insert_detalle($data){
        $idventa = $data['idventa'];
        $idproducto = $data['idproducto'];
        $precio = $data['precio'];
        $cantidad = $data['cantidad'];
        $cuota = $data['cuota'];


        $query = "insert into ventadetalle (idventa, idconcepto, precio, cantidad, idmoneda, cuotas) ";
        $query .= "values('$idventa','$idproducto','$precio','$cantidad','S/','$cuota')";
        $this->db->query($query);
        
        $iddetalle = $this->db->insert_id();

        if($idproducto==5){
            $query = "select idagremiado from venta where idventa='$idventa'";
            $resultado = $this->db->query($query);
            $row = $resultado->row();
            $idagremiado = $row->idagremiado;

           $this->Habilidad_model->insert($idagremiado, $iddetalle);    

            /*$this->load->library('utilitarios');
            $util=new Utilitarios();
            $clave = $util->generar_clave(20);

            $query = "select max(substring(numero,2,5)) maxnum from habilidad";
            $resultado = $this->db->query($query);
            $row = $resultado->row();
            $numero = "E".str_pad($row->maxnum + 1, 5, '0', STR_PAD_LEFT);

            $query = "insert into habilidad (fecha, numero, idagremiado, clave, iddetalle) ";
            $query .= "values(CURRENT_DATE,'$numero','$id','$clave','$iddetalle')";

            $this->db->query($query);*/



        }

        //$ultimo = substr($cuota, 0, 4).substr($cuota, -2);

        //$query = "update agremiado set ultimopago='$ultimo' where idagremiado='$idagremiado'";
        //$this->db->query($query);
    }


    public function getVenta($id)
    {
        $query = "select v.idventa, v.idserie, v.numero, DATE_FORMAT(v.fecha,'%d/%m/%Y') fecha, v.total1, v.clave, DATE_FORMAT(v.hora_insert,'%d/%m/%Y %H:%i:%s') hora_insert, a.nummat, a.paterno, a.materno, a.nombres, a.direccion, a.dni ";
        $query .= "from venta v ";
        $query .= "left join agremiado a on a.idagremiado = v.idagremiado ";
        $query .= "where v.idventa='$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    public function getVentadetalle($id)
    {
        $query = "select c.idconcepto, c.desconcepto nombre, vd.cantidad, vd.precio, vd.cuotas ";
        $query .= "from ventadetalle vd ";
        $query .= "left join conceptopago c on c.idconcepto = vd.idconcepto ";
        $query .= "where vd.idventa='$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    public function declinarpago($id){

        $query = "update pago_deposito set estado = '1' where idpago = '$id'";
        $this->db->query($query);
    }



}
