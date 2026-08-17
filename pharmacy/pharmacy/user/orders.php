<?php
session_start();
include 'db.php';

// ✅ Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];

// ✅ Handle Cancel Request
if (isset($_GET['cancel'])) {
    $oid = intval($_GET['cancel']);
    $conn->query("UPDATE orders SET status='Cancelled' WHERE id=$oid AND user_id=$uid AND status='Pending'");
    header("Location: orders.php");
    exit();
}

// ✅ Fetch all orders of this user
$orders = $conn->query("SELECT * FROM orders WHERE user_id=$uid ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f8f9fa; margin:0; padding:0; }
        h2 { background:#007bff; color:white; padding:15px; margin:0; }
        .container { width:90%; margin:20px auto; }
        table { width:100%; border-collapse: collapse; background:white; box-shadow:0 2px 5px rgba(0,0,0,0.1); margin-bottom:30px; }
        th, td { padding:12px; border-bottom:1px solid #ddd; text-align:center; }
        th { background:#007bff; color:white; }
        .btn { padding:6px 12px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; text-decoration:none; }
        .btn:hover { background:#218838; }
        .btn-cancel { background:#dc3545; }
        .btn-cancel:hover { background:#b52b3a; }
        .status { font-weight:bold; }
        .order-box { margin-bottom:40px; padding:15px; border-radius:8px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
        .actions { margin-top:10px; }
    </style>
</head>
<body>

<h2>📦 My Orders - <?= $_SESSION['user_name'] ?></h2>

<div class="container">
    <?php if ($orders->num_rows == 0): ?>
        <p>You have no orders yet. <a href="shop.php">🛒 Start Shopping</a></p>
    <?php else: ?>
        <?php while ($o = $orders->fetch_assoc()): ?>
            <div class="order-box">
                <h3>Order #<?= $o['id'] ?> | Date: <?= $o['order_date'] ?> | Total: ৳<?= number_format($o['total'],2) ?></h3>
                <p class="status">Status: <?= $o['status'] ?></p>

                <!-- Fetch order items -->
                <?php
                $items = $conn->query("SELECT oi.*, m.name 
                                        FROM order_items oi 
                                        JOIN medicines m ON oi.medicine_id=m.id 
                                        WHERE oi.order_id=".$o['id']);
                ?>
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                    <?php while($i = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i['name'] ?></td>
                            <td><?= $i['quantity'] ?></td>
                            <td>৳<?= number_format($i['price'],2) ?></td>
                            <td>৳<?= number_format($i['quantity'] * $i['price'],2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>

                <!-- Actions -->
                <div class="actions">
                    <?php if ($o['status'] == 'Pending'): ?>
                        <a class="btn btn-cancel" href="orders.php?cancel=<?= $o['id'] ?>" onclick="return confirm('Cancel this order?')">❌ Cancel</a>
                    <?php endif; ?>
                    <a class="btn" href="track_order.php?id=<?= $o['id'] ?>">📍 Track</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

</body>
</html>
