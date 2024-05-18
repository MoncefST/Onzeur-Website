<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function index() {
        // Charger la vue de la page d'accueil
        $this->load->view('accueil');
    }
}
