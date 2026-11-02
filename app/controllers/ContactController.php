<?php
class ContactController {
    private $model;

    public function __construct($pdo) {
        require_once 'models/Contact.php';
        $this->model = new Contact($pdo);
    }

    public function get_contacts() {
        // Řekneme prohlížeči, že vracíme čistý JSON
        header('Content-Type: application/json');

        // Bezpečnostní kontrola – pokud není uživatel přihlášen, data nepustíme
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            echo json_encode(['error' => 'Neautorizovaný přístup']);
            exit;
        }

        // Vytáhneme data z databáze
        $contacts = $this->model->getContacts();
        
        // Pošleme data v JSON formátu přímo do Reactu a ukončíme skript
        echo json_encode($contacts);
        exit;
    }
}
?>