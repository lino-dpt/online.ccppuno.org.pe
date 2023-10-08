<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Agremiado_model");
    }

	public function index()
	{
        if ($this->session->userdata("admin_app")) {
            redirect(base_url()."dashboard");
        }else{
            $this->load->view('admin/login');
        }
		
    }
    
    public function login()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $resp = $this->Agremiado_model->login($username, sha1($password));

        if (!$resp['flag']) {
            $this->session->set_flashdata("error", "El usuario y/o contraseña son incorrectos");
            redirect(base_url());
        }else{
            $data = array(
                'id' => $resp['registro']->id,
                'nombres' => $resp['registro']->nombres,
                'matricula' => $resp['registro']->nummat,
                'nombre' => $resp['registro']->nombre,
                'cambiar_clave' => $resp['registro']->flag_cambiarclave,
                'subir_foto' => $resp['registro']->flag_subirfoto,
                'extension_foto' => $resp['registro']->extension_foto,
                'actualizar_datos' => $resp['registro']->flag_actualizar,
                'admin_app' => true
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
