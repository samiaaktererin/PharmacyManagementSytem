<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['medicine_id'])) {
    $customer_name = $_POST['customer_name'];
    $tax_rate = $_POST['tax_rate'] ?? 0;
    $medicine_ids = $_POST['medicine_id'];

    $subtotal = 0;
    $total_profit = 0;
    $invoice_items = [];

    foreach ($medicine_ids as $id) {
        $qty   = $_POST['quantity'][$id] ?? 0;
        $price = $_POST['price'][$id] ?? 0;

        if ($qty > 0 && $price > 0) {
            $res = $conn->query("SELECT * FROM medicines WHERE id=$id");
            $med = $res->fetch_assoc();

            if ($med && $med['quantity'] >= $qty) {
                $total   = $price * $qty;
                $profit  = ($price - $med['cost_price']) * $qty;

                $subtotal     += $total;
                $total_profit += $profit;

                $invoice_items[] = [
                    'id'    => $id,
                    'name'  => $med['name'],
                    'qty'   => $qty,
                    'price' => $price,
                    'total' => $total
                    // profit saved in DB only
                ];

                // ✅ Update stock
                $conn->query("UPDATE medicines SET quantity = quantity - $qty WHERE id=$id");
            }
        }
    }

    $tax_amount  = ($subtotal * $tax_rate) / 100;
    $grand_total = $subtotal + $tax_amount;

    // ✅ Insert into sales table
    $conn->query("INSERT INTO sales (customer_name, tax_rate, subtotal, tax_amount, grand_total, profit, sale_date)
                  VALUES ('$customer_name', $tax_rate, $subtotal, $tax_amount, $grand_total, $total_profit, NOW())");

    $sale_id = $conn->insert_id;

    // ✅ Insert items
    foreach ($invoice_items as $item) {
        $conn->query("INSERT INTO sales_items (sale_id, medicine_id, quantity, selling_price, cost_price, total, profit)
                      VALUES ($sale_id, ".$item['id'].", ".$item['qty'].", ".$item['price'].", 0, ".$item['total'].", 0)");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f5f6fa; margin: 20px; }
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
                background: #fff;
                box-shadow: 0 0 10px rgba(0,0,0,.1);
            }
            h2 { text-align: center; margin-bottom: 20px; }
            table {
                width: 100%; border-collapse: collapse; margin-bottom: 20px;
            }
            table, th, td { border: 1px solid #ddd; }
            th, td { padding: 10px; text-align: center; }
            th { background: #f0f0f0; }
            .summary {
                text-align: right; margin-top: 20px;
            }
            .summary p { font-size: 16px; margin: 5px 0; }
            .btn { display: inline-block; padding: 10px 15px; background: #2ecc71; color: #fff; text-decoration: none; border-radius: 5px; }
            .btn:hover { background: #27ae60; }
        </style>
    </head>
    <body>
        <div class="invoice-box">
            <h2>Al_Khadma Pharmacy Invoice</h2>
            <p><b>Customer:</b> <?= htmlspecialchars($customer_name) ?></p>
            <p><b>Date:</b> <?= date("Y-m-d H:i:s") ?></p>

            <table>
                <tr>
                    <th>Medicine</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($invoice_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= number_format($item['price'],2) ?></td>
                    <td><?= number_format($item['total'],2) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <div class="summary">
                <p><b>Subtotal:</b> <?= number_format($subtotal,2) ?></p>
                <p><b>Tax (<?= $tax_rate ?>%):</b> <?= number_format($tax_amount,2) ?></p>
                <p><b>Grand Total:</b> <?= number_format($grand_total,2) ?></p>
            </div>

            <a href="sell_medicine.php" class="btn">← Back to Sell</a>
            <a href="javascript:window.print()" class="btn">🖨 Print Invoice</a>
        </div>
    </body>
    </html>
<?php
} else {
    echo "<p style='color:red;'>❌ No medicine selected.</p>";
    echo "<a href='sell_medicine.php'>Back</a>";
}
?>
