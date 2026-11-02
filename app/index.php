<?php
// Spustíme session - MUSÍME ho spouštět hned na začátku
session_start();

// Načítání konfigurace databáze
require_once 'src/.config/database.php';

// Načítání controllerů
require_once 'controllers/AuthController.php';
require_once 'controllers/ContactController.php';

$authController = new AuthController($pdo);
$contactController = new ContactController($pdo);

// Zjistíme požadovanou akci z URL (např. index.php?action=login)
// ?? znamená "pokud není nastaveno, použij prázdný řetězec"
$action = $_GET['action'] ?? '';

// Směrování (aka Routing)
switch ($action) {
    // --- API AKCE (Vracíme JSON pro React) ---
    case 'check_auth':
        $authController->checkAuth();
        break;

    case 'login':
        $authController->login();
        break;

    case 'register':
        $authController->register();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'get_contacts':
        $contactController->get_contacts();
        break;

    // --- HLAVNÍ VSTUPNÍ STRÁNKA (Vrací HTML obal s Reactem) ---
    default:
        require_once 'views/app.php';
        break;
}
?>