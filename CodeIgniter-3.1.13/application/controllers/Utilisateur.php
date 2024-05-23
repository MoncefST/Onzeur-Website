<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
        $this->load->model('Utilisateur_model');
        $this->load->helper('html');
    }

    public function inscription(){
        // Définir les règles de validation
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[utilisateur.email]');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');
        $this->form_validation->set_rules('telephone', 'Téléphone', 'max_length[20]');
        $this->form_validation->set_rules('password', 'Mot de passe', 'required|min_length[6]');
    
        if ($this->form_validation->run() == FALSE) {
            // Charger la vue avec les erreurs
            $this->load->view('layout/header_dark');
            $this->load->view('layout/header_not_logged_dark');
            $this->load->view('inscription');
            $this->load->view('layout/footer_dark');
        } else {
            // Récupérer les données du formulaire
            $data = array(
                'email' => $this->input->post('email'),
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'telephone' => $this->input->post('telephone'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT) // Hasher le mot de passe
            );
    
            // Insérer les données dans la base de données
            if ($this->Utilisateur_model->insert_user($data)) {
                $this->session->set_flashdata('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
                redirect('utilisateur/connexion');
            } else {
                $data['error'] = 'Une erreur est survenue. Veuillez réessayer.';
                $this->load->view('layout/header_dark');
                $this->load->view('layout/header_not_logged_dark');
                $this->load->view('inscription', $data);
                $this->load->view('layout/footer_dark');
            }
        }
    }
    
    public function connexion(){
        // Définir les règles de validation
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Mot de passe', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // Charger la vue avec les erreurs
            $this->load->view('layout/header_dark');
            $this->load->view('layout/header_not_logged_dark');
            $this->load->view('connexion');
            $this->load->view('layout/footer_dark');
        } else {
            // Récupérer les données du formulaire
            $email = $this->input->post('email');
            $password = $this->input->post('password');
    
            // Vérifier les informations d'identification dans la base de données
            $user = $this->Utilisateur_model->get_user($email);
    
            if ($user && password_verify($password, $user->password)) {
                // Connexion réussie, enregistrer l'utilisateur dans la session
                $this->session->set_userdata('user_id', $user->id);
                redirect('dashboard');
            } else {
                $data['error'] = 'Email ou mot de passe incorrect.';
                $this->load->view('layout/header_dark');
                $this->load->view('layout/header_not_logged_dark');
                $this->load->view('connexion', $data);
                $this->load->view('layout/footer_dark');
            }
        }
    }    
}
