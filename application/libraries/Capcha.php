<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    require_once APPPATH . 'third_resources/capcha/securimage.php';

    class Capcha extends Securimage {
        
        public function __construct()
        {

        }
    }

