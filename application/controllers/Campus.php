<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campus extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Certificado_model");
    }

    public function certificado($var,$id)
    {
    
        $data = array(
            'datos' => $this->Certificado_model->getCertificado($id)
        );
        
        if(isset($data['datos'][0]->dni)){
            $data['estado'] = "SI";
        }
        else{
            $data['estado'] = "NO";
        }


        $this->load->view('certificado', $data);
        
    }
    


}
