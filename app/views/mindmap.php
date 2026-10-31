<?php 
// Tento řádek slouží pro uklidnění IDE, aby vědělo, že proměnná $json_contacts existuje a je typu string. Ve skutečnosti je tato proměnná definována v ContactControlleru a předává se do tohoto view.
/** @var string $json_contacts */ ?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Moje CRM Mindmapa</title>
</head>
<body>
    <h1>Osobní CRM</h1>
    TODO:
    <div id="mindmap-container">Zde bude mapa...</div>

    <script>
        // Data předaná z PHP Controlleru
        const nodesData = <?php echo $json_contacts; ?>;
        
        // DEBUG: Vypíše data do konzole prohlížeče (F12), abychom ověřili, že spojení funguje
        console.log("Kontakty z databáze:", nodesData);
    </script>
</body>
</html>