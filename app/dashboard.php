<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = sanitize($_POST['name']);
    $address = sanitize($_POST['address']);

    $errors = [];
    if (empty($name)) $errors[] = 'Nome obrigatório';
    if (empty($address)) $errors[] = 'Endereço obrigatório';

    if (empty($errors)) {
        $users = loadJson(USERS_FILE);
        foreach ($users as &$u) {
            if ($u['id'] == $user['id']) {
                $u['name'] = $name;
                $u['address'] = $address;
                break;
            }
        }
        saveJson(USERS_FILE, $users);
        $_SESSION['user'] = $u;
        $user = $u;
        $success = 'Dados atualizados';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Nome: <?php echo sanitize($user['name']); ?></p>
    <p>Email: <?php echo sanitize($user['email']); ?></p>
    <p>Endereço: <?php echo sanitize($user['address']); ?></p>
    <p>Pontos: <?php echo $user['points']; ?></p>

    <?php if (isset($success)): ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Editar Perfil</h2>
    <form method="post">
        <label>Nome: <input type="text" name="name" value="<?php echo sanitize($user['name']); ?>" required></label><br>
        <label>Endereço: <textarea name="address" required><?php echo sanitize($user['address']); ?></textarea></label><br>
        <button type="submit" name="update">Atualizar</button>
    </form>

    <a href="purchase.php">Fazer Compra</a> | <a href="logout.php">Logout</a>
</body>
</html>