<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Search_model');
        $this->load->model('Model_playlist');
        $this->load->helper(['url', 'html']);
        $this->load->library('session');
    }

    public function index(){
        $query = $this->input->get('query');

        if (empty($query)) {
            $data['query'] = $query;
            $data['musiques'] = [];
            $data['albums'] = [];
            $data['genres'] = [];
            $data['artistes'] = [];
            $data['error'] = "La requête de recherche ne peut pas être vide.";

            $data['title'] = "Résultats de la recherche";
            $data['css'] = "assets/css/search_results";

            $this->load->view('layout/header_dark', $data);
            $this->load->view('search_results', $data); 
            $this->load->view('layout/footer_dark');
            return;
        }

        $musiques = $this->Search_model->searchMusiques($query); 
        $albums = $this->Search_model->searchAlbums($query); 
        $genres = $this->Search_model->searchGenres($query); 
        $artistes = $this->Search_model->searchArtistes($query); 

        $data['query'] = $query;
        $data['musiques'] = $musiques;
        $data['albums'] = $albums;
        $data['genres'] = $genres;
        $data['artistes'] = $artistes;
                
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $data['user_playlists'] = $this->Model_playlist->get_user_playlists($user_id);
        }

        $data['title'] = "Résultats de la recherche";
        $data['css'] = "assets/css/search_results";
        
        $this->load->view('layout/header_dark', $data);
        $this->load->view('search_results', $data); 
        $this->load->view('layout/footer_dark');
    }
}
?>
