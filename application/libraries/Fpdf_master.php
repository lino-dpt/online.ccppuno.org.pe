<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/fpdf/fpdf.php';

class PDF extends FPDF {
    
    function Header()
    {
        
        
        // Logo
        $this->Image(base_url().'resources/img/logo.png',2,2,30,30);
        // Arial bold 15
        $this->SetFont('Arial','B',13);
        // Movernos a la derecha
        $this->Cell(20);
        $this->Cell(0,10,utf8_decode('COLEGIO DE CONTADORES PÚBLICOS DE PUNO'),0,0,'C');
        $this->Ln(7);
        // Salto de línea
        
        $this->SetFont('Arial','B',11);
        $this->Cell(20);
        $this->Cell(0,10,utf8_decode('Ley Nº13253 y Ley Nº28951 D.S. Nº28 del 26-02-60'),0,0,'C');
        // Salto de línea

        $this->Line(30,28,200,28);
    }
    
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
    }
}


class Fpdf_master {
    
    public function __construct()
    {
        //require_once APPPATH . 'third_party/fpdf/fpdf.php';

        //$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 10);

        $pdf->AddPage();

        $CI =& get_instance();

        $CI->fpdf = $pdf;
    }




}

