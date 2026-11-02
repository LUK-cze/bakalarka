<?php
// TODO: pořádný komentáře po předělání na REACT
class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Pomocná metoda pro odeslání JSON odpovědi
    private function sendJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Zjistí pro React, zda je uživatel stále přihlášen v SESSION
    public function checkAuth() {
        $isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
        $this->sendJson([
            'logged_in' => $isLoggedIn,
            'username' => $isLoggedIn ? $_SESSION['username'] : null
        ]);
    }

    // Metoda pro přihlášení uživatele
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJson(['success' => false, 'message' => 'Neplatný požadavek.']);
        }

        // Načtení dat z JSON těla požadavku, pokud je odesláno jako JSON
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $_POST['username'] ?? $input['username'] ?? '';
        $password = $_POST['password'] ?? $input['password'] ?? '';

        // Kontrola, zda jsou vyplněna všechna pole
        if (empty($username) || empty($password)) {
            $this->sendJson(['success' => false, 'message' => 'Vyplňte jméno i heslo.']);
        }

        // Kontrola uživatele v databázi
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Ověření hesla
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            $this->sendJson([
                'success' => true,
                'username' => $user['username']
            ]);
        } else {
            $this->sendJson([
                'success' => false,
                'message' => 'Nesprávné jméno nebo heslo.'
            ]);
        }
    }

    // Metoda pro odhlášení uživatele
    public function logout() {
        session_destroy();
        $this->sendJson(['success' => true]);
    }

    // Metoda pro registraci uživatele
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJson(['success' => false, 'message' => 'Neplatný požadavek.']);
        }

        // Načtení dat z JSON těla požadavku, pokud je odesláno jako JSON
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $_POST['username'] ?? $input['username'] ?? '';
        $password = $_POST['password'] ?? $input['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? $input['password_confirm'] ?? '';

        // Kontrola, zda jsou vyplněna všechna pole
        if (empty($username) || empty($password)) {
            $this->sendJson(['success' => false, 'message' => 'Vyplňte všechna pole.']);
        }

        // Kontrola shody hesel
        if ($password !== $password_confirm) {
            $this->sendJson(['success' => false, 'message' => 'Hesla se neshodují.']);
        }

        // Kontrola, zda uživatelské jméno již existuje
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $this->sendJson(['success' => false, 'message' => 'Toto uživatelské jméno je již zabrané.']);
        }

        // Vložení nového uživatele do databáze
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $this->pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        
        // Odeslání JSON odpovědi podle výsledku vložení
        if ($insert->execute([$username, $hash])) {
            $this->sendJson(['success' => true, 'message' => 'Účet vytvořen. Nyní se můžete přihlásit.']);
        } else {
            $this->sendJson(['success' => false, 'message' => 'Nastala chyba při ukládání do databáze.']);
        }
    }
}
?>