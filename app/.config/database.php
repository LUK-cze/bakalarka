<?php
$host = '127.0.0.1';
$db   = 'bakalarka'; 
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// DATA SOURCE NAME 
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Při chybě v SQL dotazu skript okamžitě vyhodí výjimku (zastaví se a ukáže chybu)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Výsledky vrací jako asociativní pole (přístup přes názvy sloupců: $row['first_name'])
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // Objekt $pdo, který slouží ke komunikaci s databází ve zbytku aplikace
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode()); // Pokud připojení selže, zachytí chybovou hlášku a vypíše ji
}
?>