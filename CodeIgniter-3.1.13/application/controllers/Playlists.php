<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlists extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_playlist');
        $this->load->model('Model_music');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session'); // Charger la bibliothèque de sessions
    }

    public function index(){
        // Récupérer l'ID de l'utilisateur connecté depuis la session
        $user_id = $this->session->userdata('user_id');
    
        // Vérifier si l'utilisateur est connecté
        if ($user_id) {
            $data['playlists'] = $this->Model_playlist->get_user_playlists($user_id);
            $this->load->view('layout/header_dark');
            $this->load->view('playlists_list', $data);
            $this->load->view('layout/footer_dark');
        } else {
            redirect('utilisateur/connexion');
        }
    }
    

    public function create() {
        if ($this->input->post()) {
            // Récupérer l'ID de l'utilisateur depuis la session
            $user_id = $this->session->userdata('user_id');
    
            // Vérifier si l'ID de l'utilisateur est présent
            if($user_id) {
                // Si l'ID de l'utilisateur est disponible, créer la playlist avec cet ID
                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'utilisateur_id' => $user_id // Ajoutez l'ID de l'utilisateur
                );
                $this->Model_playlist->create_playlist($data);
                redirect('playlists');
            } else {
                // Gérer le cas où l'ID de l'utilisateur est manquant
                // Peut-être rediriger vers la page de connexion ou afficher un message d'erreur
                redirect('utilisateur/connexion');
            }
        } else {
            $this->load->view('layout/header_dark');
            $this->load->view('playlist_create');
            $this->load->view('layout/footer_dark');
        }
    }
    


    public function update($playlist_id) {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            $this->Model_playlist->update_playlist($playlist_id, $data);
            redirect('playlists/view/' . $playlist_id);
        } else {
            // Gérer le cas où les données POST ne sont pas disponibles
            redirect('playlists/view/' . $playlist_id);
        }
    }
    
    public function add_song($playlist_id) {
        if ($this->input->post()) {
            $data = array(
                'playlist_id' => $playlist_id,
                'song_id' => $this->input->post('song_id')
            );
            $this->Model_playlist->add_song_to_playlist($data);
            redirect('playlists/view/' . $playlist_id);
        } else {
            // Récupérer toutes les musiques disponibles
            $data['songs'] = $this->Model_music->get_all_songs();
            $data['playlist_id'] = $playlist_id;
            $this->load->view('layout/header_dark');
            $this->load->view('playlist_add_song', $data);
            $this->load->view('layout/footer_dark');
        }
    }   

    public function delete($playlist_id) {
        $this->Model_playlist->delete_playlist($playlist_id);
        redirect('playlists');
    }

    public function remove_song($playlist_id, $song_id) {
        $this->Model_playlist->remove_song_from_playlist($playlist_id, $song_id);
        redirect('playlists/view/' . $playlist_id);
    }

    public function duplicate($playlist_id) {
        $playlist = $this->Model_playlist->get_playlist_by_id($playlist_id);
        $songs = $this->Model_playlist->get_songs_by_playlist($playlist_id);

        $new_playlist = array(
            'name' => $playlist->name . ' (Duplicate)',
            'description' => $playlist->description,
            'utilisateur_id' => $playlist->utilisateur_id
        );

        $this->Model_playlist->create_playlist($new_playlist);
        $new_playlist_id = $this->db->insert_id();

        foreach ($songs as $song) {
            $data = array(
                'playlist_id' => $new_playlist_id,
                'song_id' => $song->id
            );
            $this->Model_playlist->add_song_to_playlist($data);
        }

        redirect('playlists');
    }

    public function generate_random() {
        $songs = $this->Model_music->get_random_songs(10); // 10 chansons aléatoires
        $new_playlist = array(
            'name' => 'Random Playlist ' . date('Y-m-d H:i:s'),
            'description' => 'A randomly generated playlist',
            'utilisateur_id' => $this->session->userdata('user_id')
        );

        $this->Model_playlist->create_playlist($new_playlist);
        $new_playlist_id = $this->db->insert_id();

        foreach ($songs as $song) {
            $data = array(
                'playlist_id' => $new_playlist_id,
                'song_id' => $song->id
            );
            $this->Model_playlist->add_song_to_playlist($data);
        }

        redirect('playlists');
    }

    public function add_album($playlist_id) {
        if ($this->input->post()) {
            // Récupérer l'ID de l'album à partir du formulaire
            $album_id = $this->input->post('album_id');
            
            // Récupérer toutes les chansons de l'album
            $songs = $this->Model_music->get_songs_by_album($album_id);
    
            // Ajouter chaque chanson à la playlist
            foreach ($songs as $song) {
                $data = array(
                    'playlist_id' => $playlist_id,
                    'song_id' => $song->id
                );
                $this->Model_playlist->add_song_to_playlist($data);
            }
            
            redirect('playlists/view/' . $playlist_id);
        } else {
            // Récupérer tous les albums disponibles
            $data['albums'] = $this->Model_music->get_all_albums();
            $data['playlist_id'] = $playlist_id;
            $this->load->view('layout/header_dark');
            $this->load->view('playlist_add_album', $data);
            $this->load->view('layout/footer_dark');
        }
    }
    
    public function view($playlist_id) {
        // Charger les détails de la playlist spécifique en fonction de son ID
        $data['playlist'] = $this->Model_playlist->get_playlist_by_id($playlist_id);
        
        // Charger les chansons de la playlist spécifique
        $data['songs'] = $this->Model_playlist->get_songs_by_playlist($playlist_id);
        
        // Charger la vue pour afficher les détails de la playlist
        $this->load->view('layout/header_dark');
        $this->load->view('playlist_view', $data);
        $this->load->view('layout/footer_dark');
    }
    
    
    
}
?>
