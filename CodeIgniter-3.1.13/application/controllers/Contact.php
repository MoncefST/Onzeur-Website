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
        // Chargez le modèle si nécessaire
    }

    public function index() {
        $this->load->view('layout/header_dark');
        $this->load->view('nous-contacter'); 
        $this->load->view('layout/footer_dark');
    }

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
                $mail->Body    = $message;

                $mail->send();
                $this->load->view('layout/header_dark');
                $this->load->view('confirmation_mail.php');
                $this->load->view('layout/footer_dark');
            } catch (Exception $e) {
                $this->load->view('layout/header_dark');
                $this->load->view('erreur_mail.php');
                $this->load->view('layout/footer_dark');
            }
        } else {
            redirect('contact');
        }
    }

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
                $mail->Body = $message;
    
                // Gérer la pièce jointe
                if (!empty($attachment['tmp_name'])) {
                    $mail->addAttachment($attachment['tmp_name'], $attachment['name']);
                }
    
                $mail->send();
                $this->load->view('layout/header_dark');
                $this->load->view('confirmation_mail.php');
                $this->load->view('layout/footer_dark');
            } catch (Exception $e) {
                $this->load->view('layout/header_dark');
                $this->load->view('erreur_mail.php');
                $this->load->view('layout/footer_dark');
            }
        } else {
            redirect('nous-contacter');
        }
    }    
}

