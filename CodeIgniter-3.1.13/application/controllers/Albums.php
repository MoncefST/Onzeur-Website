<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Albums extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('model_music');
        $this->load->helper('url');
        $this->load->helper('html');
    }

    public function index($page = 1){
        $limit = 21; // Nombre d'albums max par page
        $offset = ($page - 1) * $limit;

        // Récupérer les paramètres de tri et de filtre
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'year';
        $genre_id = $this->input->get('genre_id');
        $artist_id = $this->input->get('artist_id');

        $albums = $this->model_music->getAlbums($limit, $offset, $order_by, $genre_id, $artist_id);
        $total_albums = $this->model_music->get_total_albums($genre_id, $artist_id);

        $data['total_pages'] = ceil($total_albums / $limit);
        $data['current_page'] = $page;
        $data['albums'] = $albums;
        $data['order_by'] = $order_by;
        $data['genre_id'] = $genre_id;
        $data['artist_id'] = $artist_id;

        // Récupérer les genres et les artistes pour les filtres
        $data['genres'] = $this->model_music->getGenres();
        $data['artists'] = $this->model_music->getArtists();

        $this->load->view('layout/header_not_logged_dark');
        $this->load->view('albums_list', $data);
        $this->load->view('layout/footer_dark');
    }

    public function view($id){
        $album = $this->model_music->get_album_by_id($id);
        $data['album'] = $album;

        $this->load->view('layout/header_not_logged_dark');
        $this->load->view('album_view', $data);
        $this->load->view('layout/footer_dark');
    }
}
?>
