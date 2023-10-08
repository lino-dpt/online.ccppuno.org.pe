<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    require_once APPPATH . 'third_party/fpdf/fpdf.php';
    require_once APPPATH . 'third_party/qrcode/qrcode.class.php';

    class Fpdf_masterA4_vacio extends FPDF {
        
        public function __construct()
        {
            //require_once APPPATH . 'third_party/fpdf/fpdf.php';

            //$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
            $pdf = new FPDF($orientation='P',$unit='mm', "A4");
            
            #Establecemos los márgenes izquierda, arriba y derecha:
            $pdf->SetMargins(17, 8 , 10);
            
            //$pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 6);

            $pdf->AddPage();

            $CI =& get_instance();

            $CI->fpdf = $pdf;
        }
    }

