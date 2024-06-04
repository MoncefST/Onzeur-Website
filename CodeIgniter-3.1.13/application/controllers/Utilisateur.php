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

            $data['title']="Inscription";
            $data['css']="assets/css/inscription";

            // Charger la vue avec les erreurs
            $this->load->view('layout/header_dark',$data);
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

                $data['title']="Inscription";
                $data['css']="assets/css/inscription";

                $this->load->view('layout/header_dark',$data);
                $this->load->view('inscription',$data);
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
                // Envoyer un email en fonction de la note
                $notation = intval($this->input->post('notation'));
                if ($notation >= 1 && $notation <= 3) {
                    // Envoyer un email d'excuse
                    $user = $this->Utilisateur_model->get_user_by_id($this->session->userdata('user_id'));
                    $this->send_excuse_email($user->email, $user->prenom, $user->nom);
                } elseif ($notation >= 4 && $notation <= 5) {
                    // Envoyer un email de remerciement
                    $user = $this->Utilisateur_model->get_user_by_id($this->session->userdata('user_id'));
                    $this->send_thank_you_email($user->email, $user->prenom, $user->nom);
                }
    
                $this->session->set_flashdata('success', 'Avis ajouté avec succès.');
            } else {
                $this->session->set_flashdata('error', 'Une erreur est survenue. Veuillez réessayer.');
            }
    
            redirect('/');
        }
    }
    
    
    private function send_excuse_email($to_email, $prenom, $nom) {
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
            $mail->Subject = 'Retours sur votre mauvaise experience sur Onzeur.';
    
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
                        <h1>Désolé, '.$prenom.' '.$nom.' !</h1>
                        <p>Nous sommes désolés de constater que votre expérience sur Onzeur n\'a pas été à la hauteur de vos attentes.</p>
                        <p>Nous prenons en compte vos retours et nous nous efforçons constamment d\'améliorer notre plateforme pour mieux vous servir.</p>
                        <p>Nous espérons avoir l\'occasion de vous satisfaire pleinement à l\'avenir.</p>
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
    
    
    private function send_thank_you_email($to_email, $prenom, $nom) {
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
            $mail->Subject = 'Merci de votre avis sur Onzeur !';
    
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
                        <h1>Merci, '.$prenom.' '.$nom.' !</h1>
                        <p>Nous vous remercions d\'avoir pris le temps de laisser votre avis sur Onzeur. Votre contribution est très précieuse pour nous.</p>
                        <p>Nous prenons en compte vos retours et nous nous efforçons constamment d\'améliorer notre plateforme pour mieux vous servir.</p>
                        <p>N\'hésitez pas à continuer à partager vos impressions avec nous.</p>
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
    

    public function connexion(){
        // Définir les règles de validation
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Mot de passe', 'required');
    
        if ($this->form_validation->run() == FALSE) {

            $data['title']="Connexion";
            $data['css']="assets/css/inscription";

            // Charger la vue avec les erreurs
            $this->load->view('layout/header_dark', $data);
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
                
                $data['title']="Connexion";
                $data['css']="assets/css/inscription";
                
                $this->load->view('layout/header_dark',$data);
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
    
    public function dashboard() {
        if(!$this->session->userdata('user_id')){
            redirect('utilisateur/connexion');
        }
    
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->Utilisateur_model->get_user_by_id($user_id);
        $data['avis'] = $this->Utilisateur_model->get_avis_by_user($user_id);
        $data['title']="Dashboard - Onzeur";
        $data['css']="assets/css/dashboard";
    
        $this->load->view('layout/header_dark', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('layout/footer_dark');
    }
    
    public function modifier() {
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->dashboard();
        } else {
            $user_id = $this->session->userdata('user_id');
            $new_email = $this->input->post('email');
    
            // Vérifie si l'email est déjà utilisé par un autre utilisateur
            $existing_user = $this->Utilisateur_model->get_user_by_email($new_email);
            if ($existing_user && $existing_user->id != $user_id) {
                $data['error'] = 'Cet email est déjà utilisé par un autre utilisateur.';
                $data['user'] = $this->Utilisateur_model->get_user_by_id($user_id);
                $data['avis'] = $this->Utilisateur_model->get_avis_by_user($user_id);
                $data['title'] = "Dashboard - Onzeur";
                $data['css'] = "assets/css/dashboard";
    
                $this->load->view('layout/header_dark', $data);
                $this->load->view('dashboard', $data);
                $this->load->view('layout/footer_dark');
                return; // Sortie de la méthode
            }
    
            $data = array(
                'email' => $new_email,
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom')
            );
    
            if ($this->Utilisateur_model->update_user($user_id, $data)) {
                $data['success'] = 'Informations mises à jour avec succès.';
                $this->send_confirmation_email_modification($data['email'], $data['prenom'], $data['nom']);
            } else {
                $data['error'] = 'Une erreur est survenue. Veuillez réessayer.';
            }
    
            // Récupérer à nouveau les données d'avis pour cet utilisateur
            $data['user'] = $this->Utilisateur_model->get_user_by_id($user_id);
            $data['avis'] = $this->Utilisateur_model->get_avis_by_user($user_id);
    
            $data['title'] = "Dashboard - Onzeur";
            $data['css'] = "assets/css/dashboard";
    
            $this->load->view('layout/header_dark', $data);
            $this->load->view('dashboard', $data);
            $this->load->view('layout/footer_dark');
        }
    }
             
    
    public function modifier_mot_de_passe() {
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        $this->form_validation->set_rules('ancien_password', 'Ancien mot de passe', 'required');
        $this->form_validation->set_rules('nouveau_password', 'Nouveau mot de passe', 'required|min_length[8]');
        $this->form_validation->set_rules('confirmer_password', 'Confirmer le nouveau mot de passe', 'required|matches[nouveau_password]');
    
        if ($this->form_validation->run() == FALSE) {
            $this->dashboard();
        } else {
            $user_id = $this->session->userdata('user_id');
            $user = $this->Utilisateur_model->get_user_by_id($user_id);
    
            if (password_verify($this->input->post('ancien_password'), $user->password)) {
                $data = array(
                    'password' => password_hash($this->input->post('nouveau_password'), PASSWORD_DEFAULT)
                );
    
                if ($this->Utilisateur_model->update_user($user_id, $data)) {
                    $data['success'] = 'Mot de passe mis à jour avec succès.';
                } else {
                    $data['error'] = 'Une erreur est survenue. Veuillez réessayer.';
                }
            } else {
                $data['error'] = 'L\'ancien mot de passe est incorrect.';
            }
    
            $data['user'] = $this->Utilisateur_model->get_user_by_id($user_id);

            $data['title']="Dashboard - Onzeur";
            $data['css']="assets/css/dashboard";

            $this->load->view('layout/header_dark', $data);
            $this->load->view('dashboard', $data);
            $this->load->view('layout/footer_dark');
        }
    }

    // Suppression d'avis
    public function supprimer_avis_dashboard($id) {
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        $this->load->model('Utilisateur_model');
        $this->Utilisateur_model->supprimer_avis($id);
    
        redirect('utilisateur/dashboard');
    }

    public function supprimer_avis_accueil($id) {
        if (!$this->session->userdata('user_id')) {
            redirect('utilisateur/connexion');
        }
    
        $this->load->model('Utilisateur_model');
        $this->Utilisateur_model->supprimer_avis($id);
    
        redirect('/');
    }

    public function non_autorisee(){

        $data['title']="Accès non autorisé - Onzeur";
        $data['css']="assets/css/style.css";

        $this->load->view('layout/header_dark', $data);
        $this->load->view('non_autorisee');
        $this->load->view('layout/footer_dark');
    }

    public function send_confirmation_email_modification($to_email, $prenom, $nom) {
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
    
            // Contenu de l'e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Modification de vos informations sur Onzeur';
    
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
                        <h1>Modification de vos informations</h1>
                        <p>Vos informations personnelles ont été modifiées avec succès sur Onzeur.</p>
                        <p>Voici les informations mises à jour :</p>
                        <ul>
                            <li><strong>Prénom :</strong> '.$prenom.'</li>
                            <li><strong>Nom :</strong> '.$nom.'</li>
                        </ul>
                        <p>Si vous n\'êtes pas à l\'origine de cette modification, veuillez nous contacter immédiatement.</p>
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
            log_message('error', 'Erreur lors de l\'envoi de l\'e-mail: ' . $mail->ErrorInfo);
        }
    }
}
