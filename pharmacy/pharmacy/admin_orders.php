<?php include 'header.php'; ?>
<?php
// session_start();
include 'db.php';

// ✅ Optional: Check admin
// if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1){
//     die("❌ Access Denied.");
// }

// ✅ Update order status
if (isset($_POST['update_status'])) {
    $oid = intval($_POST['order_id']);
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE id=$oid");
    header("Location: admin_orders.php");
    exit();
}

// ✅ Fetch all orders
$orders = $conn->query("SELECT o.*, u.name AS customer 
                        FROM orders o
                        JOIN users u ON o.user_id = u.id 
                        ORDER BY o.order_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Orders Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .table th { background:#0d6efd; color:white; }
        .table-hover tbody tr:hover { background-color:#f1f5ff; }
        .status-pending { color:#ff9800; font-weight:bold; }
        .status-shipped { color:#2196f3; font-weight:bold; }
        .status-delivered { color:#28a745; font-weight:bold; }
        .status-cancelled { color:#dc3545; font-weight:bold; }
        .card { border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.08); }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="card p-4">
        <h2 class="text-center text-primary mb-4">🛒 Orders Management</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($o = $orders->fetch_assoc()): ?>
                        <tr>
                            <td><?= $o['id'] ?></td>
                            <td><?= htmlspecialchars($o['customer']) ?></td>
                            <td><?= $o['order_date'] ?></td>
                            <td>৳<?= number_format($o['total'],2) ?></td>
                            <td class="
                                <?= strtolower($o['status']) == 'pending' ? 'status-pending' : '' ?>
                                <?= strtolower($o['status']) == 'shipped' ? 'status-shipped' : '' ?>
                                <?= strtolower($o['status']) == 'delivered' ? 'status-delivered' : '' ?>
                                <?= strtolower($o['status']) == 'cancelled' ? 'status-cancelled' : '' ?>
                            ">
                                <?= $o['status'] ?>
                            </td>
                            <td>
                                <form method="POST" class="d-flex gap-2 justify-content-center">
                                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                    <select name="status" class="form-select form-select-sm w-auto">
                                        <option <?= $o['status']=="Pending"?"selected":"" ?>>Pending</option>
                                        <option <?= $o['status']=="Shipped"?"selected":"" ?>>Shipped</option>
                                        <option <?= $o['status']=="Delivered"?"selected":"" ?>>Delivered</option>
                                        <option <?= $o['status']=="Cancelled"?"selected":"" ?>>Cancelled</option>
                                    </select>
                                    <button class="btn btn-success btn-sm" type="submit" name="update_status">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
<?php include 'footer.php'; ?>