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
        $data['title']="Mentions Légales";
        $data['css']="assets/css/mention-legals";

        $this->load->view('layout/header_dark',$data);
        $this->load->view('mentions-legals');
        $this->load->view('layout/footer_dark');
        
    }
}
