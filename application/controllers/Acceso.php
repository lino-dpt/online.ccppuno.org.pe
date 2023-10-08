<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acceso extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anio_model");
        $this->load->model("Personal_model");
    }

    public function index()
    {
        $data = array(
            'anios' => $this->Anio_model->getAnios()
        );

        if ($this->session->userdata("acceso_mesa")) {
            redirect(base_url()."dashboard");
        }else{
            $this->load->view('acceso', $data);
        }
        
    }
    

    public function login()
    {
        $anio = $this->input->post("anio");
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $resp = $this->Personal_model->login($username, sha1($password));

        if (!$resp['flag']) {
            $this->session->set_flashdata("error", "El usuario y/o contraseña son incorrectos");
            //redirect(base_url());
        }else{
            $data = array(
                'idusuario' => $resp['registro']->id,
                'nombres' => $resp['registro']->nombres,
                'nombre' => $resp['registro']->nombre,
                'oficina' => $resp['registro']->desoficina,
                'desrol' => $resp['registro']->desrol,
                'anio' => $anio,
                'acceso_mesa' => true
            );

            $this->session->set_userdata($data);
            redirect(base_url()."dashboard");
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }


}
