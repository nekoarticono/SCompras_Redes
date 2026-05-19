<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['cart'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$cart = $_SESSION['cart'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    // Generate invoice
    $invoiceNumber = generateInvoiceNumber();
    $invoice = [
        'number' => $invoiceNumber,
        'user_id' => $user['id'],
        'user_name' => $user['name'],
        'user_email' => $user['email'],
        'product' => $cart['product']['name'],
        'quantity' => $cart['quantity'],
        'subtotal' => $cart['subtotal'],
        'discount' => $cart['discount'],
        'total' => $cart['total'],
        'date' => date('Y-m-d H:i:s'),
        'warranty' => $cart['warranty'] > 0,
        'gift_wrap' => $cart['gift_wrap'] > 0
    ];

    $invoices = loadJson(INVOICES_FILE);
    $invoices[] = $invoice;
    saveJson(INVOICES_FILE, $invoices);

    // Update user points: add points for purchase, subtract used
    $earnedPoints = floor($cart['total'] * POINTS_PER_CURRENCY);
    $newPoints = $user['points'] - $cart['discount'] + $earnedPoints;

    $users = loadJson(USERS_FILE);
    foreach ($users as &$u) {
        if ($u['id'] == $user['id']) {
            $u['points'] = $newPoints;
            break;
        }
    }
    saveJson(USERS_FILE, $users);
    $_SESSION['user']['points'] = $newPoints;

    // Send email
    $subject = 'Confirmação de Compra - Fatura ' . $invoiceNumber;
    $body = "
    <h1>Obrigado pela sua compra!</h1>
    <p>Fatura: $invoiceNumber</p>
    <p>Produto: {$cart['product']['name']}</p>
    <p>Quantidade: {$cart['quantity']}</p>
    <p>Total: €{$cart['total']}</p>
    <p>Pontos ganhos: $earnedPoints</p>
    ";
    sendConfirmationEmail($user['email'], $subject, $body);

    unset($_SESSION['cart']);
    $success = 'Compra realizada com sucesso! Fatura enviada por email.';
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <p>Produto: <?php echo sanitize($cart['product']['name']); ?> (x<?php echo $cart['quantity']; ?>)</p>
    <p>Subtotal: €<?php echo $cart['subtotal']; ?></p>
    <p>Desconto: €<?php echo $cart['discount']; ?></p>
    <p>Total: €<?php echo $cart['total']; ?></p>
    <?php if ($cart['warranty'] > 0): ?><p>Garantia Extendida: €10</p><?php endif; ?>
    <?php if ($cart['gift_wrap'] > 0): ?><p>Embrulho: €5</p><?php endif; ?>

    <?php if (isset($success)): ?>
        <p><?php echo $success; ?></p>
        <a href="dashboard.php">Voltar ao Dashboard</a>
    <?php else: ?>
        <form method="post">
            <button type="submit" name="confirm">Confirmar Compra</button>
        </form>
        <a href="purchase.php">Voltar</a>
    <?php endif; ?>
</body>
</html>