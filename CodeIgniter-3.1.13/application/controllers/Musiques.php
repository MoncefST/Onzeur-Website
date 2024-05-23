<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musiques extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_music');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('html');
    }

    public function index($page = 1){
        // Nombre de musiques par page
        $limit = 30; 
        // Calcul de l'offset pour la pagination
        $offset = ($page - 1) * $limit;
        
        // Récupérer la valeur de tri depuis la requête GET
        $sort = $this->input->get('sort');
    
        // Récupérer les musiques triées
        $musiques = $this->Model_music->getMusiques($limit, $offset, $sort);
        
        // Récupérer le nombre total de musiques pour la pagination
        $total_musiques = $this->Model_music->get_total_musiques();
        // Calculer le nombre total de pages
        $total_pages = ceil($total_musiques / $limit); 
        // Définition de la variable $current_page
        $current_page = $page; 
    
        // Données à passer à la vue
        $data['musiques'] = $musiques;
        $data['total_pages'] = $total_pages;
        $data['current_page'] = $current_page;
        $data['sort'] = $sort; // Passer la valeur de tri à la vue
    
        // Charger la vue
        $this->load->view('layout/header_not_logged_dark');
        $this->load->view('musiques_list', $data);
        $this->load->view('layout/footer_dark');
    }
    
}
