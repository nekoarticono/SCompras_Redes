<?php
session_start();
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    if ($email == ADMIN_EMAIL && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin'] = true;
        header('Location: admin_dashboard.php');
        exit;
    }
    $error = 'Credenciais inválidas';
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit">Login</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>