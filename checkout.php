<?php
session_start();
unset($_SESSION['cart']);
header("Location: ../view/catalog.php?msg=" . urlencode("Thank you for your purchase!"));
exit;
?>