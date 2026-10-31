<?php
class Contact {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getContacts() {
        // Získáme kontakty i s HEX barvou jejich primární skupiny
        $stmt = $this->pdo->query("
            SELECT c.id, c.first_name, c.last_name, g.color 
            FROM contacts c 
            LEFT JOIN groups g ON c.group_id = g.id
        ");
        return $stmt->fetchAll(); // Metoda fetchAll() sesbírá všechny nalezené řádky a vrátí je jako jedno velké pole
    }
}
?>