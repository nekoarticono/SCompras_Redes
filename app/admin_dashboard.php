<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

$invoices = loadJson(INVOICES_FILE);
$totalSales = count($invoices);
$totalAmount = 0;
foreach ($invoices as $inv) {
    $totalAmount += $inv['total'];
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Número de Vendas: <?php echo $totalSales; ?></p>
    <p>Total Acumulado: €<?php echo $totalAmount; ?></p>

    <h2>Lista de Faturas</h2>
    <table border="1">
        <tr>
            <th>Número</th>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Total</th>
            <th>Data</th>
        </tr>
        <?php foreach ($invoices as $inv): ?>
            <tr>
                <td><?php echo $inv['number']; ?></td>
                <td><?php echo sanitize($inv['user_name']); ?></td>
                <td><?php echo sanitize($inv['product']); ?></td>
                <td><?php echo $inv['quantity']; ?></td>
                <td>€<?php echo $inv['total']; ?></td>
                <td><?php echo $inv['date']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>