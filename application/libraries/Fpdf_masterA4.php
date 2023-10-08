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

            $this->Line(33,22,206,22);
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
    
        function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5){

            $wide = $baseline;
            $narrow = $baseline / 3 ; 
            $gap = $narrow;

            $barChar['0'] = 'nnnwwnwnn';
            $barChar['1'] = 'wnnwnnnnw';
            $barChar['2'] = 'nnwwnnnnw';
            $barChar['3'] = 'wnwwnnnnn';
            $barChar['4'] = 'nnnwwnnnw';
            $barChar['5'] = 'wnnwwnnnn';
            $barChar['6'] = 'nnwwwnnnn';
            $barChar['7'] = 'nnnwnnwnw';
            $barChar['8'] = 'wnnwnnwnn';
            $barChar['9'] = 'nnwwnnwnn';
            $barChar['A'] = 'wnnnnwnnw';
            $barChar['B'] = 'nnwnnwnnw';
            $barChar['C'] = 'wnwnnwnnn';
            $barChar['D'] = 'nnnnwwnnw';
            $barChar['E'] = 'wnnnwwnnn';
            $barChar['F'] = 'nnwnwwnnn';
            $barChar['G'] = 'nnnnnwwnw';
            $barChar['H'] = 'wnnnnwwnn';
            $barChar['I'] = 'nnwnnwwnn';
            $barChar['J'] = 'nnnnwwwnn';
            $barChar['K'] = 'wnnnnnnww';
            $barChar['L'] = 'nnwnnnnww';
            $barChar['M'] = 'wnwnnnnwn';
            $barChar['N'] = 'nnnnwnnww';
            $barChar['O'] = 'wnnnwnnwn'; 
            $barChar['P'] = 'nnwnwnnwn';
            $barChar['Q'] = 'nnnnnnwww';
            $barChar['R'] = 'wnnnnnwwn';
            $barChar['S'] = 'nnwnnnwwn';
            $barChar['T'] = 'nnnnwnwwn';
            $barChar['U'] = 'wwnnnnnnw';
            $barChar['V'] = 'nwwnnnnnw';
            $barChar['W'] = 'wwwnnnnnn';
            $barChar['X'] = 'nwnnwnnnw';
            $barChar['Y'] = 'wwnnwnnnn';
            $barChar['Z'] = 'nwwnwnnnn';
            $barChar['-'] = 'nwnnnnwnw';
            $barChar['.'] = 'wwnnnnwnn';
            $barChar[' '] = 'nwwnnnwnn';
            $barChar['*'] = 'nwnnwnwnn';
            $barChar['$'] = 'nwnwnwnnn';
            $barChar['/'] = 'nwnwnnnwn';
            $barChar['+'] = 'nwnnnwnwn';
            $barChar['%'] = 'nnnwnwnwn';

            $this->SetFont('Arial','',10);
            $this->Text($xpos, $ypos + $height + 4, 'Registro: '.$code);
            $this->SetFillColor(0);

            $code = '*'.strtoupper($code).'*';
            for($i=0; $i<strlen($code); $i++){
                $char = $code[$i];
                if(!isset($barChar[$char])){
                    $this->Error('Invalid character in barcode: '.$char);
                }
                $seq = $barChar[$char];
                for($bar=0; $bar<9; $bar++){
                    if($seq[$bar] == 'n'){
                        $lineWidth = $narrow;
                    }else{
                        $lineWidth = $wide;
                    }
                    if($bar % 2 == 0){
                        $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
                    }
                    $xpos += $lineWidth;
                }
                $xpos += $gap;
            }
        }

    }


    class Fpdf_masterA4 {
        
        public function __construct()
        {

            //$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
            $pdf = new PDF($orientation='P',$unit='mm', "A4");
            
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

