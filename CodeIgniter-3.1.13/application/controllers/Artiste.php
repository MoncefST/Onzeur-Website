<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artiste extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_artist');
        $this->load->model('Model_music'); // Chargez également le modèle Model_music si vous en avez besoin
        $this->load->helper('url');
    }

    public function index($artiste_id){
        // Récupérer les détails de l'artiste
        $artiste = $this->Model_artist->getArtisteById($artiste_id);

        if($artiste){
            // Récupérer tous les albums de l'artiste
            $albums = $this->Model_music->getAlbumsByArtiste($artiste_id); // Utilisez le modèle Model_music ici
            
            // Charger la vue avec les détails de l'artiste et ses albums
            $data['artiste'] = $artiste;
            $data['albums'] = $albums;
            $this->load->view('layout/header_not_logged_dark');
            $this->load->view('artiste_details', $data);
            $this->load->view('layout/footer_dark');
        } else {
            // Gérer le cas où l'artiste n'est pas trouvé
            show_404();
        }
    }

    public function list_artists(){
        // Récupérer la liste des artistes
        $artists = $this->Model_artist->getArtists();

        // Charger la vue avec la liste des artistes
        $data['artists'] = $artists;
        $this->load->view('layout/header_not_logged_dark');
        $this->load->view('artists_list', $data);
        $this->load->view('layout/footer_dark');
    }
}
?>
