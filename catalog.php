<?php
session_start();
require '../model/db_connect.php';

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY id");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Stevie's PHP Store - Catalog</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Stevie's PHP Store</h1>
    </header>
    <nav>
        <a href="catalog.php">Catalog</a>
        <a href="../controller/cart.php">Cart</a>
    </nav>
    <div class="container">
        <p>Welcome! Browse our products below.</p>

        <div class="products">
            <?php foreach ($products as $p):
                $current_qty = $_SESSION['cart'][$p['id']] ?? 0;
                ?>
                <div class="product">
                    <h3><?= htmlspecialchars($p['name']) ?></h3>
                    <p><strong>ID:</strong> <?= $p['id'] ?></p>
                    <p><?= htmlspecialchars($p['description']) ?></p>
                    <p class="price">$<?= number_format($p['price'], 2) ?></p>
                    <p><strong>In Cart:</strong> <?= $current_qty ?></p>

                    <form method="POST" action="../controller/cart.php">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <label>Quantity: <input type="number" name="qty" value="<?= $current_qty ?>" min="0"></label>
                        <button type="submit">Update Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <br><br>
        <a href="../controller/cart.php" class="btn">Go to Shopping Cart →</a>
    </div>
    <footer>
        <p>&copy; 2026 Stevie's PHP Store</p>
    </footer>
</body>

</html>