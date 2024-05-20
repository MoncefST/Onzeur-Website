<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musiques extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_music');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index($page = 1){
        $limit = 30; // Nombre de musiques par page
        $offset = ($page - 1) * $limit;
        
        $musiques = $this->Model_music->getMusiques($limit, $offset);
        
        $total_musiques = $this->Model_music->get_total_musiques();
        $data['total_pages'] = ceil($total_musiques / $limit); // Calcul du nombre total de pages
        $data['current_page'] = $page; // Définition de la variable $current_page
        
        // Données à passer à la vue
        $data['musiques'] = $musiques;
    
        // Charger la vue
        $this->load->view('layout/header_not_logged_dark');
        $this->load->view('musiques_list', $data);
        $this->load->view('layout/footer_dark');
    }
    
      
}
?>
