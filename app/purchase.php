<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$products = loadJson(PRODUCTS_FILE);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = (int)$_POST['product'];
    $quantity = (int)$_POST['quantity'];
    $warranty = isset($_POST['warranty']) ? 10 : 0;
    $giftWrap = isset($_POST['gift_wrap']) ? 5 : 0;
    $usePoints = min((int)$_POST['use_points'], $user['points']);

    $product = null;
    foreach ($products as $p) {
        if ($p['id'] == $productId) {
            $product = $p;
            break;
        }
    }

    if ($product && $quantity > 0) {
        $subtotal = ($product['price'] * $quantity) + $warranty + $giftWrap;
        $discount = $usePoints;
        $total = $subtotal - $discount;

        // Store in session for checkout
        $_SESSION['cart'] = [
            'product' => $product,
            'quantity' => $quantity,
            'warranty' => $warranty,
            'gift_wrap' => $giftWrap,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ];
        header('Location: checkout.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Compra</title>
</head>
<body>
    <h1>Fazer Compra</h1>
    <p>Pontos disponíveis: <?php echo $user['points']; ?></p>
    <form method="post">
        <label>Produto:
            <select name="product" required>
                <option value="">Selecione</option>
                <?php foreach ($products as $p): ?>
                    <option value="<?php echo $p['id']; ?>"><?php echo sanitize($p['name']); ?> - €<?php echo $p['price']; ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>

        <label>Quantidade:
            <input type="radio" name="quantity" value="1" checked> 1
            <input type="radio" name="quantity" value="2"> 2
            <input type="radio" name="quantity" value="3"> 3
            <input type="radio" name="quantity" value="4"> 4
            <input type="radio" name="quantity" value="5"> 5
        </label><br>

        <label><input type="checkbox" name="warranty" value="1"> Garantia Extendida (+€10)</label><br>
        <label><input type="checkbox" name="gift_wrap" value="1"> Embrulho para Presente (+€5)</label><br>

        <label>Usar Pontos (máx <?php echo $user['points']; ?>): <input type="number" name="use_points" min="0" max="<?php echo $user['points']; ?>" value="0"></label><br>

        <button type="submit">Calcular e Continuar</button>
    </form>
    <a href="dashboard.php">Voltar</a>
</body>
</html>