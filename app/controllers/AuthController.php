<?php
// TODO: komentář k AuthControlleru
class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login() {
        $error = '';
        
        // Pokud uživatel odeslal formulář
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // Zkontrolujeme, zda uživatel existuje a zda sedí hash hesla
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                header('Location: index.php'); // Přesměrování na hlavní stranu
                exit;
            } else {
                $error = 'Nesprávné jméno nebo heslo.';
            }
        }
        
        // Pokud se přihlášení nepovedlo, nebo jde uživatel na stránku poprvé, ukážeme formulář
        require_once 'views/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    // TODO: Přidat komentář k metodě register
    public function register() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            if (empty($username) || empty($password)) {
                $error = 'Vyplňte všechna pole.';
            } elseif ($password !== $password_confirm) {
                $error = 'Hesla se neshodují.';
            } else {
                // Kontrola, zda uživatel už neexistuje
                $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $error = 'Toto uživatelské jméno je již zabrané.';
                } else {
                    // Vytvoření účtu v databázi
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $insert = $this->pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
                    if ($insert->execute([$username, $hash])) {
                        $success = 'Účet vytvořen. Nyní se můžete přihlásit.';
                    } else {
                        $error = 'Nastala chyba při ukládání do databáze.';
                    }
                }
            }
        }
        
        require_once 'views/register.php';
    }
}
?>