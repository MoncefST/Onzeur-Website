<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function insert_user($data){
        return $this->db->insert('utilisateur', $data);
    }

    public function get_user($email) {
        $query = $this->db->get_where('utilisateur', array('email' => $email));
        return $query->row();
    }
    
}
