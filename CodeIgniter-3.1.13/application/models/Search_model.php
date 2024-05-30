<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function searchMusiques($query){
        $sql = "SELECT song.id, song.name, artist.id as artist_id, artist.name as artistName, album.name as album_name, track.albumid as album_id, cover.jpeg as cover
                FROM song
                JOIN track ON song.id = track.songid
                JOIN album ON track.albumid = album.id
                JOIN artist ON album.artistid = artist.id
                JOIN cover ON album.coverid = cover.id
                WHERE song.name LIKE ? 
                ORDER BY song.name ASC";
        $query = $this->db->query($sql, array('%' . $query . '%'));
        return $query->result();
    }

    public function searchAlbums($query){
        $sql = "SELECT album.id, album.name, album.year, artist.id as artist_id, artist.name as artistName, genre.name as genreName, cover.jpeg
                FROM album
                JOIN artist ON album.artistid = artist.id
                JOIN genre ON album.genreid = genre.id
                JOIN cover ON album.coverid = cover.id
                WHERE album.name LIKE ? 
                ORDER BY album.name ASC";
        $query = $this->db->query($sql, array('%' . $query . '%'));
        return $query->result();
    }
    

    public function searchGenres($query){
        $sql = "SELECT id, name FROM genre WHERE name LIKE ? ORDER BY name ASC";
        $query = $this->db->query($sql, array('%' . $query . '%'));
        return $query->result();
    }

    public function searchArtistes($query){
        $sql = "SELECT id, name FROM artist WHERE name LIKE ? ORDER BY name ASC";
        $query = $this->db->query($sql, array('%' . $query . '%'));
        return $query->result();
    }
}
?>
