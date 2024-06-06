<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('html');
    }

    public function index() {
        // Charger le modèle
        $this->load->model('Cover_model');
        $this->load->model('Utilisateur_model');
    
        $this->load->helper('url');
        $this->load->helper('html');

        $data['title']='Accueil - Onzeur';
        $data['css']='assets/css/accueil';
    
        // Appeler la fonction pour récupérer les couvertures d'albums
        $data['covers'] = $this->Cover_model->get_covers();
    
        // Récupérer les avis récents
        $data['avis'] = $this->Utilisateur_model->get_recent_avis();
    
        // Charger la vue avec les données récupérées
        $this->load->view('layout/header_dark', $data);
        $this->load->view('accueil',$data);
        $this->load->view('layout/footer_dark');
    }
    
}
?>
