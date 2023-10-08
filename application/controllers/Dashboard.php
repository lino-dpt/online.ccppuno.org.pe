<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model("Menu_model");

        if (!$this->session->userdata("admin_app")) {
            redirect(base_url());
        }
    }

    public function index()
	{
        $menu = array(
            'menus' => json_decode($this->Menu_model->getMenu())
        );
     
        $this->load->view('layouts/header', $menu);
        $this->load->view('admin/dashboard');
        $this->load->view('layouts/footer');
	}


}
