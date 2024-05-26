<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH . 'third_party/phpmailer/src/Exception.php';
require APPPATH . 'third_party/phpmailer/src/PHPMailer.php';
require APPPATH . 'third_party/phpmailer/src/SMTP.php';

class Utilisateur extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library(array('form_validation', 'session'));
        $this->load->model('Utilisateur_model');
        $this->load->helper('html');
    }
    

    public function inscription(){
        // Définir les règles de validation
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[utilisateur.email]');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');
        $this->form_validation->set_rules('password', 'Mot de passe', 'required|min_length[8]|max_length[64]', array(
            'min_length' => 'Le {field} doit contenir au moins {param} caractères.',
            'max_length' => 'Le {field} ne doit pas dépasser {param} caractères.'
        ));
    
        if ($this->form_validation->run() == FALSE) {
            // Charger la vue avec les erreurs
            $this->load->view('layout/header_dark');
            $this->load->view('inscription');
            $this->load->view('layout/footer_dark');
        } else {
            // Récupérer les données du formulaire
            $data = array(
                'email' => $this->input->post('email'),
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT) // Hasher le mot de passe
            );
    
            // Insérer les données dans la base de données
            if ($this->Utilisateur_model->insert_user($data)) {
                // Envoyer un email de confirmation
                $this->send_confirmation_email($data['email'], $data['prenom'], $data['nom']);
                
                $this->session->set_flashdata('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
                redirect('utilisateur/connexion');
            } else {
                $data['error'] = 'Une erreur est survenue. Veuillez réessayer.';
                $this->load->view('layout/header_dark');
                $this->load->view('inscription', $data);
                $this->load->view('layout/footer_dark');
            }
        }
    }
    
    private function send_confirmation_email($to_email, $prenom, $nom) {
        $mail = new PHPMailer(true);
        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'onzeur.contact@gmail.com';
            $mail->Password = 'ofoi hjpo isxf azdk'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            // Destinataires
            $mail->setFrom('onzeur.contact@gmail.com', 'Support Onzeur');
            $mail->addAddress($to_email);
    
            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Bienvenue sur Onzeur !';
            
            $mail_body = '
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 80%;
                        margin: 0 auto;
                        background-color: #fff;
                        padding: 20px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        text-align: center;
                        padding: 20px;
                    }
                    .header img {
                        max-width: 150px;
                    }
                    .content {
                        margin-top: 20px;
                    }
                    .content h1 {
                        color: #333;
                    }
                    .content p {
                        font-size: 16px;
                        line-height: 1.6;
                        color: #666;
                    }
                    .footer {
                        margin-top: 20px;
                        text-align: center;
                        font-size: 14px;
                        color: #999;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <img src="'.base_url('assets/img/Logo_ONZEUR_LIGHT.png').'" alt="Logo Onzeur">
                    </div>
                    <div class="content">
                        <h1>Bienvenue, '.$prenom.' '.$nom.' !</h1>
                        <p>Nous vous remercions de vous être inscrit sur Onzeur. Nous sommes ravis de vous compter parmi nos membres.</p>
                        <p>Onzeur est une plateforme dédiée à la création de playlist musical. Nous espérons que vous apprécierez votre expérience avec nous.</p>
                        <p>Voici quelques ressources pour vous aider à démarrer :</p>
                        <ul>
                            <li><a href="'.base_url('index.php/albums').'">Albums</a></li>
                            <li><a href="'.base_url('index.php/musiques').'">Musiques</a></li>
                            <li><a href="'.base_url('index.php/MentionsLegales').'">Mentions légales</a></li>
                            <li><a href="'.base_url('index.php/contact/index').'">Page de contact</a></li>
                        </ul>
                        <p>Si vous avez des questions ou avez besoin d\'aide, n\'hésitez pas à nous contacter.</p>
                        <p>Cordialement,<br>L\'équipe Onzeur</p>
                    </div>
                    <div class="footer">
                        &copy; '.date("Y").' Onzeur. Tous droits réservés.
                    </div>
                </div>
            </body>
            </html>';
            
            $mail->Body = $mail_body;
    
            $mail->send();
        } catch (Exception $e) {
            log_message('error', 'Erreur lors de l\'envoi de l\'email: ' . $mail->ErrorInfo);
        }
    }
    
    public function ajouter_avis() {
        if(!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        $this->form_validation->set_rules('commentaire', 'Commentaire', 'required');
        $this->form_validation->set_rules('notation', 'Notation', 'required'); 
    
        if ($this->form_validation->run() == FALSE) {
            redirect('/');
        } else {
            $data = array(
                'utilisateur_id' => $this->session->userdata('user_id'),
                'commentaire' => $this->input->post('commentaire'),
                'notation' => $this->input->post('notation') // Récupérer la valeur de notation depuis le champ caché
            );
    
            if ($this->Utilisateur_model->insert_avis($data)) {
                $this->session->set_flashdata('success', 'Avis ajouté avec succès.');
            } else {
                $this->session->set_flashdata('error', 'Une erreur est survenue. Veuillez réessayer.');
            }
    
            redirect('/');
        }
    }
    

    public function supprimer_avis($avis_id) {
        if ($this->Utilisateur_model->supprimer_avis($avis_id)) {
            $this->session->set_flashdata('success', 'Avis supprimé avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Une erreur est survenue lors de la suppression de l\'avis.');
        }
    
        redirect('/');
    }
    
    public function connexion(){
        // Définir les règles de validation
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Mot de passe', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // Charger la vue avec les erreurs
            $this->load->view('layout/header_dark');
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
                // Définir un cookie pour indiquer que l'utilisateur est connecté
                $cookie = array(
                    'name'   => 'user_logged_in',
                    'value'  => '1',
                    'expire' => '86500', // durée de vie du cookie (1 jour)
                    'secure' => TRUE
                );
                $this->input->set_cookie($cookie);
                redirect('utilisateur/dashboard');
            } else {
                $data['error'] = 'Email ou mot de passe incorrect.';
                $this->load->view('layout/header_dark');
                $this->load->view('connexion', $data);
                $this->load->view('layout/footer_dark');
            }
        }
    }

    public function deconnexion(){
        // Détruire la session de l'utilisateur
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        
        // Supprimer le cookie
        delete_cookie('user_logged_in');
        
        // Rediriger vers la page de connexion
        redirect('utilisateur/connexion');
    }    
    
    public function dashboard(){
        if(!$this->session->userdata('user_id')){
            redirect('utilisateur/connexion');
        }
    
        // Fetch les informations des utilisateurs
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->Utilisateur_model->get_user_by_id($user_id);
    
        // Charger les vues
        $this->load->view('layout/header_dark');
        $this->load->view('dashboard', $data);
        $this->load->view('layout/footer_dark');
    }
    
    public function modifier(){
        if(!$this->session->userdata('user_id')){
            redirect('utilisateur/connexion');
        }
    
        // Definition des règles
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->dashboard();
        } else {
            $user_id = $this->session->userdata('user_id');
            $data = array(
                'email' => $this->input->post('email'),
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom')
            );
    
            if ($this->Utilisateur_model->update_user($user_id, $data)) {
                $data['success'] = 'Informations mises à jour avec succès.';
            } else {
                $data['error'] = 'Une erreur est survenue. Veuillez réessayer.';
            }
    
            $data['user'] = $this->Utilisateur_model->get_user_by_id($user_id);
            $this->load->view('layout/header_dark');
            $this->load->view('dashboard', $data);
            $this->load->view('layout/footer_dark');
        }
    }
}
