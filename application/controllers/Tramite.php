<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tramite extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Tramite_model");
        $this->load->model("Menu_model");
    
        /*if (!$this->session->userdata("acceso")) {
            redirect(base_url()."acceso");
        }*/
    }

    public function nuevo()
    {
        $data = array(
            'tupas' => $this->Tramite_model->getTupa(),
            'tdocumentos' => $this->Tramite_model->getTdocumentos()
        );
     
        $this->load->view('newnopresencial', $data);
    }
    
    public function insertno()
    {
        $data =  array(
            'tpersona' => $this->input->post("tpersona"),
            'numdoc' => $this->input->post("numdoc"),
            'paterno' => $this->input->post("paterno"),
            'materno' => $this->input->post("materno"),
            'nombres' => $this->input->post("nombres"),
            'email' => $this->input->post("email"),
            'celular' => $this->input->post("celular"),
            'numero_documento' => $this->input->post("numero_documento"),
            'fecha_documento' => $this->input->post("fecha_documento"),
            'asunto' => $this->input->post("asunto"),
            'obs' => $this->input->post("obs"),
            'idtupa' => $this->input->post("idtupa")
        );
        
        $id = $this->Tramite_model->insertno($data);
     
        $data = array(
            'idregistrono' => $id,
            'idtupa' => $this->input->post("idtupa"),
            'new_registro' => true
        );
     
        $this->session->set_userdata($data);
        redirect(base_url()."tramite/nopresencial");            
        
        //ojo controlar si falla insert
        //}else{
            
            //$this->session->set_flashdata("error", "No se pudo guardar");
            //redirect(base_url()."tramite/nuevo");

        //}
    }


    public function nopresencial()
    {
        if (!$this->session->userdata("new_registro")) {
            redirect(base_url()."acceso");
        }

        $idregistrono = $this->session->userdata("idregistrono");
        $idtupa = $this->session->userdata("idtupa");

        $data = array(
            'documento' => $this->Tramite_model->getDocumento($idregistrono),
            'requisitos' => $this->Tramite_model->getRequisitos($idtupa)
        );

        $this->load->view('nopresencial-attach', $data);
    }

    public function upload(){

        if (!$this->session->userdata("new_registro")) {
            redirect(base_url()."acceso");
        }
                
        $idregistrono = $this->session->userdata("idregistrono");
        $idtupa =  $this->session->userdata("idtupa");

        $id = $this->Tramite_model->insert($idregistrono);

        $extension = pathinfo($_FILES['upfile_0']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['upfile_0']['tmp_name'], "files/registro/".$id.".".$extension);

        $requisitos = $this->Tramite_model->getRequisitos($idtupa);
        foreach($requisitos as $req){

            $extension = pathinfo($_FILES['upfile_'.$req->idrequisito]['name'], PATHINFO_EXTENSION);
    
            $data =  array(
                'id' => $id,
                'idrequisito' => $req->idrequisito,
                'tipo' => $req->tipo,
                'voucher' => $this->input->post("voucher_upfile_".$req->idrequisito),
                'fecha' => $this->input->post("fecha_upfile_".$req->idrequisito),
                'importe' => $this->input->post("importe_upfile_".$req->idrequisito),
                'extension' => $extension
            );

            $this->Tramite_model->insert_requisito($data);

            if(!move_uploaded_file($_FILES['upfile_'.$req->idrequisito]['tmp_name'], "files/registro/".$id."_".$req->idrequisito.".".$extension)){
                echo "Errror.";
            }
        }
        
        redirect(base_url()."tramite/finalizarno");

    }


    public function finalizarno(){
        if (!$this->session->userdata("new_registro")) {
            redirect(base_url()."acceso");
        }


        $idregistrono = $this->session->userdata("idregistrono");

        $data = array(
            'documento' => $this->Tramite_model->getFinalizado($idregistrono)
        );

        $this->session->sess_destroy();

        $this->load->view('finalizarno',$data);

    }


    public function login()
    {
        $registro = $this->input->post("registro");
        $clave = $this->input->post("clave");
        $resp = $this->Tramite_model->acceso($registro, $clave);

        if (!$resp['flag']) {
            $this->session->set_flashdata("error", "No existe el registro con los datos ingresados.");
            redirect(base_url()."acceso");
        }else{
            $data = array(
                'idregistro' => $resp['registro']->idregistro,
                'login' => true
            );

            $this->session->set_userdata($data);
            redirect(base_url()."tramite/consultaexterna");
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url()."acceso");
    }

    public function consultaexterna()
    {
        if (!$this->session->userdata("login")) {
            redirect(base_url()."acceso");
        }

        $idregistro = $this->session->userdata("idregistro");

        $data = array(
            'documento' => $this->Tramite_model->getRegistro($idregistro),
            'movimientos' => $this->Tramite_model->getMovimiento($idregistro)
        );

        $this->load->view('consultaexterna', $data);
    }

}
