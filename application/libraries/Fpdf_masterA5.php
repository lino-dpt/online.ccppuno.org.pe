<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    require_once APPPATH . 'third_party/fpdf/fpdf.php';
    require_once APPPATH . 'third_party/qrcode/qrcode.class.php';

    class PDF extends FPDF {
        
        function Header()
        {
            
            // Logo
            $this->Image(base_url().'resources/img/logo.png',5,2,28,28);
            // Arial bold 15
            $this->SetFont('Arial','B',12);
            // Movernos a la derecha
            $this->Cell(20);
            $this->Cell(0,10,utf8_decode('COLEGIO DE CONTADORES PÚBLICOS DE PUNO'),0,0,'C');
            $this->Ln(6);
            // Salto de línea
            
            $this->SetFont('Arial','B',11);
            $this->Cell(20);
            $this->Cell(0,10,utf8_decode('Ley Nº13253 y Ley Nº28951 D.S. Nº28 del 26-08-60'),0,0,'C');
            // Salto de línea

            $this->Line(33,22,145,22);
        }
        
        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-17);

            $this->Line(1,192,148,192);

            // Arial italic 8
            $this->SetFont('Arial','I',8);
            $texto = 'Puno: Jr. Libertad Nº745-Teléfono: 051-351509, Cel. 990909269, Email: subccppuno@gmail.com - Filial Juliaca: Av. Circunvalación esquina con Jr. Chicana Mz. F16 - Lts. 1,2,3 - Urb. Taparachi III (Ref. a 4 cuadras del óvalo de la UANCV, Teléfono: 051-327281, Cel. 990909289, Email: ccpp.fjuliaca@gmail.com, Web: http//www.ccpuno.pe).';
            $this->MultiCell(0,3,utf8_decode($texto),0,'J');

        }
    }


    class Fpdf_masterA5 {
        
        public function __construct()
        {
            //require_once APPPATH . 'third_party/fpdf/fpdf.php';

            //$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
            $pdf = new PDF($orientation='P',$unit='mm', "A5");
            
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

