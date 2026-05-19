<?php
session_start();
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $address = sanitize($_POST['address']);

    $errors = [];
    if (empty($name)) $errors[] = 'Nome obrigatório';
    if (!validateEmail($email)) $errors[] = 'Email inválido';
    if (strlen($password) < 6) $errors[] = 'Password deve ter pelo menos 6 caracteres';
    if (empty($address)) $errors[] = 'Endereço obrigatório';

    $users = loadJson(USERS_FILE);
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $errors[] = 'Email já registado';
            break;
        }
    }

    if (empty($errors)) {
        $newUser = [
            'id' => count($users) + 1,
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'address' => $address,
            'points' => 0
        ];
        $users[] = $newUser;
        saveJson(USERS_FILE, $users);
        $_SESSION['user'] = $newUser;
        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Registar</title>
</head>
<body>
    <h1>Registar</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post">
        <label>Nome: <input type="text" name="name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <label>Endereço: <textarea name="address" required></textarea></label><br>
        <button type="submit">Registar</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>