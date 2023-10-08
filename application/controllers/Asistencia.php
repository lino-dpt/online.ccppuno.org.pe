<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Asistencia_model");
    }

    public function ac94d31653bde841bd0dcb5745a2cdf7eb5b56d()
    {
    
        $this->load->view('asistencia');
        
    }



    public function listado_xls()
    {
        date_default_timezone_set('America/LIma');
        $this->load->library('tcpdf_masterA4');
        $this->tcpdf->SetTitle('Registro');

        $this->tcpdf->SetAutoPageBreak(true, 15);

        $asistencia = array(
            'registros' => $this->Asistencia_model->getListado()
        );

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=archivo.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

      
        $html = '<table border="0">';
        $html .= '<thead>';
        $html .= '    
            <tr style="padding:3px;">
                <th width="20" align="center" style="font-weight: bold;">Nro</th>
                <th width="65" align="center" style="font-weight: bold;">Matricula</th>
                <th width="140" align="center" style="font-weight: bold;">DNI</th>
                <th width="50" align="center" style="font-weight: bold;">Paterno</th>
                <th width="35" align="center" style="font-weight: bold;">Materno</th>
                <th width="35" align="center" style="font-weight: bold;">Nombres</th>
                <th width="35" align="center" style="font-weight: bold;">Fecha_Hora</th>
            </tr>
            </thead>
            <tbody>
            <tr><td colspan="30"><table border="1" style="padding:3px;">';

        $i = 1;
        foreach($asistencia['registros'] as $r){
            $html .= '<tr>';
            $html .= '<td width="40">'.$i.'</td>';
            $html .= '<td width="65">'.$r->nummat.'</td>';
            $html .= '<td width="140">'.$r->dni.'&nbsp;</td>';
            $html .= '<td width="50">'.utf8_decode($r->paterno).'</td>';
            $html .= '<td width="35">'.utf8_decode($r->materno).'</td>';
            $html .= '<td width="35">'.utf8_decode($r->nombres).'</td>';
            $html .= '<td width="35">'.$r->fecha_hora.'</td>';
            $html .= '</tr>';
            $i++;
        }

        $html .= '</table></td></tr></tbody></table>';

        echo $html;




       
    }



    
    public function gethabil_dni()
    {
        $codigo = $this->input->post("codigo");
        $registros = $this->Asistencia_model->getHabil_dni($codigo);
        echo json_encode($registros);
    }


}
