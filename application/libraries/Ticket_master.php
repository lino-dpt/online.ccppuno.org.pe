<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_master {
    
    public function __construct()
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';

        $pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
        
        $pdf->AddPage();

        $CI =& get_instance();

        $CI->fpdf = $pdf;
    }




}

