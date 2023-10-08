<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_master {
    
    public function __construct()
    {
        require_once APPPATH . 'third_resources/fpdf/fpdf.php';

        $pdf = new FPDF($orientation='P',$unit='mm', "A4");
        
        $pdf->AddPage();

        $CI =& get_instance();

        $CI->fpdf = $pdf;
    }




}

