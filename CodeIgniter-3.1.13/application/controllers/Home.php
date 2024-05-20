<?php
class Home extends CI_Controller {

public function index() {
    // Charger le modèle
    $this->load->model('Cover_model');

    $this->load->helper('url');

    // Appeler la fonction pour récupérer les couvertures d'albums
    $data['covers'] = $this->Cover_model->get_covers();

    // Charger la vue avec les données récupérées
    $this->load->view('layout/header_not_logged_dark');
    $this->load->view('accueil', $data);
    $this->load->view('layout/footer_dark');
}
}
?>