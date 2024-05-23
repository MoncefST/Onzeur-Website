<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
        $this->load->model('Utilisateur_model');
    }

    public function inscription(){
        // Définir les règles de validation
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[utilisateur.email]');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');
        $this->form_validation->set_rules('telephone', 'Téléphone', 'max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            // Charger la vue avec les erreurs
            $this->load->view('layout/header_not_logged_dark');
            $this->load->view('inscription');
            $this->load->view('layout/footer_dark');
        } else {
            // Récupérer les données du formulaire
            $data = array(
                'email' => $this->input->post('email'),
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'telephone' => $this->input->post('telephone')
            );

            // Insérer les données dans la base de données
            if ($this->Utilisateur_model->insert_user($data)) {
                $this->session->set_flashdata('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
                redirect('utilisateur/inscription');
            } else {
                $data['error'] = 'Une erreur est survenue. Veuillez réessayer.';
                $this->load->view('layout/header_not_logged_dark');
                $this->load->view('inscription', $data);
                $this->load->view('layout/footer_dark');
            }
        }
    }
}
