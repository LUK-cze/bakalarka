<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Osobní CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
</head>
<body class="bg-light">

    <!-- Plátno pro React -->
    <div id="root"></div>

    <!-- React a Babel -->
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <!-- Komponenty -->
    <script type="text/babel" src="js/components/header.js"></script>
    <script type="text/babel" src="js/components/footer.js"></script>

    <script type="text/babel" src="js/components/header.js"></script>
    <script type="text/babel" src="js/components/LoginForm.js"></script>
    <script type="text/babel" src="js/components/RegisterForm.js"></script>

    <!-- Hlavní spouštěcí skript -->
    <script type="text/babel" src="js/app.js"></script>
</body>
</html>