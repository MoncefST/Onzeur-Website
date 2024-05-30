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

    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('utilisateur'); // Assurez-vous que 'utilisateurs' est le nom de votre table d'utilisateurs
        return $query->row(); // Retourne le premier résultat
    }

    public function get_user_by_id($id) {
        $query = $this->db->get_where('utilisateur', array('id' => $id));
        return $query->row();
    }

    public function update_user($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('utilisateur', $data);
    }
    
    
    public function insert_avis($data) {
        return $this->db->insert('avis', $data);
    }

    public function get_recent_avis($limit = 3) {
        $this->db->select('avis.*, utilisateur.nom, utilisateur.prenom');
        $this->db->from('avis');
        $this->db->join('utilisateur', 'avis.utilisateur_id = utilisateur.id');
        $this->db->order_by('date_creation', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_avis_by_user($user_id) {
        $this->db->where('utilisateur_id', $user_id);
        $query = $this->db->get('avis');
        return $query->result();
    }

    public function get_avis($utilisateur_id) {
        $this->db->select('*');
        $this->db->from('avis');
        $this->db->where('utilisateur_id', $utilisateur_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function supprimer_avis($avis_id) {
        return $this->db->delete('avis', array('id' => $avis_id));
    } 
    
}
?>
