<?php
session_start();
require 'db_connect.php';

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY id");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Stevie's PHP Store - Catalog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .product {
            border: 1px solid #ccc;
            margin: 15px;
            padding: 15px;
            width: 400px;
            display: inline-block;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <h1>Stevie's PHP Store</h1>
    <p>Welcome! Browse our products below.</p>

    <?php foreach ($products as $p):
        $current_qty = $_SESSION['cart'][$p['id']] ?? 0;
        ?>
        <div class="product">
            <strong>Product ID:</strong> <?= $p['id'] ?><br>
            <strong><?= htmlspecialchars($p['name']) ?></strong><br>
            <?= htmlspecialchars($p['description']) ?><br>
            <strong>Price:</strong> $<?= number_format($p['price'], 2) ?><br>
            <strong>Quantity currently in the cart:</strong> <?= $current_qty ?><br><br>

            <form method="POST" action="cart.php">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <label>Quantity: <input type="number" name="qty" value="<?= $current_qty ?>" min="0"></label>
                <button type="submit">Update Cart</button>
            </form>
        </div>
    <?php endforeach; ?>

    <br><br>
    <a href="cart.php"><strong>Go to Shopping Cart →</strong></a>
</body>

</html>