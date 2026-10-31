<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace do CRM</title>
</head>
<body>
    <h2>Vytvořit nový účet</h2>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
        <p><a href="index.php?action=login">Přejít na přihlášení</a></p>
    <?php else: ?>
        <form method="POST" action="index.php?action=register">
            <label>Uživatelské jméno:</label><br>
            <input type="text" name="username" required><br><br>
            
            <label>Heslo:</label><br>
            <input type="password" name="password" required><br><br>

            <label>Potvrzení hesla:</label><br>
            <input type="password" name="password_confirm" required><br><br>
            
            <button type="submit">Zaregistrovat se</button>
        </form>
        <br>
        <a href="index.php?action=login">Už mám účet (Zpět na přihlášení)</a>
    <?php endif; ?>
</body>
</html>