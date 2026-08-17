
<?php include 'footer.php'; ?>

<?php
include 'db.php';

// Check if sale_id is passed
if (!isset($_GET['id'])) {
    die("❌ Invalid request. No invoice ID given.");
}


$sale_id = intval($_GET['id']);

// Fetch the sale record
$sql = "SELECT * FROM sales WHERE id = $sale_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("❌ Invoice not found.");
}

$sale = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?= $sale_id; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .invoice-box {
            border: 1px solid #ddd;
            padding: 20px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th { background: #f4f4f4; }
        .total { font-weight: bold; }
        .print-btn {
            margin-top: 20px;
            display: block;
            text-align: center;
        }
        .print-btn button {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .print-btn button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <h2>Pharmacy Invoice</h2>

    <p><b>Invoice ID:</b> <?= $sale['id']; ?></p>
    <p><b>Customer:</b> <?= htmlspecialchars($sale['customer_name']); ?></p>
    <p><b>Date:</b> <?= $sale['date']; ?></p>

    <table>
        <tr>
            <th>Medicine</th>
            <th>Price (per unit)</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($sale['medicine_name']); ?></td>
            <td><?= number_format($sale['price'], 2); ?></td>
            <td><?= $sale['quantity']; ?></td>
            <td><?= number_format($sale['price'] * $sale['quantity'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" class="total">Grand Total</td>
            <td class="total"><?= number_format($sale['total'], 2); ?></td>
        </tr>
    </table>

    <div class="print-btn">
        <button onclick="window.print()">🖨 Print Invoice</button>
    </div>
</div>

</body>
</html>
