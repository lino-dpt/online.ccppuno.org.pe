<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Habilidad_model extends CI_Model {

    
    public function getConstancia($clave)
    {
     
        $query = "select h.idhabilidad id, h.numero, DATE_FORMAT(h.fecha, '%d/%m/%Y') fecha, a.nummat matricula, a.dni, concat(a.paterno,' ',a.materno,' ',a.nombres) nombre, DATE_FORMAT(DATE_ADD(h.fecha, INTERVAL h.vigencia MONTH), '%d/%m/%Y') vence ";
        $query .= "from habilidad h ";
        $query .= "left join agremiado a on a.idagremiado = h.idagremiado ";
        $query .= "where h.clave = '$clave'";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }

    public function validarRegistro($codigo, $fecha)
    {
        $codigo = str_pad($codigo, 5, '0', STR_PAD_LEFT);

        $query = "select idagremiado id, concat(prefijo,'-',nummat) nummat, concat(nombres,' ',paterno,' ',materno) nombre ";
        $query .= "from agremiado ";
        $query .= "where nummat = '$codigo' and fecha_nacimiento = '$fecha'";
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
     
        $query = "select a.idagremiado id, concat(prefijo,'-',nummat) nummat, a.dni, concat(a.paterno,' ',a.materno,' ',a.nombres) nombre ";
        $query .= "from agremiado a ";
        $query .= "where a.idagremiado = '$id'";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }

    public function getDetalle($id)
    {
        $query = "select h.idhabilidad id, h.numero, h.fecha, h.hora_insert, h.emitir, h.vigencia, IF(isnull(h.iddetalle),'',concat(v.idserie,'-',v.numero)) recibo, IF(isnull(h.iddetalle),'Exonerado',f.desforma) desforma, IF((CURRENT_DATE < DATE_ADD(h.fecha, INTERVAL h.vigencia MONTH) AND h.emitir='1'),h.clave,h.clave) print ";
        $query .= "from habilidad h ";
        $query .= "left join ventadetalle vd on vd.iddetalle = h.iddetalle ";
        $query .= "left join venta v on v.idventa = vd.idventa ";
        $query .= "left join formapago f on f.idforma = v.idforma ";
        $query .= "where h.idagremiado = '$id' ";
        $query .= "order by h.idhabilidad desc";

        $resultados = $this->db->query($query);

        $output = array(
            'registros'=>$resultados->result()
        );

        return $output;

    }

    public function getHabil_ID($id)
    {   
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero'];
        $num_meses = ['01','02','03','04','05','06','07','08','09','10','11','12','01','02'];

        $query = "select ultimopago, current_date fecha_actual, paterno, materno, nombres from agremiado where flag='T' and idagremiado='$id'";
        $resultado = $this->db->query($query);
        $row = $resultado->row();

        $flag = false;
        $habil = false;
        $nombre = "";
        $hasta = "";

        if($resultado->num_rows() > 0){
            $flag = true;
            $nombre = $row->paterno." ".$row->materno." ".$row->nombres;
            $fecha_actual = (string)$row->fecha_actual;

            if(!is_null($row->ultimopago) and $row->ultimopago != ''){
                $anio = substr($row->ultimopago, 0, 4);
                $idmes = substr($row->ultimopago, 4, 2);

                $mes_letras_hasta = $meses[(int)$idmes+1];
                $mes_hasta = $num_meses[(int)$idmes+1];

                if($idmes >= 11){ 
                    $anio_hasta = $anio + 1; 
                }else{
                    $anio_hasta = $anio;
                }

                $anio_actual = substr($fecha_actual,0,4);
                $mes_actual = substr($fecha_actual,5,2);
                
                
                $num_actual = (int)($anio_actual.$mes_actual);
                $num_hasta = (int)($anio_hasta.$mes_hasta);

                if($num_actual <= $num_hasta){
                    $habil = true;
                    $hasta = $mes_letras_hasta.' de '.$anio_hasta;
                }
            }
        }

        $output = array(
            'flag'=> $flag,
            'habil'=> $habil,
            'nombre'=> $nombre,
            'hasta'=> $hasta
        );

        return $output;
    }

    public function getHabil_dni($id)
    {   
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero'];
        $num_meses = ['01','02','03','04','05','06','07','08','09','10','11','12','01','02'];

        $query = "select ultimopago, current_date fecha_actual, paterno, materno, nombres from agremiado where flag='T' and dni='$id'";
        $resultado = $this->db->query($query);
        $row = $resultado->row();

        $flag = false;
        $habil = false;
        $nombre = "";
        $hasta = "";

        if($resultado->num_rows() > 0){
            $flag = true;
            $nombre = $row->paterno." ".$row->materno." ".$row->nombres;
            $fecha_actual = (string)$row->fecha_actual;

            if(!is_null($row->ultimopago) and $row->ultimopago != ''){
                $anio = substr($row->ultimopago, 0, 4);
                $idmes = substr($row->ultimopago, 4, 2);

                $mes_letras_hasta = $meses[(int)$idmes+1];
                $mes_hasta = $num_meses[(int)$idmes+1];

                if($idmes >= 11){ 
                    $anio_hasta = $anio + 1; 
                }else{
                    $anio_hasta = $anio;
                }

                $anio_actual = substr($fecha_actual,0,4);
                $mes_actual = substr($fecha_actual,5,2);
                
                
                $num_actual = (int)($anio_actual.$mes_actual);
                $num_hasta = (int)($anio_hasta.$mes_hasta);

                if($num_actual <= $num_hasta){
                    $habil = true;
                    $hasta = $mes_letras_hasta.' de '.$anio_hasta;
                }
            }
        }

        $output = array(
            'flag'=> $flag,
            'habil'=> $habil,
            'nombre'=> $nombre,
            'hasta'=> $hasta
        );

        return $output;
    }

    public function getHabil($codigo)
    {   
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero'];
        $num_meses = ['01','02','03','04','05','06','07','08','09','10','11','12','01','02'];

        $codigo = str_pad($codigo, 5, '0', STR_PAD_LEFT);
    
        $query = "select ultimopago, current_date fecha_actual, nummat, paterno, materno, nombres, nummat matricula, situacion, sede, flag_subirfoto from agremiado where (nummat = '$codigo' or dni = '$codigo')";
        $resultado = $this->db->query($query);
        $row = $resultado->row();

        $flag = false;
        $habil = false;
        $paterno = "";
        $materno = "";
        $nombres = "";
        $sede = "";
        $situacion = "";
        $matricula = "";
        $flag_subirfoto = "";
        $hasta = "";

        if($resultado->num_rows() > 0){
            $flag = true;
            $matricula = $row->matricula;
            $paterno = $row->paterno;
            $materno = $row->materno;
            $nombres = $row->nombres;
            $sede = $row->sede;
            $situacion = $row->situacion;
            $flag_subirfoto = $row->flag_subirfoto;
            $fecha_actual = (string)$row->fecha_actual;

            if((!is_null($row->ultimopago) and $row->ultimopago != '')){
                $anio = substr($row->ultimopago, 0, 4);
                $idmes = substr($row->ultimopago, 4, 2);

                $mes_letras_hasta = $meses[(int)$idmes+1];
                $mes_hasta = $num_meses[(int)$idmes+1];

                if($idmes >= 11){ 
                    $anio_hasta = $anio + 1; 
                }else{
                    $anio_hasta = $anio;
                }

                $anio_actual = substr($fecha_actual,0,4);
                $mes_actual = substr($fecha_actual,5,2);
                
                
                $num_actual = (int)($anio_actual.$mes_actual);
                $num_hasta = (int)($anio_hasta.$mes_hasta);

                if($num_actual <= $num_hasta){
                    $habil = true;
                    $hasta = $mes_letras_hasta.' de '.$anio_hasta;
                }
            }

        }


        $output = array(
            'flag'=> $flag,
            'habil'=> $habil,
            'matricula'=> $matricula,
            'paterno'=> $paterno,
            'materno'=> $materno,
            'nombres'=> $nombres,
            'sede'=> $sede,
            'situacion'=> $situacion,
            'flag_subirfoto'=> $flag_subirfoto,
            'hasta'=> $hasta,
        );

        return $output;
    }

    public function getConsulta($codigo)
    {
     
        $query = "select concat(prefijo,'-',nummat) matricula, a.dni, concat(a.paterno,' ',a.materno,' ',a.nombres) nombre, a.fecha_incorpora ";
        $query .= "from agremiado a ";
        $query .= "where (a.nummat = '$codigo' or a.dni = '$codigo')";

        $resultado = $this->db->query($query);
        return $resultado->result();

    }

    public function getHasta($matricula)
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

    public function getUltimopago($id)
    {
        $this->load->library('utilitarios');
        $util = new Utilitarios();

        $query = "select ultimopago from agremiado where idagremiado='$id'";

        $resultado = $this->db->query($query);
        $row = $resultado->row();

        if(!is_null($row->ultimopago) and $row->ultimopago != ''){
            $anio = substr($row->ultimopago, 0, 4);
            $idmes = substr($row->ultimopago, 4, 2);
            $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
            $ultimo_pago = $meses[intval($idmes) > 0 ? intval($idmes) - 1 : intval($idmes)] . ' de ' . $anio;

        }else{
            $ultimo_pago = "No existe pagos...!!!";
        }

        return $ultimo_pago;

    }

    public function getDatos($id,$clave)
    {
        $query = "select h.numero, h.fecha, h.clave, h.vigencia, a.nummat matricula, a.paterno, a.materno, a.nombres, concat(v.idserie,'-',v.numero) recibo, DATE_ADD(h.fecha, INTERVAL h.vigencia MONTH) vence, DATE_FORMAT(v.fecha, '%d/%m/%Y') fecha_recibo ";
        $query .= "from habilidad h ";
        $query .= "left  join agremiado a on a.idagremiado = h.idagremiado ";
        $query .= "left  join ventadetalle vd on vd.iddetalle = h.iddetalle ";
        $query .= "left  join venta v on v.idventa = vd.idventa ";
        $query .= "where h.idhabilidad='$id' and h.clave='$clave'";

        $resultado = $this->db->query($query);
        return $resultado->result();
    }

    public function getHabilhasta($matricula)
    {
        $this->load->library('utilitarios');
        $util = new Utilitarios();

        $query = "select ultimopago, current_date fecha_actual from agremiado where nummat = '$matricula'";

        $resultado = $this->db->query($query);
        $row = $resultado->row();

        if(!is_null($row->ultimopago) and $row->ultimopago != ''){
            $anio = substr($row->ultimopago, 0, 4);
            $idmes = substr($row->ultimopago, 4, 2);
            
            $numero_dias = cal_days_in_month(CAL_GREGORIAN, intval($idmes), $anio);
            $fecha = date($anio.'-'.$idmes.'-'.$numero_dias);
            $fecha_hasta = date("Y-m-d",strtotime($fecha."+ 2 month"));
            
            $habil_hasta = $util->fecha_letras($fecha_hasta,true);


        }else{
            $habil_hasta = "No existe pagos...!!!";
        }

        return $habil_hasta;
       
    }    

    public function insert($id, $iddetalle){

        //$data = $this->getHabil_ID($id);

        //if($data['habil']){
            $this->load->library('utilitarios');
            $util=new Utilitarios();
            $clave = $util->generar_clave(20);

            $query = "select max(substring(numero,2,5)) maxnum from habilidad";
            $resultado = $this->db->query($query);
            $row = $resultado->row();
            $numero = "E".str_pad($row->maxnum + 1, 5, '0', STR_PAD_LEFT);

            $query = "insert into habilidad (fecha, numero, idagremiado, clave, iddetalle) ";
            $query .= "values(CURRENT_DATE,'$numero','$id','$clave','$iddetalle')";

            $this->db->query($query);

            //return 0;
        //}else{
          //  return "ERROR, Ud. no se encuentra Hábil.";
        //}


    }

/*    public function emitir($id){

        $query = "update habilidad set emitir = 'F', hora_emision = CURRENT_TIMESTAMP where idhabilidad='$id'";

        $this->db->query($query);

    }*/




}
