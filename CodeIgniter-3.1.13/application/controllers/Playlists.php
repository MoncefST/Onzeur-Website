<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlists extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_playlist');
        $this->load->model('Model_music');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
    }

    public function index(){
        // Récupérer l'ID de l'utilisateur connecté depuis la session
        $user_id = $this->session->userdata('user_id');
        
        // Vérifier si l'utilisateur est connecté
        if ($user_id) {
            // Récupérer les playlists de l'utilisateur connecté
            $data['playlists'] = $this->Model_playlist->get_user_playlists($user_id);
            
            // Récupérer les playlists publiques
            $data['public_playlists'] = $this->Model_playlist->get_public_playlists($user_id);
            
            $data['title']="Liste des Playlists - Onzeur";
            $data['css']="assets/css/playlists_list.css";
    
            $this->load->view('layout/header_dark', $data);
            $this->load->view('playlists_list', $data);
            $this->load->view('layout/footer_dark');
        } else {
            redirect('utilisateur/connexion');
        }
    } 
    
    public function verify_playlist_ownership($playlist_id) {
        // Vérifier si l'utilisateur est connecté
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $this->session->userdata('user_id');
    
        // Vérifier si l'utilisateur est le propriétaire de la playlist
        $playlist = $this->Model_playlist->get_playlist_by_id($playlist_id);
        if (!$playlist || $playlist->utilisateur_id !== $user_id) {
            // Rediriger vers une page d'erreur ou une page appropriée
            redirect('utilisateur/non_autorisee');
        }
    }

    public function create() {
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
        
        if ($this->input->post()) {
            // Récupérer l'ID de l'utilisateur depuis la session
            $user_id = $this->session->userdata('user_id');
    
            // Vérifier si l'ID de l'utilisateur est présent
            if($user_id) {
                // Si l'ID de l'utilisateur est disponible, créer la playlist avec cet ID
                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'utilisateur_id' => $user_id, // Ajoutez l'ID de l'utilisateur
                    'public' => $this->input->post('public') ? 1 : 0 // Champ pour définir si la playlist est publique ou privée
                );
                $this->Model_playlist->create_playlist($data);
                redirect('playlists');
            } else {
                // Gérer le cas où l'ID de l'utilisateur est manquant
                // Peut-être rediriger vers la page de connexion ou afficher un message d'erreur
                redirect('utilisateur/connexion');
            }
        } else {
    
            $data['title']="Créer une Nouvelle Playlist";
            $data['css']="assets/css/playlist_create";
    
            $this->load->view('layout/header_dark', $data);
            $this->load->view('playlist_create');
            $this->load->view('layout/footer_dark');
        }
    }
    
    public function update($playlist_id) {
        // Vérifier si l'utilisateur est connecté et s'il est propriétaire de la playlist
        $this->verify_playlist_ownership($playlist_id);
    
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $this->session->userdata('user_id');
    
        // Vérifier si l'utilisateur est le propriétaire de la playlist
        $playlist = $this->Model_playlist->get_playlist_by_id($playlist_id);
        if (!$playlist || $playlist->utilisateur_id !== $user_id) {
            // Rediriger vers une page d'erreur ou une page appropriée
            redirect('erreur/page_non_autorisee');
        }
    
        // Si les vérifications sont réussies, procéder à la mise à jour de la playlist
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'public' => $this->input->post('public') ? 1 : 0 // Mise à jour de la visibilité
            );
            $this->Model_playlist->update_playlist($playlist_id, $data);
            redirect('playlists/view/' . $playlist_id);
        } else {
            // Gérer le cas où les données POST ne sont pas disponibles
            redirect('playlists/view/' . $playlist_id);
        }
    }    
    
    public function add_song($playlist_id) {
    $this->verify_playlist_ownership($playlist_id);
        if ($this->input->post()) {
            $data = array(
                'playlist_id' => $playlist_id,
                'song_id' => $this->input->post('song_id')
            );
            $result = $this->Model_playlist->add_song_to_playlist($data);
            if ($result) {
                $this->session->set_flashdata('success', 'La chanson a été ajoutée à la playlist.');
            } else {
                $this->session->set_flashdata('error', 'La chanson existe déjà dans la playlist.');
            }
            redirect('playlists/view/' . $playlist_id);
        } else {
            $data['songs'] = $this->Model_music->get_all_songs();
            $data['playlist_id'] = $playlist_id;
            $data['title']="Ajouter une Chanson à la Playlist";
            $data['css']="assets/css/playlist_add_song";

            $this->load->view('layout/header_dark', $data);
            $this->load->view('playlist_add_song',$data);
            $this->load->view('layout/footer_dark');
        }
    }
     
    public function delete($playlist_id) {
    $this->verify_playlist_ownership($playlist_id);
        $this->Model_playlist->delete_playlist($playlist_id);
        redirect('playlists');
    }

    public function remove_song($playlist_id, $song_id) {
    $this->verify_playlist_ownership($playlist_id);

        $this->Model_playlist->remove_song_from_playlist($playlist_id, $song_id);
        redirect('playlists/view/' . $playlist_id);
    }

    public function duplicate($playlist_id) {
    $this->verify_playlist_ownership($playlist_id);
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
        date_default_timezone_set('Europe/Paris');
    
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $genre = $this->input->post('genre');
            $artist = $this->input->post('artist');
            $nbrMusiqueAleatoire = $this->input->post('nbrMusiqueAleatoire');
            $nbrMusiqueAleatoire = is_numeric($nbrMusiqueAleatoire) ? intval($nbrMusiqueAleatoire) : 10;
            $songs = $this->Model_music->get_random_songs($nbrMusiqueAleatoire, $genre, $artist);
            
            $nbrChansonsObtenues = count($songs); // Nombre de chansons réellement obtenues

            if ($nbrChansonsObtenues < $nbrMusiqueAleatoire) {
                $message = "La playlist a été créée avec seulement $nbrChansonsObtenues musiques, car il n'y en avait pas assez dans la base de données.";
                $this->session->set_flashdata('message', $message);
            }
            
            $new_playlist = array(
                'name' => 'Playlist aléatoire',
                'description' => 'Une playlist avec ' . $nbrChansonsObtenues . ' musiques aléatoires du ' . date('d/m/Y H:i:s'),
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
    
            if ($nbrChansonsObtenues < $nbrMusiqueAleatoire) {
                $message = "La playlist a été créée avec seulement $nbrChansonsObtenues musiques, car il n'y en avait pas assez dans la base de données.";
                $this->session->set_flashdata('message', $message);
            }
    
            redirect('playlists');
        } else {
            $data['genres'] = $this->Model_music->get_all_genres();
            $data['artists'] = $this->Model_music->get_all_artists();
            $data['title']="Générer une playlist - Onzeur";
            $data['css']="assets/css/generate_playlist";
    
            $this->load->view('layout/header_dark',$data);
            $this->load->view('generate_playlist', $data);
            $this->load->view('layout/footer_dark');
        }
    }
    

    public function add_album($playlist_id) {
        $this->verify_playlist_ownership($playlist_id);

        if ($this->input->post()) {
            $album_id = $this->input->post('album_id');
            $songs = $this->Model_music->get_songs_by_album($album_id);
            $all_songs_exist = true; // Variable pour vérifier si toutes les chansons existent déjà dans la playlist
    
            foreach ($songs as $song) {
                if (!$this->Model_playlist->song_exists_in_playlist($playlist_id, $song->id)) {
                    $all_songs_exist = false;
                    break;
                }
            }
    
            if ($all_songs_exist) {
                $this->session->set_flashdata('error', 'Toutes les chansons de cet album existent déjà dans la playlist.');
            } else {
                foreach ($songs as $song) {
                    if (!$this->Model_playlist->song_exists_in_playlist($playlist_id, $song->id)) {
                        $data = array(
                            'playlist_id' => $playlist_id,
                            'song_id' => $song->id
                        );
                        $this->Model_playlist->add_song_to_playlist($data);
                    }
                }
    
                $this->session->set_flashdata('success', 'Album ajouté avec succès à la playlist, les chansons manquantes ont été ajoutées.');
            }
    
            redirect('playlists/view/' . $playlist_id);
        } else {
            $data['albums'] = $this->Model_music->get_all_albums();
            $data['playlist_id'] = $playlist_id;

            $data['title']="Ajouter un Album à la Playlist";
            $data['css']="assets/css/playlist_add_song";

            $this->load->view('layout/header_dark', $data);
            $this->load->view('playlist_add_album',$data);
            $this->load->view('layout/footer_dark');
        }
    }

    public function add_album_to_playlist($album_id, $playlist_id) {
        // Vérifiez si l'utilisateur est connecté
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        // Ajouter toutes les chansons de l'album à la playlist spécifiée
        $songs = $this->Model_music->get_songs_by_album($album_id);
        foreach ($songs as $song) {
            $data = array(
                'playlist_id' => $playlist_id,
                'song_id' => $song->id
            );
            $this->Model_playlist->add_song_to_playlist($data);
        }
    
        redirect('playlists/view/' . $playlist_id);
    }     
    
    public function view($playlist_id) {
        // Vérifiez si la playlist est accessible à l'utilisateur actuellement connecté
        $this->verify_playlist_accessibility($playlist_id);
    
        // Charger les détails de la playlist spécifique en fonction de son ID
        $data['playlist'] = $this->Model_playlist->get_playlist_by_id($playlist_id);
    
        // Charger les chansons de la playlist spécifique
        $data['songs'] = $this->Model_playlist->get_songs_by_playlist($playlist_id);
    
        // Charger la liste des playlists de l'utilisateur
        $user_id = $this->session->userdata('user_id');
        $data['user_playlists'] = $this->Model_playlist->get_user_playlists($user_id);
    
        $data['title'] = "Détails de la Playlist - Onzeur";
        $data['css'] = "assets/css/playlist_view";
    
        // Charger la vue pour afficher les détails de la playlist
        $this->load->view('layout/header_dark', $data);
        $this->load->view('playlist_view', $data);
        $this->load->view('layout/footer_dark');
    }    
    
    private function verify_playlist_accessibility($playlist_id) {
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $this->session->userdata('user_id');
    
        // Récupérer les détails de la playlist
        $playlist = $this->Model_playlist->get_playlist_by_id($playlist_id);
    
        // Vérifier si la playlist existe et si elle est publique
        if (!$playlist || ($playlist->public == 0 && $playlist->utilisateur_id !== $user_id)) {
            // Rediriger vers une page d'erreur ou une page appropriée
            redirect('erreur/page_non_autorisee');
        }
    }

    public function add_music_to_playlist($music_id, $playlist_id) {
        // Vérifier si l'utilisateur est connecté
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        $data = array(
            'playlist_id' => $playlist_id,
            'song_id' => $music_id
        );
        $this->Model_playlist->add_song_to_playlist($data);
    
        redirect('playlists/view/' . $playlist_id);
    }

    public function add_track_to_playlist($track_id, $playlist_id) {
        // Vérifier si l'utilisateur est connecté
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        // Récupérer le song_id à partir du track_id
        $song_id = $this->Model_playlist->get_song_id_by_track_id($track_id);
    
        $data = array(
            'playlist_id' => $playlist_id,
            'song_id' => $song_id
        );
        $this->Model_playlist->add_song_to_playlist($data);
    
        redirect('playlists/view/' . $playlist_id);
    }    
    
    
    public function add_artist($playlist_id) {
        $this->verify_playlist_ownership($playlist_id);

        if ($this->input->post()) {
            // Récupérer l'ID de l'artiste à partir du formulaire
            $artist_id = $this->input->post('artist_id');
            $songs = $this->Model_music->get_songs_by_artist($artist_id);
            $all_songs_exist = true; // Variable pour vérifier si toutes les chansons existent déjà dans la playlist
    
            // Vérifier si toutes les chansons de l'artiste existent déjà dans la playlist
            foreach ($songs as $song) {
                if (!$this->Model_playlist->song_exists_in_playlist($playlist_id, $song->id)) {
                    $all_songs_exist = false;
                    break;
                }
            }
    
            if ($all_songs_exist) {
                $this->session->set_flashdata('error', 'Toutes les chansons de cet artiste existent déjà dans la playlist.');
            } else {
                foreach ($songs as $song) {
                    if (!$this->Model_playlist->song_exists_in_playlist($playlist_id, $song->id)) {
                        $data = array(
                            'playlist_id' => $playlist_id,
                            'song_id' => $song->id
                        );
                        $this->Model_playlist->add_song_to_playlist($data);
                    }
                }
    
                $this->session->set_flashdata('success', 'Les chansons de l\'artiste ont été ajoutées avec succès à la playlist.');
            }
    
            redirect('playlists/view/' . $playlist_id);
        } else {
            // Récupérer tous les artistes disponibles
            $data['artists'] = $this->Model_music->get_all_artists();
            $data['playlist_id'] = $playlist_id;

            $data['title']="Ajouter les musiques d'un Artiste à la Playlist";
            $data['css']="assets/css/playlist_add_song";

            $this->load->view('layout/header_dark', $data);
            $this->load->view('playlist_add_artist',$data);
            $this->load->view('layout/footer_dark');
        }
    }

    public function add_artist_in_playlist_from_list($artist_id,$playlist_id = NULL) {
        if($playlist_id === NULL){
            $playlist_id = $this->input->post('playlist_id');
        }
        $this->verify_playlist_ownership($playlist_id);
    
        if ($this->input->post() || $playlist_id) {
            // Récupérer l'ID de l'artiste à partir du formulaire
            $songs = $this->Model_music->get_songs_by_artist($artist_id);
            $all_songs_exist = true; // Variable pour vérifier si toutes les chansons existent déjà dans la playlist
    
            // Vérifier si toutes les chansons de l'artiste existent déjà dans la playlist
            foreach ($songs as $song) {
                if (!$this->Model_playlist->song_exists_in_playlist($playlist_id, $song->id)) {
                    $all_songs_exist = false;
                    break;
                }
            }
    
            if ($all_songs_exist) {
                $this->session->set_flashdata('error', 'Toutes les chansons de cet artiste existent déjà dans la playlist.');
            } else {
                foreach ($songs as $song) {
                    if (!$this->Model_playlist->song_exists_in_playlist($playlist_id, $song->id)) {
                        $data = array(
                            'playlist_id' => $playlist_id,
                            'song_id' => $song->id
                        );
                        $this->Model_playlist->add_song_to_playlist($data);
                    }
                }
    
                $this->session->set_flashdata('success', 'Les chansons de l\'artiste ont été ajoutées avec succès à la playlist.');
            }
    
            redirect('playlists/view/' . $playlist_id);
        } else {
            // Récupérer tous les artistes disponibles
            $data['artists'] = $this->Model_music->get_all_artists();
            $data['playlist_id'] = $playlist_id;
    
            $data['title']="Ajouter les musiques d'un Artiste à la Playlist";
            $data['css']="assets/css/playlist_add_song";
    
            $this->load->view('layout/header_dark', $data);
            $this->load->view('playlist_add_artist',$data);
            $this->load->view('layout/footer_dark');
        }
    }    
}
?>
