<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cover_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_covers() {
        $query = "SELECT id, jpeg FROM cover LIMIT 4";
        $result = $this->db->query($query);
        return $result->result_array();
    }    
}
