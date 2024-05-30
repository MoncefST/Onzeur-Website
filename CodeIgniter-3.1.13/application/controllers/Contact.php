<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH . 'third_party/phpmailer/src/Exception.php';
require APPPATH . 'third_party/phpmailer/src/PHPMailer.php';
require APPPATH . 'third_party/phpmailer/src/SMTP.php';


class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Chargez le modèle si nécessaire (pour le moment pas encore besoin)
    }

    public function index() {
        
        $data['title']='Nous contacter - Onzeur';
        $data['css']='assets/css/nous-contacter';
        
        $this->load->view('layout/header_dark', $data);
        $this->load->view('nous-contacter'); 
        $this->load->view('layout/footer_dark');
    }

    // Permet d'envoyer un mail au Support de Onzeur quand le client écrit un mail depuis l'accueil
    public function send_message() {
        if ($this->input->post()) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');
            
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'onzeur.contact@gmail.com';
                $mail->Password = 'ofoi hjpo isxf azdk';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom($email, $name);
                $mail->addAddress('onzeur.contact@gmail.com');

                $mail->isHTML(true);
                $mail->Subject = 'Formulaire de contact Onzeur - ' . $name;
                $mail->Body = '
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
                                <img src="' . base_url('assets/img/Logo_ONZEUR_LIGHT.png') . '" alt="Logo Onzeur">
                            </div>
                            <div class="content">
                                <h1>Nouveau message de contact</h1>
                                <p><strong>Nom:</strong> ' . $name . '</p>
                                <p><strong>Email:</strong> ' . $email . '</p>
                                <p><strong>Message:</strong></p>
                                <p>' . nl2br($message) . '</p>
                            </div>
                            <div class="footer">
                                &copy; ' . date("Y") . ' Onzeur. Tous droits réservés.
                            </div>
                        </div>
                    </body>
                    </html>';
                
                $mail->send();
                
                $data['title']="Confirmation d'envoi - Onzeur";
                $data['css']="assets/css/confirmation_mail";

                $this->load->view('layout/header_dark',$data);
                $this->load->view('confirmation_mail.php');
                $this->load->view('layout/footer_dark');
            } catch (Exception $e) {

                $data['title']="Erreur d'envoi - Onzeur";
                $data['css']="assets/css/erreur_mail";

                $this->load->view('layout/header_dark', $data);
                $this->load->view('erreur_mail.php');
                $this->load->view('layout/footer_dark');
            }
        } else {
            redirect('contact');
        }
    }

    // Permet d'envoyer un mail au Support de Onzeur quand le client écrit un mail depuis la page de contacte (donc avec plus d'infos)
    public function send_detailed_message() {
        if ($this->input->post()) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');
            $attachment = $_FILES['attachment'];
    
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'onzeur.contact@gmail.com';
                $mail->Password = 'ofoi hjpo isxf azdk';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
    
                $mail->setFrom($email, $name);
                $mail->addAddress('onzeur.contact@gmail.com');
    
                $mail->isHTML(true);
                $mail->Subject = 'Formulaire de contact Onzeur - ' . $name;
                $mail->Body = '
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
                                <img src="' . base_url('assets/img/Logo_ONZEUR_LIGHT.png') . '" alt="Logo Onzeur">
                            </div>
                            <div class="content">
                                <h1>Nouveau message de contact</h1>
                                <p><strong>Nom:</strong> ' . $name . '</p>
                                <p><strong>Email:</strong> ' . $email . '</p>
                                <p><strong>Message:</strong></p>
                                <p>' . nl2br($message) . '</p>
                            </div>
                            <div class="footer">
                                &copy; ' . date("Y") . ' Onzeur. Tous droits réservés.
                            </div>
                        </div>
                    </body>
                    </html>';
    
                // Gérer la pièce jointe
                if (!empty($attachment['tmp_name'])) {
                    $mail->addAttachment($attachment['tmp_name'], $attachment['name']);
                }
    
                $mail->send();
                
                $data['title']="Confirmation d'envoi - Onzeur";
                $data['css']="assets/css/confirmation_mail";

                $this->load->view('layout/header_dark',$data);
                $this->load->view('confirmation_mail.php');
                $this->load->view('layout/footer_dark');
            } catch (Exception $e) {
               
                $data['title']="Erreur d'envoi - Onzeur";
                $data['css']="assets/css/erreur_mail";

                $this->load->view('layout/header_dark', $data);
                $this->load->view('erreur_mail.php');
                $this->load->view('layout/footer_dark');
            }
        } else {
            redirect('nous-contacter');
        }
    }    
}

