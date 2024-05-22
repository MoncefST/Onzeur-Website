<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Albums extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('model_music');
        $this->load->helper('url');
    }

    public function index($page = 1){
        $limit = 21; // Nombre d'albums max par page
        $offset = ($page - 1) * $limit;
        $albums = $this->model_music->getAlbums($limit, $offset);

        $total_albums = $this->model_music->get_total_albums();
        $data['total_pages'] = ceil($total_albums / $limit);
        $data['current_page'] = $page;
        $data['albums'] = $albums;

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
