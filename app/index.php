<?php
session_start();
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Compras Online</title>
</head>
<body>
    <h1>Bem-vindo ao Sistema de Compras Online</h1>
    <?php if (isset($_SESSION['user'])): ?>
        <p>Olá, <?php echo sanitize($_SESSION['user']['name']); ?>!</p>
        <a href="dashboard.php">Dashboard</a> | <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="register.php">Registar</a> | <a href="login.php">Login</a>
    <?php endif; ?>
    <a href="admin_login.php">Admin Login</a>
</body>
</html>