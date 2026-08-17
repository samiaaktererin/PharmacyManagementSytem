<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);
$order = $conn->query("SELECT * FROM orders WHERE id=$id AND user_id=".$_SESSION['user_id'])->fetch_assoc();

if (!$order) {
    echo "❌ Invalid order.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Track Order</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f8f9fa; text-align:center; padding:40px; }
        .track-box { background:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); display:inline-block; }
        h2 { color:#007bff; }
        p { font-size:16px; }
        .status { font-size:18px; font-weight:bold; color:#28a745; }
    </style>
</head>
<body>

<div class="track-box">
    <h2>📍 Tracking Order #<?= $order['id'] ?></h2>
    <p>Placed on: <?= $order['order_date'] ?></p>
    <p class="status">Current Status: <?= $order['status'] ?></p>
</div>

</body>
</html>
