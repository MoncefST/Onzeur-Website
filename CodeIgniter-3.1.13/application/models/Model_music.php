<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_music extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getAlbums($limit, $offset, $order_by = 'year', $genre_id = null, $artist_id = null){
        $sql = "SELECT album.id, album.name, album.year, artist.name as artistName, genre.name as genreName, cover.jpeg
                FROM album
                JOIN artist ON album.artistid = artist.id
                JOIN genre ON album.genreid = genre.id
                JOIN cover ON album.coverid = cover.id";
        
        if ($genre_id) {
            $sql .= " WHERE genre.id = ?";
            $params[] = $genre_id;
        }
        
        if ($artist_id) {
            if ($genre_id) {
                $sql .= " AND artist.id = ?";
            } else {
                $sql .= " WHERE artist.id = ?";
            }
            $params[] = $artist_id;
        }

        $sql .= " ORDER BY album." . $order_by . " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function get_total_albums($genre_id = null, $artist_id = null){
        $sql = "SELECT COUNT(*) as total_albums FROM album
                JOIN genre ON album.genreid = genre.id
                JOIN artist ON album.artistid = artist.id";
        
        $params = array(); // Initialiser le tableau de paramètres
    
        if ($genre_id) {
            $sql .= " WHERE genre.id = ?";
            $params[] = $genre_id;
        }
        
        if ($artist_id) {
            if ($genre_id) {
                $sql .= " AND artist.id = ?";
            } else {
                $sql .= " WHERE artist.id = ?";
            }
            $params[] = $artist_id;
        }
    
        $query = $this->db->query($sql, $params);
        $result = $query->row();
        return $result->total_albums;
    }
    

    // Méthodes pour obtenir les genres et les artistes pour les filtres
    public function getGenres(){
        $query = $this->db->query("SELECT id, name FROM genre ORDER BY name");
        return $query->result();
    }

    public function getArtists(){
        $query = $this->db->query("SELECT id, name FROM artist ORDER BY name");
        return $query->result();
    }

    public function get_artist_name_by_id($artist_id) {
        return $this->db->get_where('artist', array('id' => $artist_id))->row('name');
    }    

    public function get_album_by_id($id){
        $query = $this->db->query(
            "SELECT album.id, album.name, album.year, album.artistId, album.genreId, artist.name as artistName, genre.name as genreName, cover.jpeg
             FROM album
             JOIN artist ON album.artistId = artist.id
             JOIN genre ON album.genreid = genre.id
             JOIN cover ON album.coverid = cover.id
             WHERE album.id = ?", array($id)
        );
        $album = $query->row();
    
        $tracks = []; // Initialiser le tableau des pistes
    
        if ($album) {
            $query = $this->db->query(
                "SELECT track.id, track.diskNumber, track.number, track.duration, song.id as song_id, song.name as songName
                 FROM track
                 JOIN song ON track.songid = song.id
                 WHERE track.albumid = ?
                 ORDER BY track.diskNumber, track.number", array($id)
            );
            $tracks = $query->result();
        }
    
        return [$album, $tracks];
    }     

    public function getMusiques($limit, $offset, $order_by = 'name', $order_direction = 'ASC', $genre_id = null, $artist_id = null) {
        // Préparer la colonne de tri en fonction du paramètre $order_by
        $order_column = '';
        switch ($order_by) {
            case 'artist':
                $order_column = 'artist.name';
                break;
            case 'album':
                $order_column = 'album.name';
                break;
            case 'year':
                $order_column = 'album.year';
                break;
            case 'name':
            default:
                $order_column = 'song.name';
                break;
        }
    
        // Préparer la clause WHERE pour le genre et l'artiste, si nécessaire
        $where_clause = '';
        $params = array();
        if ($genre_id) {
            $where_clause .= " WHERE genre.id = ?";
            $params[] = $genre_id;
        }
        if ($artist_id) {
            $where_clause .= ($where_clause == '') ? ' WHERE' : ' AND';
            $where_clause .= " artist.id = ?";
            $params[] = $artist_id;
        }
    
        // Exécuter la requête avec la clause WHERE et l'ordre de tri spécifié
        $query = $this->db->query("
            SELECT song.id, song.name, artist.id as artist_id, artist.name as artistName, album.name as album_name, track.albumid as album_id, cover.jpeg as cover
            FROM song
            JOIN track ON song.id = track.songid
            JOIN album ON track.albumid = album.id
            JOIN artist ON album.artistid = artist.id
            JOIN cover ON album.coverid = cover.id
            JOIN genre ON album.genreid = genre.id
            $where_clause
            ORDER BY $order_column $order_direction
            LIMIT $limit OFFSET $offset
        ", $params);
        
        return $query->result();
    }
    
    public function get_all_songs() {
        return $this->db->get('song')->result();
    }

    public function get_all_albums() {
        return $this->db->get('album')->result();
    }
    
    public function get_songs_by_album($album_id) {
        $this->db->select('song.*');
        $this->db->from('track');
        $this->db->join('song', 'track.songid = song.id');
        $this->db->where('track.albumid', $album_id);
        return $this->db->get()->result();
    }    

    public function get_total_musiques_filtered($genre_id = null, $artist_id = null) {
        $where_clause = '';
        $params = array();
        if ($genre_id) {
            $where_clause .= " WHERE genre.id = ?";
            $params[] = $genre_id;
        }
        if ($artist_id) {
            $where_clause .= ($where_clause == '') ? ' WHERE' : ' AND';
            $where_clause .= " artist.id = ?";
            $params[] = $artist_id;
        }
    
        $query = $this->db->query("
            SELECT COUNT(*) as total
            FROM song
            JOIN track ON song.id = track.songid
            JOIN album ON track.albumid = album.id
            JOIN artist ON album.artistid = artist.id
            JOIN genre ON album.genreid = genre.id
            $where_clause
        ", $params);
    
        return $query->row()->total;
    }    

    public function get_random_songs($limit, $genre = null, $artist = null) {
        $this->db->select('song.id, song.name');
        $this->db->from('song');
        $this->db->join('track', 'track.songId = song.id');
        $this->db->join('album', 'album.id = track.albumId');
        $this->db->join('artist', 'artist.id = album.artistId', 'left');
        $this->db->join('genre', 'genre.id = album.genreId', 'left');

        if ($genre) {
            $this->db->where('genre.name', $genre);
        }
        if ($artist) {
            $this->db->where('artist.name', $artist);
        }

        $this->db->order_by('RAND()');
        $this->db->limit($limit);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_genres() {
        $this->db->distinct();
        $this->db->select('name');
        $query = $this->db->get('genre');
        return array_column($query->result_array(), 'name');
    }

    public function get_all_artists() {
        $this->db->distinct();
        $this->db->select('name');
        $query = $this->db->get('artist');
        return array_column($query->result_array(), 'name');
    }
    
    public function get_total_musiques(){
        $query = $this->db->query("SELECT COUNT(*) as total_musiques FROM song");
        $result = $query->row();
        return $result->total_musiques;
    } 

    public function getAlbumsByArtiste($artiste_id){
        $query = $this->db->query("
            SELECT album.id, album.name, album.year, artist.name as artistName, genre.name as genreName, cover.jpeg,
                   track.id as track_id, track.diskNumber, track.number, track.duration, song.id as song_id, song.name as songName
            FROM album
            JOIN artist ON album.artistid = artist.id
            JOIN genre ON album.genreid = genre.id
            JOIN cover ON album.coverid = cover.id
            JOIN track ON track.albumid = album.id
            JOIN song ON track.songid = song.id
            WHERE artist.id = ?
            ORDER BY album.id, track.diskNumber, track.number
        ", array($artiste_id));
        $result = $query->result();
    
        // Organiser les résultats par album
        $albums = array();
        foreach ($result as $row) {
            $album_id = $row->id;
            if (!isset($albums[$album_id])) {
                $albums[$album_id] = (object)array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'year' => $row->year,
                    'artistName' => $row->artistName,
                    'genreName' => $row->genreName,
                    'jpeg' => $row->jpeg,
                    'tracks' => array() // Initialiser un tableau pour les pistes de l'album
                );
            }
            // Ajouter la piste à l'album correspondant
            $albums[$album_id]->tracks[] = (object)array(
                'id' => $row->track_id,
                'diskNumber' => $row->diskNumber,
                'number' => $row->number,
                'duration' => $row->duration,
                'song_id' => $row->song_id, // Ajouter l'ID de la chanson
                'songName' => $row->songName
            );
        }
    
        return array_values($albums); // Réorganiser les albums en utilisant des index numériques
    }     

    public function getMostUsedGenreByArtist($artist_id) {
        $query = $this->db->query("
            SELECT genre.name as genreName, COUNT(*) as genreCount
            FROM album
            JOIN genre ON album.genreid = genre.id
            WHERE album.artistid = ?
            GROUP BY genre.name
            ORDER BY genreCount DESC
            LIMIT 1
        ", array($artist_id));
    
        return $query->row();
    }

    public function get_songs_by_artist($artist_id) {
        $this->db->select('song.*');
        $this->db->from('track');
        $this->db->join('song', 'track.songid = song.id');
        $this->db->join('album', 'track.albumid = album.id');
        $this->db->where('album.artistid', $artist_id);
        return $this->db->get()->result();
    }            

    public function get_music_details($song_id) {
        // Requête pour récupérer les détails de la chanson
        $query = $this->db->query("
            SELECT song.id, song.name, artist.id as artist_id, artist.name as artistName, album.name as album_name, track.albumid as album_id, cover.jpeg as cover_base64, track.duration
            FROM song
            JOIN track ON song.id = track.songid
            JOIN album ON track.albumid = album.id
            JOIN artist ON album.artistid = artist.id
            JOIN cover ON album.coverid = cover.id
            WHERE song.id = ?", array($song_id)
        );
    
        return $query->row(); // Renvoie le résultat unique sous forme d'objet
    } 
    
    public function get_recommended_songs($genre_id, $artist_id, $limit = 3) {
        $where_clause = '';
        $params = array();
    
        if ($genre_id) {
            $where_clause .= " WHERE genre.id = ?";
            $params[] = $genre_id;
        } elseif ($artist_id) {
            $where_clause .= " WHERE artist.id = ?";
            $params[] = $artist_id;
        }
    
        // Requête pour récupérer des musiques recommandées en fonction du genre ou de l'artiste
        $query = $this->db->query("
                SELECT song.id, song.name, artist.id as artist_id, artist.name as artistName, album.id as album_id, album.name as album_name, cover.jpeg as cover_base64
                FROM song
                JOIN track ON song.id = track.songid
                JOIN album ON track.albumid = album.id
                JOIN artist ON album.artistid = artist.id
                JOIN cover ON album.coverid = cover.id
                JOIN genre ON album.genreid = genre.id
                $where_clause
                ORDER BY RAND()
                LIMIT $limit
            ", $params);

    
        return $query->result();
    }
    
    
    
}
