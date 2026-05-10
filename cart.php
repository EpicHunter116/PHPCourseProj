<?php
session_start();
require '../model/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $action = $_POST['action'] ?? '';

    if (!isset($_SESSION['cart']))
        $_SESSION['cart'] = [];

    if ($action === 'add') {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$id]);
    } elseif ($action === 'update') {
        $qty = max(0, (int) $_POST['qty']);
        if ($qty > 0)
            $_SESSION['cart'][$id] = $qty;
        else
            unset($_SESSION['cart'][$id]);
    }
}

// Get cart items
$cart_items = [];
$subtotal = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    foreach ($stmt->fetchAll() as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $item_total = $qty * $p['price'];
        $subtotal += $item_total;
        $cart_items[] = [
            'id' => $p['id'],
            'name' => $p['name'],
            'qty' => $qty,
            'price' => $p['price'],
            'total' => $item_total
        ];
    }
}

$tax = $subtotal * 0.05;
$shipping = $subtotal * 0.10;
$total = $subtotal + $tax + $shipping;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Cart - Stevie's PHP Store</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Your Shopping Cart</h1>
    </header>
    <nav>
        <a href="../view/catalog.php">Catalog</a>
        <a href="../controller/cart.php">Cart</a>
    </nav>
    <div class="container">
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="cart-table">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>$<?= number_format($item['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <div class="order-summary">
            <h2>Order Summary</h2>
            <p>Subtotal: $<?= number_format($subtotal, 2) ?></p>
            <p>Tax (5%): $<?= number_format($tax, 2) ?></p>
            <p>Shipping & Handling (10%): $<?= number_format($shipping, 2) ?></p>
            <h3>Order Total: $<?= number_format($total, 2) ?></h3>
        </div>

        <br>
        <a href="../view/catalog.php" class="btn btn-secondary">← Continue Shopping</a>
        <form method="POST" action="checkout.php" style="display: inline;">
            <button type="submit" class="btn">Check Out</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2023 Stevie's PHP Store</p>
    </footer>
</body>

</html>