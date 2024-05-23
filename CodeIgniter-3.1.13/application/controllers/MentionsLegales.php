<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MentionsLegales extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('html');
    }

    public function index()
    {
        include 'temporaire.php';
        if($logged == true){
            $this->load->view('layout/header_dark');
            $this->load->view('layout/header_logged_dark');
            $this->load->view('mentions-legals');
            $this->load->view('layout/footer_dark');
        } else {
            $this->load->view('layout/header_dark');
            $this->load->view('layout/header_not_logged_dark');
            $this->load->view('mentions-legals');
            $this->load->view('layout/footer_dark');
        }
        
    }
}
