<?php
class Home extends CI_Controller {

public function index() {
    // Charger le modèle
    $this->load->model('Cover_model');

    // Appeler la fonction pour récupérer les couvertures d'albums
    $data['covers'] = $this->Cover_model->get_covers();

    // Charger la vue avec les données récupérées
    $this->load->view('accueil', $data);
}

}
?>