<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');                                             

class Model_music extends CI_Model {
	public function __construct(){
		$this->load->database();
	}

	public function getAlbums($limit, $offset){
		$query = $this->db->query(
            "SELECT album.name, album.id, year, artist.name as artistName, genre.name as genreName, jpeg 
            FROM album 
            JOIN artist ON album.artistid = artist.id
            JOIN genre ON genre.id = album.genreid
            JOIN cover ON cover.id = album.coverid
            ORDER BY year
            LIMIT $limit OFFSET $offset"
        );
	return $query->result();
	}

    public function get_total_albums(){
        $query = $this->db->query("SELECT COUNT(*) as total_albums FROM album");
        $result = $query->row();
        return $result->total_albums;
    }
    
}
