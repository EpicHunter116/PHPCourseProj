<?php
session_start();
unset($_SESSION['cart']);
header("Location: catalog.php?msg=Thank you for your purchase!");
exit;
?>