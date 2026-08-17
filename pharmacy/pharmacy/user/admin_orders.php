<?php
if (isset($_POST['update_status'])) {
    $oid = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $q = "UPDATE orders SET status='$status' WHERE id=$oid";
    if ($conn->query($q)) {
        echo "✅ Updated to $status";
    } else {
        echo "❌ Error: ".$conn->error;
    }
    header("Refresh:2; url=admin_orders.php");
    exit();
}


// ✅ Fetch all orders
$conn->query("UPDATE orders SET status='$status' WHERE id=$oid") or die($conn->error);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Orders Management</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f1f5f9; margin:0; padding:0; }
        h2 { background:#343a40; color:white; padding:15px; margin:0; }
        .container { width:95%; margin:20px auto; }
        table { width:100%; border-collapse:collapse; background:white; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding:12px; border-bottom:1px solid #ddd; text-align:center; }
        th { background:#007bff; color:white; }
        .btn { padding:6px 12px; border:none; border-radius:5px; cursor:pointer; }
        .btn-update { background:#28a745; color:white; }
        .btn-update:hover { background:#218838; }
        select { padding:5px; }
    </style>
</head>
<body>

<h2>🛒 Admin - Orders Management</h2>

<div class="container">
    <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
            <th>Update</th>
        </tr>
        <?php while ($o = $orders->fetch_assoc()): ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td><?= $o['customer'] ?></td>
                <td><?= $o['order_date'] ?></td>
                <td>৳<?= number_format($o['total'],2) ?></td>
                <td><?= $o['status'] ?></td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
               <select name="status">
    <option value="Pending"   <?= $o['status']=="Pending"?"selected":"" ?>>Pending</option>
    <option value="Shipped"   <?= $o['status']=="Shipped"?"selected":"" ?>>Shipped</option>
    <option value="Delivered" <?= $o['status']=="Delivered"?"selected":"" ?>>Delivered</option>
    <option value="Cancelled" <?= $o['status']=="Cancelled"?"selected":"" ?>>Cancelled</option>
</select>


                        <button class="btn btn-update" type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
