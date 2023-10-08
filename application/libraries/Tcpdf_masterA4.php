<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    require_once APPPATH . 'third_party/tcpdf/tcpdf.php';
    require_once APPPATH . 'third_party/qrcode/qrcode.class.php';

    class PDF extends TCPDF {

            public function Header() {
               
                
                $titulo="COLEGIO DE CONTADORES PÚBLICOS DE PUNO";
                $subtitulo="Ley Nº13253 y Ley Nº28951 D.S. Nº28 del 26-08-60";

                /* posicionamos el punto de insercion 5mm. debajo
                   del borde del papel */
                $this->SetY(18);
                $this->SetX(55);

                /* escribimos el titulo con la fuente que se establezca
                por el método opcion SetHeaderFont */
                $this->SetTextColor(0,51,153);
                $this->SetFont('helvetica', 'B', 17, '', true);
                $this->Cell(10, 0,$titulo,0,1,'L');

                /*trazamos una lines debajo del encabezado */
                $this->SetLineStyle(array('width' => 0.6, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 51, 153)));
                $this->Line(45,37,210,37); 

                $this->SetX(30);
                $this->SetY(26);
                $this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 51, 153)));
                $this->SetFillColor(0,51,153);
                $this->SetTextColor(255,255,255);
                $this->MultiCell(30, 10, "", 0, 'C', 0, 0);
                $this->SetFont('helvetica', 'B', 14, '', true);
                $this->MultiCell(165, 10, $subtitulo, 0, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');

                $this->Image(base_url().'/resources/img/logo.png', 5, 8, 35, 35, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);

                $this->SetAlpha(0.15,'Normal');
                $this->Image(base_url().'/resources/img/logo.png', 58, 70, 85, 90, '', '', 'L', false, 150, '', false, false, 0, false, false, false);
                    
            }
            
            public function Footer() {
               // return;
                // Posición: a 1,5 cm del final
                $this->SetY(-25);
                $this->SetX(0);

                $texto = 'Puno: Jr. Libertad Nº745-Teléfono: 051-351509, Cel. 990909269, Email: subccppuno@gmail.com - Filial Juliaca: Av. Circunvalación esquina con Jr. Chicana Mz. F16 - Lts. 1,2,3 - Urb. Taparachi III (Ref. a 4 cuadras del óvalo de la UANCV, Teléfono: 051-327281, Cel. 990909289, Email: ccpp.fjuliaca@gmail.com, Web: https//www.ccpuno.org).';

                $this->SetLineStyle(array('width' => 0.8, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 51, 153)));
                $this->Line(0,271,210,271); 

                $this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 51, 153)));
                $this->SetFillColor(0,51,153);
                $this->SetTextColor(255,255,255);
                $this->SetFont('helvetica', '', 10, '', true);
                $this->setCellPaddings(2, 4, 6, 8);
                $this->MultiCell(0, 18, $texto, 0, 'C', 1, 0, '', '', true, 0, false, true, 18, 'M');

            }

    }


    class Tcpdf_masterA4 {
        
        public function __construct()
        {

            //$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
            $pdf = new PDF($orientation='P',$unit='mm', "A4");
            
            #Establecemos los márgenes izquierda, arriba y derecha:
            $pdf->SetMargins(PDF_MARGIN_LEFT, 50 , 0);
            
            //$pdf = new PDF();
            //$pdf->AliasNbPages();
            
            //$pdf->SetAutoPageBreak(true, 57);

            $pdf->AddPage();

            $CI =& get_instance();

            $CI->tcpdf = $pdf;
        }




    }

