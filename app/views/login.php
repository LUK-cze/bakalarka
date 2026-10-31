<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přihlášení do CRM</title>
</head>
<body>
    <h2>Přihlášení</h2>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=login">
        <label>Uživatelské jméno:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label>Heslo:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Přihlásit se</button>
        <br><a href="index.php?action=register">Vytvořit účet</a>
    </form>
</body>
</html>