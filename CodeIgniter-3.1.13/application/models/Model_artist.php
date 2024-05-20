<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_artist extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getArtisteById($artiste_id){
        $query = $this->db->query("SELECT * FROM artist WHERE id = ?", array($artiste_id));
        return $query->row();
    }

}
?>
