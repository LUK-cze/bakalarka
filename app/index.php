<?php
// Session se musí spustit úplně nahoře, slouží k zapamatování přihlášeného uživatele
session_start();

// Načtení konfigurace
require_once '.config/database.php';

// Zjistíme, jakou akci uživatel požaduje z URL (např. ?action=logout) a výchozí je 'index'.
$action = $_GET['action'] ?? 'index';

// Seznam akcí, kam může jít uživatel bez přihlášení
$public_actions = ['login', 'register'];

// Pokud uživatel NENÍ přihlášen, vnutíme mu vždy AuthController (přihlašovací formulář)
// isset je jestli vůbec proměnná existuje, !== true je jestli je hodnota true (např. pro kontrolu odhlášení)
// !in_array($action, $public_actions) zkontroluje, jestli požadovaná akce je v seznamu veřejných akcí (login, register). Pokud není, přesměrujeme ho na login. 
    // Kdybychom to neudělali stránka by ho nepustila na stránku s registrací a porad by byl seklí na login, protože kód si přečte ten isset a hned by ho hodil na login. Takže je potřeba zkontrolovat, jestli je požadovaná akce v seznamu veřejných akcí, aby se mohl dostat na registraci.
if ((!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) && !in_array($action, $public_actions)) { 
    $action = 'login';
}



require_once 'controllers/AuthController.php';
$authController = new AuthController($pdo);

// Směrování
if ($action === 'login') {
    $authController->login();
    exit;
} elseif ($action === 'register') {
    $authController->register();
    exit;
} elseif ($action === 'logout') {
    $authController->logout();
} else {
    require_once 'controllers/ContactController.php';
    $controller = new ContactController($pdo);
    $controller->index();
}
?>