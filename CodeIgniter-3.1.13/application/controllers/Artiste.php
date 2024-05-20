<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artiste extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_music');
        $this->load->helper('url');
    }

    public function index($artiste_id){
        // Récupérer les détails de l'artiste
        $artiste = $this->Model_music->getArtisteById($artiste_id);

        if($artiste){
            // Récupérer tous les albums de l'artiste
            $albums = $this->Model_music->getAlbumsByArtiste($artiste_id);
            
            // Charger la vue avec les détails de l'artiste et ses albums
            $data['artiste'] = $artiste;
            $data['albums'] = $albums;
            $this->load->view('layout/header_not_logged_dark');
            $this->load->view('artiste_details', $data); // Créez cette vue
            $this->load->view('layout/footer_dark');
        } else {
            // Gérer le cas où l'artiste n'est pas trouvé
            show_404(); // Affiche une page d'erreur 404
        }
    }
}
?>
