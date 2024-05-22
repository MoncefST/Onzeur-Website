<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Search_model'); 
        $this->load->helper('url');
    }

    public function index(){
        // Récupérer la requête de recherche depuis la barre de recherche
        $query = $this->input->get('query');

        // Faire une recherche dans les musiques, les albums, les genres et les artistes
        $musiques = $this->Search_model->searchMusiques($query); 
        $albums = $this->Search_model->searchAlbums($query); 
        $genres = $this->Search_model->searchGenres($query); 
        $artistes = $this->Search_model->searchArtistes($query); 

        // Charger la vue avec les résultats de la recherche
        $data['query'] = $query;
        $data['musiques'] = $musiques;
        $data['albums'] = $albums;
        $data['genres'] = $genres;
        $data['artistes'] = $artistes;

        $this->load->view('layout/header_not_logged_dark');
        $this->load->view('search_results', $data); 
        $this->load->view('layout/footer_dark');
    }
}