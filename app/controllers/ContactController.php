<?php
class ContactController {
    private $model;

    // Konstruktor si vyžádá PDO a vytvoří uvnitř controlleru novou instanci Modelu
    public function __construct($pdo) {
        require_once 'models/Contact.php';
        $this->model = new Contact($pdo);
    }

    // Hlavní metoda, která se zavolá, když uživatel navštíví stránku
    public function index() {
        // Vytáhneme data z databáze
        $contacts = $this->model->getContacts();
        // Převedeme data do JSON formátu pro JavaScript
        $json_contacts = json_encode($contacts);
        
        // Načteme vzhled
        require_once 'views/mindmap.php';
    }
}
?>