<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia_model extends CI_Model {

  public function getListado()
    {

        $query = "select a.dni, a.nummat, a.paterno, a.materno, a.nombres, r.fecha_hora ";
        $query .= "from asistencia r ";
        $query .= "left join agremiado a on a.dni = r.dni ";
        $query .= "order by r.idasistencia";

        $resultados = $this->db->query($query);
        return $resultados->result();

    }

    public function getHabil_dni($id)
    {   
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero'];
        $num_meses = ['01','02','03','04','05','06','07','08','09','10','11','12','01','02'];

        $query = "select fecha_hora from asistencia where dni='$id'";
        $resultado = $this->db->query($query);
        $row = $resultado->row();
        

        $registrado = false;
        $flag = false;
        $habil = false;
        $nombre = "";
        $hasta = "";
        $fecha_hora = "";

        if($resultado->num_rows() > 0){
            $registrado = true;
            $flag = true;
            $fecha_hora = $row->fecha_hora;
        }else{
            $query = "select ultimopago, current_date fecha_actual, paterno, materno, nombres from agremiado where flag='T' and dni='$id'";
            $resultado = $this->db->query($query);
            $row = $resultado->row();

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

                        $query = "insert into asistencia (dni) values('$id')";
                        $this->db->query($query);
                    }
                }
            }
        }

        $output = array(
            'flag'=> $flag,
            'habil'=> $habil,
            'nombre'=> $nombre,
            'hasta'=> $hasta,
            'registrado'=> $registrado,
            'fecha_hora' => $fecha_hora
        );

        return $output;
    }

}
