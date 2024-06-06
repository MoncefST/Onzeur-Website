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
        $this->load->model('Model_music');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('html');
    
        $limit = 30;
        $offset = ($page - 1) * $limit;
        $sort = $this->input->get('sort');
        $genre_id = $this->input->get('genre_id');
        $artist_id = $this->input->get('artist_id');
    
        $musiques = $this->Model_music->getMusiques($limit, $offset, $sort, 'ASC', $genre_id, $artist_id);
        $total_musiques = $this->Model_music->get_total_musiques();
        $total_pages = ceil($total_musiques / $limit); 

        // Vérifier si la page demandée est valide
        if ($page < 1 || $page > $total_pages) {
            redirect('errors/error_404');
            return;
        }

        $current_page = $page; 
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
    
        $this->load->view('layout/header_dark', $data);
        $this->load->view('musiques_list', $data);
        $this->load->view('layout/footer_dark');
    }    
    
}
