<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_resources/tcpdf/tcpdf.php';
require_once APPPATH . 'third_resources/qrcode/qrcode.class.php';

class PDF extends TCPDF {

    public function Header() {
       
        /*ponemos color al texto y a las lineas */
        $this->SetTextColor(0,0,0);
        $this->SetDrawColor(0,0,0);
        /* definimos variables con titulo y subtitulo */
        $titulo="Autoridad Nacional del Agua - Puno";
        $subtitulo="Unidad de Logística";

        /* posicionamos el punto de insercion 5mm. debajo
           del borde del papel */
        $this->SetY(5);

        /* escribimos el titulo con la fuente que se establezca
        por el método opcion SetHeaderFont */
        $this->SetFont('helvetica', '', 12, '', true);
        $this->Cell(0, 0,$titulo,0,1,'L');
        $this->SetFont('helvetica', '', 9, '', true);
        $this->Cell(150, 0,$subtitulo,0,false,'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 0, 'Página '.$this->getAliasNumPage().' / '.$this-> getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

        /*trazamos una lines debajo del encabezado */
        $this->Line(15,15,195,15); 

        $this->SetX(7);
        $this->SetY(35);
        $this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        $this->SetFillColor(222,222,222);
        $this->SetTextColor(0,0,0);
        $this->MultiCell(188, 20, "", 1, 'C', 1, 0);

        //if($this->print == "0"){
            $this->SetAlpha(0.15,'Normal');
            $this->Image('./images/logo.png',55,84,100,104,'','','N','','','C');
        /*}else{
            $this->SetAlpha(0.15,'Normal');
            $this->Image('./images/copia.jpg',55,80,150,80,'','','N','','','C');
        }*/

    }
    
    public function Footer() {
          $this->Ln(28);
          $this->SetFont('helveticaB', '', 7, '', true);
          $this->Cell(60, 0, ' ___________________________________ ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
          $this->Cell(60, 0, ' ___________________________________ ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
          $this->Cell(60, 0, ' ___________________________________ ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
          $this->Ln(3);
          $this->Cell(60, 0, 'ALMACENERO', 0, false, 'C', 0, '', 0, false, 'T', 'M');
          $this->Cell(60, 0, 'JEFE DE ALMACEN', 0, false, 'C', 0, '', 0, false, 'T', 'M');
          $this->Cell(60, 0, 'JEFE DE ABASTECIMIENTO', 0, false, 'C', 0, '', 0, false, 'T', 'M');
          $this->Ln(5);

          $this->SetFont('helveticaB', '', 8, '', true);
    }
}





class Tcpdf_masterA5 {
    
    public function __construct()
    {

    }
}

