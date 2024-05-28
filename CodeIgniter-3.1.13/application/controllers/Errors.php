<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function error_404() {
        $this->output->set_status_header('404');
        $this->load->view('layout/header_dark');
        $this->load->view('error_404');
        $this->load->view('layout/footer_dark');
    }
}
