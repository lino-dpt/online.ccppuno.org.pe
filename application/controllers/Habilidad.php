<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Habilidad extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('captcha');
        $this->load->model("Agremiado_model");
        $this->load->model("Habilidad_model");
        $this->load->model("Ubigeo_model");
    }

	public function consulta()
	{
        
        $this->load->view('consulta');
	
    }

    public function gethabil()
    {
        $codigo = $this->input->post("codigo");
        
        $codigo = str_pad($codigo, 5, "0", STR_PAD_LEFT);

        $registros = $this->Habilidad_model->getHabil($codigo);
        echo json_encode($registros);
    }

    public function gethabil_dni()
    {
        $codigo = $this->input->post("codigo");
        $registros = $this->Habilidad_model->getHabil_dni($codigo);
        echo json_encode($registros);
    }
    
    public function gethabil_id()
    {
        $id = $this->input->post("id");
        
        $registros = $this->Habilidad_model->getHabil_ID($id);
        echo json_encode($registros);
    }

    public function geultimopago()
    {
        $id = $this->input->post("id");
        $registros = $this->Habilidad_model->getUltimopago($id);
        echo json_encode($registros);
    }

    public function constancia()
    {
        $id = $this->session->userdata("id");

        $data = array(
            'registro' => $this->Agremiado_model->getRegistro($id),
            'detalle' => $this->Habilidad_model->getDetalle($id)
        );

        $this->load->view('layouts/header');
        $this->load->view('constancia',$data);
        $this->load->view('layouts/footer');



    }

    public function getdetalle()
    {
        $id = $this->input->post("id");
        $data = $this->Habilidad_model->getDetalle($id);

        echo json_encode($data);        

    }


    public function validar($clave)
    {  
        $data = array(
            'datos' => $this->Habilidad_model->getConstancia($clave)
        );
        
        if(isset($data['datos'][0]->matricula))
            $data['habil'] = $this->Habilidad_model->getHabil($data['datos'][0]->matricula);
        else
            $data['habil'] = "";

        $this->load->view('validar', $data);
        
    }
    
    public function insert()
    {
        $id = $this->input->post("id");
        echo $this->Habilidad_model->insert($id);
    }

   /* public function consulta()
    {
        $codigo = is_null($this->input->post("codigo")) ? '' : $this->input->post("codigo");
        
        if($codigo!=''){
            $data = array(
                'datos' => $this->Habilidad_model->getConsulta($codigo)
            );

            //$data['habil'] = $this->Habilidad_model->getHabil($data['datos'][0]->matricula);
            if(isset($data['datos'][0]->matricula)){
                $data['habil'] = "NO";
                $data['flag'] = "SI";
                if($this->Habilidad_model->getHabil($data['datos'][0]->matricula) != '')
                    $data['habil'] = "SI";
            }
            else{
                $data['flag'] = "NO";
                $data['habil'] = "NO";
            }

            
        }else{
            $data = array(
                'datos' => ""
            );

            $data['flag'] = "NO";
            $data['habil'] = "NO";
        }

        $this->load->view('consulta', $data);

        
    }*/




   /* public function validadregistro()
    {
        $codigo = $this->input->post("matricula_false");
        $fecha = $this->input->post("fnacimiento");
        
        $resp = $this->Habilidad_model->validarRegistro($codigo, $fecha);

        return $resp;
    }*/

 public function imprimir($id, $clave) //con firmas
    {
        date_default_timezone_set('America/LIma');
        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre");

        //$ahora = strtotime($fecha);  
        //($flag_dia?$dias[date("w", $ahora)]." ":" ") . date("j", $ahora) . " de " . $meses[date("n", $ahora)-1] . " de " . date("Y", $ahora);

        $data = array(
            'registro' => $this->Habilidad_model->getDatos($id, $clave)

        );

        //var_dump($data['registro'][0]);
        //die();


        if (isset($data['registro'][0]->numero)) {
            $this->load->library('tcpdf_masterA4');

            $this->tcpdf->SetTitle('Constancia');

            $this->tcpdf->Image(base_url() . '/resources/img/sello_decano_2022.png', 3, 165, 40, 40, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);
            $this->tcpdf->Image(base_url() . '/resources/img/sello_director_2022.png', 75, 165, 40, 40, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);
            $this->tcpdf->Image(base_url() . '/resources/img/firma_decana_2022.png', 25, 170, 60, 60, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);
            $this->tcpdf->Image(base_url() . '/resources/img/firma_director_2022.png', 100, 160, 60, 60, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);

           


            $numero = $data['registro'][0]->numero;
            $fecha = $data['registro'][0]->fecha;
            //$prefijo = $data['registro'][0]->prefijo;
            //$nummat = $data['registro'][0]->nummat;
            $clave = $data['registro'][0]->clave;
            $matricula = $data['registro'][0]->matricula;
            $nombre = $data['registro'][0]->nombres . ' ' . $data['registro'][0]->paterno . ' ' . $data['registro'][0]->materno;
            $recibo = $data['registro'][0]->recibo;
            $fecha_recibo = $data['registro'][0]->fecha_recibo;
            $vigencia = $data['registro'][0]->vigencia;
            $vence = $data['registro'][0]->vence;
            $vence = strtotime($vence);
            $fecha = strtotime($fecha);
            $fecha_letras = $dias[date("w", $fecha)] . " " . date("j", $fecha) . " de " . $meses[date("n", $fecha) - 1] . " de " . date("Y", $fecha);
            $fecha_vence = $dias[date("w", $vence)] . " " . date("j", $vence) . " de " . $meses[date("n", $vence) - 1] . " de " . date("Y", $vence);


            $qrcode = new QRcode('https://online.ccppuno.org.pe/habilidad/validar/' . $clave, 'H'); // error level : L, M, Q, H

            $fecha_vigencia = date("Y-m-d", strtotime($fecha . "+ 2 month"));
            //$fecha_vigencia_letras = $util->fecha_letras($fecha_vigencia,false);


            $var_anio = "";
            $global_ruc = "";
            $global_rsocial = "";
            $global_direccion = "";

            $datetime = new DateTime();
            $hora_impresion = $datetime->format('Y/m/d');


            // set document information
            $this->tcpdf->SetCreator(PDF_CREATOR);
            $this->tcpdf->SetAuthor('Grupo NET++');
            $this->tcpdf->SetTitle('Constancia');

            // set margins
            $this->tcpdf->SetMargins(20, 18, 18);

            $this->tcpdf->setY(50);
            $this->tcpdf->SetFont('helvetica', 'B', 18, '', true);
            $this->tcpdf->Cell(0, 0, 'CONSTANCIA DE HABILIDAD Nº ' . $numero, '0', '1', 'C');

            $this->tcpdf->Ln(8);
            $this->tcpdf->SetFont('helvetica', '', 18);
            $txt = "LA DECANA Y DIRECTOR SECRETARIO DEL COLEGIO DE CONTADORES PÚBLICOS DE PUNO.";

            //// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'L');

            $this->tcpdf->Ln(5);
            $this->tcpdf->SetFont('helvetica', '', 16);
            $txt = "HACEN CONSTAR: Que, de acuerdo a los registros de la institución.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'J');

            $this->tcpdf->Ln(4);
            $this->tcpdf->SetFont('helvetica', '', 13);
            $txt = "El Sr. CPC $nombre, con matrícula Nº$matricula se encuentra HÁBIL a la fecha para el ejercicio profesional que le faculta la Ley Nº13253, D.L. Nº25873, el Estatuto y el Reglamento Interno de nuestro Colegio Profesional.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'J');

            $this->tcpdf->SetFont('helvetica', 'B', 12);

            $hasta = $this->Habilidad_model->getHabil($matricula);

            $this->tcpdf->Ln(1);
            $txt = "HÁBIL hasta " . $hasta['hasta'];
            $this->tcpdf->SetFont('helvetica', 'B', 16);
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'C');

            $this->tcpdf->SetFont('helvetica', '', 13);
            $this->tcpdf->Ln(4);
            $txt = "En fe de la cual y a solicitud de parte, firmamos la presente.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'L');

            $this->tcpdf->Ln(4);
            //$txt="Puno, ".$util->fecha_letras($fecha);
            $txt = "Puno, " . $fecha_letras . ".";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'L');



            $this->tcpdf->Ln(47);
            $this->tcpdf->Line(20, 198, 75, 198);
            $this->tcpdf->Line(95, 198, 150, 198);

            $this->tcpdf->SetFont('helvetica', 'B', 8);

            $txt = "  CPC. AMPARO PEREZ EXCELMES";
            $this->tcpdf->Cell(70, 0, $txt, 0, 'C');
            $txt = "CPC. VICTOR MARTIN ALEMAN PALOMINO";
            $this->tcpdf->Cell(70, 0, $txt, 0, 'C');

            $this->tcpdf->Ln(5);
            $txt = "                            DECANO";
            $this->tcpdf->Cell(68, 0, $txt, 0, 'C');
            $txt = "       DIRECTOR SECRETARIO";
            $this->tcpdf->Cell(68, 0, $txt, 0, 'C');

            $this->tcpdf->Ln(15);

            $this->tcpdf->SetFont('helvetica', '', 10);
            $txt = "Recibo: " . $recibo . " (" . $fecha_recibo . ")";
            $this->tcpdf->Cell(0, 0, $txt, 0, 'L');


            $this->tcpdf->Ln(15);
            /*$this->tcpdf->SetFont('helvetica','B',11);
            $txt="- Esta constancia tiene una vigencia de ".$vigencia." mes(es), vence el ".$fecha_vence . ".";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'L');
            $this->tcpdf->Ln(1);*/
            $this->tcpdf->SetFont('helvetica', '', 11);
            $txt = "- Esta constancia puede ser verificada en el sitio web del Colegio de Contadores Públicos de Puno (www.ccppuno.org.pe), a través de una lectora de códigos o teléfono celular enfocando el código QR, el celular debe de poseer el software que lo puede descargar de internet.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'J');
            $this->tcpdf->Ln(1);
            $txt = "- Firmas mecánicas al amparo del numeral 4.4 del atículo 4º del Texto Único Ordenado de la Ley Nº27444 (Procedimiento Administrativo General); y de los artículos 141º del Código Civil.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'J');

            $background = array(255, 255, 255);
            $color = array(0, 0, 0);
            $qrcode->displayFPDF($this->tcpdf, 155, 185, 40, $background, $color);


            $this->tcpdf->Output('constancia.pdf', 'I');
        } else {

            echo "<h4><strong>¡ ERROR, ACCESO A IMPRESIÓN DE CONSTANCIA NO AUTORIZADA !!!</strong></h4>";
        }
    }
    public function imprimir_old($id, $clave)//sin firmas
    {
        date_default_timezone_set('America/LIma');
        $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");  
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");  

        //$ahora = strtotime($fecha);  
        //($flag_dia?$dias[date("w", $ahora)]." ":" ") . date("j", $ahora) . " de " . $meses[date("n", $ahora)-1] . " de " . date("Y", $ahora);

        $data = array(
            'registro' => $this->Habilidad_model->getDatos($id, $clave)

        );


        if(isset($data['registro'][0]->numero)){
            $this->load->library('tcpdf_masterA4');

            $this->tcpdf->SetTitle('Constancia');


            //$this->tcpdf->Image(base_url().'/resources/img/firma_decano-azul.png', 28, 160, 60, 60, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);
            //$this->tcpdf->Image(base_url().'/resources/img/firma_director-azul.png', 95, 160, 60, 60, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);

            //$this->tcpdf->Image(base_url().'/resources/img/sello-decano.png', 5, 162, 43, 43, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);
            //$this->tcpdf->Image(base_url().'/resources/img/sello-director.png', 75, 162, 40, 40, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);


            $numero = $data['registro'][0]->numero;
            $fecha = $data['registro'][0]->fecha;
            $matricula = $data['registro'][0]->matricula;
            //$clave = $data['registro'][0]->clave;
            $nombre = $data['registro'][0]->nombres . ' ' . $data['registro'][0]->paterno . ' ' . $data['registro'][0]->materno;
            $recibo = $data['registro'][0]->recibo;
            $fecha_recibo = $data['registro'][0]->fecha_recibo;
            $vigencia = $data['registro'][0]->vigencia;
            $vence = $data['registro'][0]->vence;
            $vence= strtotime($vence);  
            $fecha= strtotime($fecha);  
            $fecha_letras = $dias[date("w", $fecha)] . " " . date("j", $fecha) . " de " . $meses[date("n", $fecha)-1] . " de " . date("Y", $fecha);
            $fecha_vence = $dias[date("w", $vence)] . " " . date("j", $vence) . " de " . $meses[date("n", $vence)-1] . " de " . date("Y", $vence);


            $qrcode = new QRcode('https://online.cdrxvipuno.org.pe/habilidad/validar/'.$clave, 'H'); // error level : L, M, Q, H

            $fecha_vigencia = date("Y-m-d",strtotime($fecha."+ 2 month"));
            //$fecha_vigencia_letras = $util->fecha_letras($fecha_vigencia,false);




            $var_anio = "";
            $global_ruc = "";
            $global_rsocial = "";
            $global_direccion = "";

            $datetime = new DateTime(); 
            $hora_impresion = $datetime->format('Y/m/d');
            
           
            // set document information
            $this->tcpdf->SetCreator(PDF_CREATOR);
            $this->tcpdf->SetAuthor('Grupo NET++');
            $this->tcpdf->SetTitle('Constancia');

            // set margins
            $this->tcpdf->SetMargins(20, 18, 18);
            
            $this->tcpdf->setY(50);
            $this->tcpdf->SetFont('helvetica', 'B', 18, '', true);
            $this->tcpdf->Cell(0,0, 'CERTIFICADO DE HABILITACIÓN Nº '.$numero, '0', '1', 'C');
                   
            $this->tcpdf->Ln(8);
            $this->tcpdf->SetFont('helvetica','',18); 
            $txt="Por el presente, el Colegio de Psicólogos del Perú - DCR XVI Puno";
            
            //// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'L');

            $this->tcpdf->Ln(5);
            $this->tcpdf->SetFont('helvetica','',16);
            $txt="CERTIFICA";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'J');

            $this->tcpdf->Ln(4);
            $this->tcpdf->SetFont('helvetica','',13);
            $txt="El Ps. $nombre, con colegiatura Nº$matricula se encuentra HÁBIL a la fecha para el ejercicio profesional de PSICÓLOGO en todo el terriotorio de la república.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'J');

            $this->tcpdf->SetFont('helvetica','B',12);
            
            $hasta = $this->Habilidad_model->getHabil($matricula);

            $this->tcpdf->Ln(1);
            $txt="HÁBIL hasta ".$hasta['hasta'];
            $this->tcpdf->SetFont('helvetica','B',16);
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'C');

            $this->tcpdf->SetFont('helvetica','',13);
            $this->tcpdf->Ln(4);
            $txt="En fe de la cual y a solicitud de parte, firmamos la presente.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'L');

            $this->tcpdf->Ln(4);
            //$txt="Puno, ".$util->fecha_letras($fecha);
            $txt="Puno, ".$fecha_letras . ". (Impresión: ".date('d-m-Y h:i:s A').")";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'L');

            

            $this->tcpdf->Ln(45);
            
            $this->tcpdf->SetFont('helvetica','B',8);
            
            
            $this->tcpdf->Ln(15);

            $this->tcpdf->SetFont('helvetica','',10);
            $txt="Recibo: ".$recibo." (".$fecha_recibo.")";
            $this->tcpdf->Cell(0, 0, $txt, 0, 'L');
            
            
            $this->tcpdf->Ln(15);
            $this->tcpdf->SetFont('helvetica','B',11);

            $this->tcpdf->SetTextColor(255, 0, 0);

            $txt="- Esta constancia tiene una vigencia de ".$vigencia." meses, a partir de la fecha de su emisión.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'L');
            $this->tcpdf->SetTextColor(0, 0, 0);
            $this->tcpdf->Ln(1);
            $this->tcpdf->SetFont('helvetica','',11);
            $txt="- Este certificado puede ser verificada en el sitio web del Colegio de Psicólogos de Perú CDR XVI Puno (www.cdrxvipuno.org.pe), a través de una lectora de códigos o teléfono celular enfocando el código QR, el celular debe de poseer el software que lo puede descargar de internet.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'J');
            $this->tcpdf->Ln(1);
            $txt="- Firmas mecánicas al amparo del numeral 4.4 del atículo 4º del Texto Único Ordenado de la Ley Nº27444 (Procedimiento Administrativo General); y de los artículos 141º del Código Civil.";
            $this->tcpdf->MultiCell(0, 0, $txt, 0, 'J');

            $background = array(255,255,255);
            $color = array(0,0,0);
            $qrcode->displayFPDF($this->tcpdf, 155, 155, 40, $background, $color);


            $this->tcpdf->Output('net.pdf', 'I');

        }else{

            echo "<h4><strong>¡ ERROR, ACCESO A IMPRESIÓN DE CONSTANCIA NO AUTORIZADA !!!</strong></h4>";
        }


    }




    public function enviar_email(){
      $destinatario = "elvis.aliagan@gmail.com";
      $asunto = "Recibo de Pagp";
      $cuerpo = "Como estas?";
      mail($destinatario,$asunto,$cuerpo);
  }
}


