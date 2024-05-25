<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_playlist extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create_playlist($data) {
        // Récupérer l'ID de l'utilisateur à partir de la session
        $user_id = $this->session->userdata('user_id');
        if ($user_id !== null) {
            $data['utilisateur_id'] = $user_id;
            return $this->db->insert('playlist', $data);
        } else {
            return false;
        }
    }


    // Récupérer une playlist par ID
    public function get_playlist_by_id($playlist_id) {
        return $this->db->get_where('playlist', array('id' => $playlist_id))->row();
    }

    // Récupérer toutes les playlists d'un utilisateur spécifique
    public function get_user_playlists($user_id) {
        $this->db->where('utilisateur_id', $user_id);
        return $this->db->get('playlist')->result();
    }


    // Mettre à jour une playlist
    public function update_playlist($playlist_id, $data) {
        $this->db->where('id', $playlist_id);
        return $this->db->update('playlist', $data);
    }

    // Supprimer une playlist
    public function delete_playlist($playlist_id) {
        $this->db->where('id', $playlist_id);
        return $this->db->delete('playlist');
    }

    // Ajouter une chanson à une playlist
    public function add_song_to_playlist($data) {
        return $this->db->insert('playlist_song', $data);
    }

    // Supprimer une chanson d'une playlist
    public function remove_song_from_playlist($playlist_id, $song_id) {
        $this->db->where('playlist_id', $playlist_id);
        $this->db->where('song_id', $song_id);
        return $this->db->delete('playlist_song');
    }

    // Récupérer les chansons d'une playlist
    public function get_songs_by_playlist($playlist_id) {
        $this->db->select('song.*');
        $this->db->from('playlist_song');
        $this->db->join('song', 'song.id = playlist_song.song_id');
        $this->db->where('playlist_song.playlist_id', $playlist_id);
        return $this->db->get()->result();
    }

    public function add_album_to_playlist($data) {
        return $this->db->insert('playlist_album', $data);
    }
}
?>
