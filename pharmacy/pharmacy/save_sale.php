<?php
include 'db.php';

// insert into sales
$stmt = $conn->prepare("INSERT INTO sales (customer_name, sale_date, total_amount, tax_amount, grand_total) VALUES (?, NOW(), ?, ?, ?)");
$stmt->bind_param("sddd", $customer_name, $total_amount, $tax_amount, $grand_total);
$stmt->execute();
$sale_id = $stmt->insert_id; // get the new sale ID

// insert into sales_items table (loop your cart items here)

// finally redirect to invoice
header("Location: invoice.php?sale_id=" . $sale_id);
exit;
?>
