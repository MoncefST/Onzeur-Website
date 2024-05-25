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

    public function add_song_to_playlist($data) {
        // Vérifier si la combinaison playlist_id et song_id existe déjà
        $this->db->where($data);
        $existing_entry = $this->db->get('playlist_song')->row();

        // Si la combinaison existe déjà, retourner false
        if ($existing_entry) {
            return false;
        }

        // Sinon, effectuer l'insertion
        return $this->db->insert('playlist_song', $data);
    }

    public function song_exists_in_playlist($playlist_id, $song_id) {
        $this->db->where('playlist_id', $playlist_id);
        $this->db->where('song_id', $song_id);
        $query = $this->db->get('playlist_song');
        return $query->num_rows() > 0;
    }

    public function artist_songs_exist_in_playlist($playlist_id, $artist_id) {
        // Récupérer les chansons de l'artiste spécifié
        $artist_songs = $this->Model_music->get_songs_by_artist($artist_id);
    
        // Récupérer les chansons de la playlist
        $playlist_songs = $this->get_songs_by_playlist($playlist_id);
    
        // Vérifier chaque chanson de l'artiste dans la playlist
        foreach ($artist_songs as $artist_song) {
            foreach ($playlist_songs as $playlist_song) {
                // Si la chanson de l'artiste est déjà dans la playlist, retourner true
                if ($artist_song->id == $playlist_song->id) {
                    return true;
                }
            }
        }
    
        // Si aucune chanson de l'artiste n'est trouvée dans la playlist, retourner false
        return false;
    }

    public function album_songs_exist_in_playlist($playlist_id, $album_id) {
        $album_songs = $this->Model_music->get_songs_by_album($album_id);
        
        foreach ($album_songs as $song) {
            $this->db->where('playlist_id', $playlist_id);
            $this->db->where('song_id', $song->id);
            $query = $this->db->get('playlist_song');
            if ($query->num_rows() > 0) {
                return true;
            }
        }
        return false;
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
