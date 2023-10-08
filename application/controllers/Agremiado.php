<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agremiado extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Agremiado_model");
        $this->load->model("Registro_model");
        $this->load->model("Ubigeo_model");
    }

    public function update()
    {
        
        $data =  array(
            'dni' => $this->input->post("dni"),
            'ruc' => $this->input->post("ruc"),
            'genero' => $this->input->post("genero"),
            'estadocivil' => $this->input->post("estadocivil"),
            'nacionalidad' => $this->input->post("nacionalidad"),
            'paterno' => $this->input->post("paterno"),
            'materno' => $this->input->post("materno"),
            'nombres' => $this->input->post("nombres"),
            'email' => $this->input->post("email"),
            'fijo' => $this->input->post("fijo"),
            'movil' => $this->input->post("movil"),
            'fnacim' => $this->input->post("fnacim"),
            'lugar_nacim' => $this->input->post("lugar_nacim"),
            'iddist1' => $this->input->post("iddist1"),
            'direccion' => $this->input->post("direccion"),
            'barrio' => $this->input->post("barrio"),
            'iddist2' => $this->input->post("iddist2"),
            'claboral' => $this->input->post("claboral"),
            'iddist3' => $this->input->post("iddist3"),
            'ref_urgencia' => $this->input->post("ref_urgencia"),
            'dir_urgencia' => $this->input->post("dir_urgencia"),
            'telefono_urgencia' => $this->input->post("telefono_urgencia"),
            'iduniv1' => $this->input->post("iduniv1"),
            'semestre_ingreso' => $this->input->post("semestre_ingreso"),
            'semestre_egreso' => $this->input->post("semestre_egreso"),
            'iduniv2' => $this->input->post("iduniv2"),
            'num_resolucion' => $this->input->post("num_resolucion"),
            'fecha_titulo' => $this->input->post("fecha_titulo"),
            'num_titulo' => $this->input->post("num_titulo"),
            'conyugue_dni' => $this->input->post("conyugue_dni"),
            'conyugue_paterno' => $this->input->post("conyugue_paterno"),
            'conyugue_materno' => $this->input->post("conyugue_materno"),
            'conyugue_nombres' => $this->input->post("conyugue_nombres"),
            'obs' => $this->input->post("obs"),
        );
        
        $dnis = $this->input->post("dnis");
        $paternos = $this->input->post("paternos");
        $maternos = $this->input->post("maternos");
        $nombress = $this->input->post("nombress");
        $fechas = $this->input->post("fechas");

        $especs = $this->input->post("espec2");

        $this->Agremiado_model->update($data);

        $id = $this->session->userdata("id");

        $this->insert_hijos($id,$dnis,$paternos,$maternos,$nombress,$fechas);
        $this->insert_especs($id,$especs);

        redirect(base_url());




        /*$data =  array(
            'email' => $this->input->post("email"),
            'fijo' => $this->input->post("fijo"),
            'movil' => $this->input->post("movil"),
            'direccion' => $this->input->post("direccion"),
            'barrio' => $this->input->post("barrio"),
            'iddist2' => $this->input->post("iddist2"),
            'claboral' => $this->input->post("claboral"),
            'iddist3' => $this->input->post("iddist3"),
            'ref_urgencia' => $this->input->post("ref_urgencia"),
            'dir_urgencia' => $this->input->post("dir_urgencia"),
            'telefono_urgencia' => $this->input->post("telefono_urgencia")
        );

        if($this->Agremiado_model->update($data)){
            $this->session->set_flashdata("ok", "Datos guardados correctamente");
            redirect(base_url());            
        }else{
            
            $this->session->set_flashdata("error", "No se pudo actualziar");
            redirect(base_url()."agremiado/misdatos");
        }*/

    }

    public function insert_hijos($id, $dnis, $paternos, $maternos, $nombress, $fechas){
        if(isset($dnis)){
            for ($i=0; $i < count($dnis) ; $i++) { 
                $data = array(
                    'idregistro' => $id,
                    'dni' => $dnis[$i],
                    'paterno' => $paternos[$i],
                    'materno' => $maternos[$i],
                    'nombres' => $nombress[$i],
                    'fecha' => $fechas[$i]
                );

                $this->Agremiado_model->insert_hijos($data);
            }


        }
    }    

    public function insert_especs($id, $especs){
        for ($i=0; $i < count($especs) ; $i++) { 
            $data = array(
                'idregistro' => $id,
                'idespec' => $especs[$i]
            );

            $this->Agremiado_model->insert_especs($data);
        }
    }    










    public function cambiar()
    {
        $data =  array(
            'anterior' => $this->input->post("anterior"),
            'nuevo' => $this->input->post("nuevo")
        );

        $registros = $this->Agremiado_model->cambiar($data);
        echo json_encode($registros);

    }

    public function geultimopago()
    {
        $id = $this->input->post("id");
        $registros = $this->Habilidad_model->getUltimopago($id);
        echo json_encode($registros);
    }

    public function misdatos()
    {
        $id = $this->session->userdata("id");

        $data = array(
            'registro' => $this->Agremiado_model->getRegistro($id),
            'departamentos' => $this->Ubigeo_model->getDepartamentos(),
        );

        $this->load->view('layouts/header');
        $this->load->view('misdatos',$data);
        $this->load->view('layouts/footer');
    }

    public function updatemisdatos()
    {
        $id = $this->session->userdata("id");

        $data = array(
            'registro' => $this->Agremiado_model->getTodosdatos($id),
            'departamentos' => $this->Ubigeo_model->getDepartamentos(),
            'nacionalidades' => $this->Registro_model->getNacionalidades(),
            'estadocivils' => $this->Agremiado_model->getEstadocivil(),
            'especs' => $this->Registro_model->getEspecialidades()

        );

        $this->load->view('layouts/header');
        $this->load->view('updatemisdatos',$data);
        $this->load->view('layouts/footer');
    }

    public function subirfoto()
    {
        $id = $this->session->userdata("id");

        /*$data = array(
            'registro' => $this->Agremiado_model->getTodosdatos($id),
            'departamentos' => $this->Ubigeo_model->getDepartamentos(),
            'nacionalidades' => $this->Registro_model->getNacionalidades(),
            'estadocivils' => $this->Agremiado_model->getEstadocivil(),
            'especs' => $this->Registro_model->getEspecialidades()

        );*/

        $this->load->view('layouts/header');
        $this->load->view('subirfoto');
        $this->load->view('layouts/footer');
    }

    public function getdetalle()
    {
        $id = $this->input->post("id");
        $data = $this->Habilidad_model->getDetalle($id);

        echo json_encode($data);        

    }

    public function provincias(){
        
        $codigo = $this->input->post("cod");
        echo $this->Ubigeo_model->getProvincias($codigo);
    }

    public function distritos(){
        
        $codigo = $this->input->post("cod");
        echo $this->Ubigeo_model->getDistritos($codigo);
    }

    public function validar($id)
    {
    
        $data = array(
            'datos' => $this->Agremiado_model->getColegiado($id)
        );
        
        if(isset($data['datos'][0]->matricula)){
            $data['estado'] = "SI";
        }
        else{
            $data['estado'] = "NO";
        }


        $this->load->view('colegiado', $data);
        
    }
    
    public function getestadocivil(){
        
        echo $this->Agremiado_model->getEsyadocivil();
    }


    public function upload(){

        $id = $this->session->userdata("id");

        $extension = pathinfo($_FILES['upfile']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['upfile']['tmp_name'], "files/fotos/".$id.".".$extension);


        $this->Agremiado_model->setSubirfoto($id,$extension);

        $this->session->set_userdata('subir_foto','F');
        $this->session->set_userdata('extension_foto',$extension);

        redirect(base_url()."/agremiado/misdatos");

    }

    public function historialpagos($id)
    {
        date_default_timezone_set('America/LIma');

        $mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");  

        $datos = array(
            'registro' => $this->Agremiado_model->getRegistro($id),
            'detalle' => $this->Agremiado_model->getHistorialpagos($id)
        );


        $matricula = $datos['registro'][0]->nummat;
        $nombre = $datos['registro'][0]->paterno . ' ' . $datos['registro'][0]->materno . ' ' . $datos['registro'][0]->nombres; 


        $this->load->library('tcpdf_masterA4');
        $this->tcpdf->SetTitle('Historial Pagos');

        $this->tcpdf->SetAutoPageBreak(true, 40);

        // set margins
        $this->tcpdf->SetMargins(20, 45, 10);
        
        $this->tcpdf->setY(45);
        $this->tcpdf->SetFont('helvetica', 'B', 14, '', true);
        $this->tcpdf->Cell(0,0, 'HISTORIAL DE PAGOS', '0', '1', 'C');
        $this->tcpdf->Ln(4);
        $this->tcpdf->SetFont('helvetica', '', 12, '', true);
        $this->tcpdf->Cell(0,0, 'Colegiatura: '.$matricula.'     Apellidos y Nombres: '.$nombre, '0', '1', 'L');

        
        

        $this->tcpdf->Ln(5);

        $this->tcpdf->SetFont('helvetica','B',8); 
        $this->tcpdf->setX(14);
        
        $this->tcpdf->setX(14);
        $this->tcpdf->Cell(10,5,'Año', '0', '0', 'C');
        $this->tcpdf->Cell(25,5,'Recibo', '0', '0', 'C');
        $this->tcpdf->Cell(20,5,'Fecha', '0', '0', 'C');
        $this->tcpdf->Cell(90,5,'Concepto', '0', '0', 'C');
        $this->tcpdf->Cell(10,5,'Cantidad', '0', '0', 'C');
        $this->tcpdf->Cell(15,5,'P/U', '0', '0', 'C');
        $this->tcpdf->Cell(15,5,'Total', '0', '1', 'C');
        $this->tcpdf->setX(14);
        

        
        $this->tcpdf->SetFont('helvetica','',9); 
        $var_numero = "";
        $total =0;
        $subtotal =0;
        $ii=0;

        foreach($datos['detalle'] as $reg){
            
            if($reg->idserie.'-'.$reg->numero != $var_numero){

                if($ii++ > 0){
                    $this->tcpdf->SetFont('helvetica','B',9); 
                    $this->tcpdf->setX(14);
                    $this->tcpdf->Cell(10,5, '', '0', '0', 'C');
                    $this->tcpdf->Cell(25,5, '', '0', '0', 'C');
                    $this->tcpdf->Cell(20,5, '', '0', '0', 'C');
                    $this->tcpdf->Cell(90,5, '', '0', '0', 'L');
                    $this->tcpdf->Cell(10,5, '', '0', '0', 'C');
                    $this->tcpdf->Cell(15,5, 'S/', '0', '0', 'R');
                    $this->tcpdf->Cell(15,5, number_format($subtotal,2,".",",") , 0, 1, 'R');
                    $subtotal =0;
                }

             
                $texto = "";
                $cadena = utf8_decode($reg->obs);

                if(strlen($cadena) > 0){
                    $anio = substr($reg->obs,0,4);
                    $meses = substr($reg->obs,5);
                    $texto = $mes[intval(substr($meses,0,2))-1] . (strlen($meses) > 2?"-".$mes[intval(substr($meses,-2))-1]:"")." " . $anio;
                }
                
                $this->tcpdf->SetFont('helvetica','',9); 
                $this->tcpdf->setX(14);
                $this->tcpdf->Cell(10,5, $reg->anio, '0', '0', 'C');
                $this->tcpdf->Cell(25,5, $reg->idserie.'-'.$reg->numero, '0', '0', 'C');
                $this->tcpdf->Cell(20,5, $reg->fecha, '0', '0', 'C');
                $this->tcpdf->Cell(90,5, $reg->nombre.' '.$texto, '0', '0', 'L');
                $this->tcpdf->Cell(10,5, $reg->cantidad, '0', '0', 'C');
                $this->tcpdf->Cell(15,5,  number_format($reg->precio,2,".",",") , 0, 0, 'R');
                $this->tcpdf->Cell(15,5,  number_format($reg->cantidad*$reg->precio,2,".",",") , 0, 1, 'R');
                $total += $reg->cantidad*$reg->precio;
                $subtotal += $reg->cantidad*$reg->precio;


            }else{

                $texto = "";
                $cadena = utf8_decode($reg->obs);

                if(strlen($cadena) > 0){
                    $anio = substr($reg->obs,0,4);
                    $meses = substr($reg->obs,5);
                    $texto = $mes[intval(substr($meses,0,2))-1] . (strlen($meses) > 2?"-".$mes[intval(substr($meses,-2))-1]:"")." " . $anio;
                }
                
                $this->tcpdf->setX(14);
                $this->tcpdf->Cell(10,5, '', '0', '0', 'C');
                $this->tcpdf->Cell(25,5, '', '0', '0', 'C');
                $this->tcpdf->Cell(20,5, '', '0', '0', 'C');
                $this->tcpdf->Cell(90,5, $reg->nombre.' '.$texto, '0', '0', 'L');
                $this->tcpdf->Cell(10,5, $reg->cantidad, '0', '0', 'C');
                $this->tcpdf->Cell(15,5,  number_format($reg->precio,2,".",",") , 0, 0, 'R');
                $this->tcpdf->Cell(15,5,  number_format($reg->cantidad*$reg->precio,2,".",",") , 0, 1, 'R');
                $total += $reg->cantidad*$reg->precio;
                $subtotal += $reg->cantidad*$reg->precio;

            }

            $var_numero = $reg->idserie.'-'.$reg->numero;
        }
        $this->tcpdf->SetFont('helvetica','B',9); 
        $this->tcpdf->setX(14);
        $this->tcpdf->Cell(10,5, '', '0', '0', 'C');
        $this->tcpdf->Cell(25,5, '', '0', '0', 'C');
        $this->tcpdf->Cell(20,5, '', '0', '0', 'C');
        $this->tcpdf->Cell(90,5, '', '0', '0', 'L');
        $this->tcpdf->Cell(10,5, '', '0', '0', 'C');
        $this->tcpdf->Cell(15,5, 'S/', '0', '0', 'R');
        $this->tcpdf->Cell(15,5, number_format($subtotal,2,".",",") , 0, 1, 'R');


        $this->tcpdf->SetFont('helvetica','B',14); 
        $this->tcpdf->setX(14);
        $this->tcpdf->Cell(10,5, '', '0', '0', 'C');
        $this->tcpdf->Cell(25,5, '', '0', '0', 'C');
        $this->tcpdf->Cell(20,5, '', '0', '0', 'C');
        $this->tcpdf->Cell(90,5, '', '0', '0', 'L');
        $this->tcpdf->Cell(10,5, 'TOTAL S/', '0', '0', 'R');
        $this->tcpdf->Cell(30,5, number_format($total,2,".",",") , 0, 1, 'R');
        $this->tcpdf->SetFont('helvetica','B',9); 
        $this->tcpdf->Ln(5);
        $this->tcpdf->setX(15);
        $this->tcpdf->Cell(185,5, "Fecha y Hora de consulta: ".date('d-m-Y h:i:s A') , 0, 1, 'L');
        
        $this->tcpdf->Output('net.pdf', 'I');

    }




}





