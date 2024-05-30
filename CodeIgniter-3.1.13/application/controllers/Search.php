<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Search_model');
        $this->load->helper(['url', 'html']);
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

        $data['title'] = "Résultats de la recherche";
        $data['css'] = "assets/css/search_results";
        
        $this->load->view('layout/header_dark', $data);
        $this->load->view('search_results', $data); 
        $this->load->view('layout/footer_dark');
    }
}
?>
