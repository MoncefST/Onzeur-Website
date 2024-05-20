<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_music extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getAlbums($limit, $offset){
        $query = $this->db->query(
            "SELECT album.id, album.name, album.year, artist.name as artistName, genre.name as genreName, cover.jpeg
             FROM album
             JOIN artist ON album.artistid = artist.id
             JOIN genre ON album.genreid = genre.id
             JOIN cover ON album.coverid = cover.id
             ORDER BY album.year
             LIMIT $limit OFFSET $offset"
        );
        return $query->result();
    }

    public function get_total_albums(){
        $query = $this->db->query("SELECT COUNT(*) as total_albums FROM album");
        $result = $query->row();
        return $result->total_albums;
    }
    
    public function get_album_by_id($id){
        // Fetch album details
        $query = $this->db->query(
            "SELECT album.id, album.name, album.year, artist.name as artistName, genre.name as genreName, cover.jpeg
             FROM album
             JOIN artist ON album.artistid = artist.id
             JOIN genre ON album.genreid = genre.id
             JOIN cover ON album.coverid = cover.id
             WHERE album.id = ?", array($id)
        );
        $album = $query->row();

        if ($album) {
            // Fetch album tracks
            $query = $this->db->query(
                "SELECT track.id, track.diskNumber, track.number, track.duration, song.name as songName
                 FROM track
                 JOIN song ON track.songid = song.id
                 WHERE track.albumid = ?
                 ORDER BY track.diskNumber, track.number", array($id)
            );
            $album->tracks = $query->result();
        }

        return $album;
    }
}
?>
