<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musiques extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_music');
        $this->load->model('Model_playlist');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
    }

    public function index($page = 1){
        $limit = 30;
        $offset = ($page - 1) * $limit;
        $sort = $this->input->get('sort');
        $genre_id = $this->input->get('genre_id');
        $artist_id = $this->input->get('artist_id');
    
        $total_musiques = $this->Model_music->get_total_musiques_filtered($genre_id, $artist_id);
        $total_pages = ceil($total_musiques / $limit);      
    
        $current_page = $page; 
        $musiques = $this->Model_music->getMusiques($limit, $offset, $sort, 'ASC', $genre_id, $artist_id);
        $genres = $this->Model_music->getGenres();
        $artists = $this->Model_music->getArtists();
    
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $data['user_playlists'] = $this->Model_playlist->get_user_playlists($user_id);
        }
    
        $data['musiques'] = $musiques;
        $data['total_pages'] = $total_pages;
        $data['current_page'] = $current_page;
        $data['sort'] = $sort;
        $data['genres'] = $genres;
        $data['artists'] = $artists;
        $data['genre_id'] = $genre_id;
        $data['artist_id'] = $artist_id;
    
        $data['title'] = "Musiques - Onzeur";
        $data['css'] = "assets/css/musiques_list";

        // Vérifier si la page demandée est valide
        if ($page > $total_pages || $page < 1) {
            // Définir le message d'erreur
            $data['error_message'] = "Aucun résultat n'a été trouvé...";
            // Charger la vue des musiques avec le message d'erreur
            $this->load->view('layout/header_dark', $data);
            $this->load->view('musiques_list', $data);
            $this->load->view('layout/footer_dark');
            return;
        }  
    
        $this->load->view('layout/header_dark', $data);
        $this->load->view('musiques_list', $data);
        $this->load->view('layout/footer_dark');
    }
    
    public function view($song_id) {
        // Récupérer les détails de la musique
        $song = $this->Model_music->get_music_details($song_id);
        if (empty($song)) {
            show_404(); // Afficher une erreur 404 si la musique n'est pas trouvée
            return;
        }
    
        // Récupérer les playlists de l'utilisateur s'il est connecté
        $user_playlists = array();
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $user_playlists = $this->Model_playlist->get_user_playlists($user_id);
        }
    
        // Assurez-vous que $song contient l'ID du genre avant de le passer à la vue
        $genre_id = isset($song->genre_id) ? $song->genre_id : null;
    
        // Récupérer des musiques recommandées du même genre ou du même artiste
        $recommended_songs = $this->Model_music->get_recommended_songs($genre_id, $song->artist_id);
    
        // Charger la vue avec les données récupérées
        $data['song'] = $song;
        $data['user_playlists'] = $user_playlists;
        $data['recommended_songs'] = $recommended_songs;
        $data['title'] = "Détails de la musique - Onzeur";
        $data['css'] = "assets/css/music_details.css";
    
        $this->load->view('layout/header_dark', $data);
        $this->load->view('music_details', $data);
        $this->load->view('layout/footer_dark');
    }    
}
