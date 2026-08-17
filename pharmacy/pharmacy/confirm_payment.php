<?php
// confirm_payment.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sale_id = $_POST['sale_id'];

    // Update payment status
    $conn->query("UPDATE sales SET payment_status='Paid' WHERE id='$sale_id'");

    // --- Fetch sale details for report update ---
    $result = $conn->query("SELECT si.medicine_name, si.quantity, si.selling_price, si.cost_price, s.sale_date
                            FROM sales_items si
                            JOIN sales s ON si.sale_id = s.id
                            WHERE s.id='$sale_id'");
    
    $subtotal = 0;
    while($row = $result->fetch_assoc()){
        $subtotal += ($row['quantity'] * $row['selling_price']);
    }

    // Update Daily Report
    $today = date("Y-m-d");
    $check = $conn->query("SELECT id FROM daily_report WHERE report_date='$today'");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE daily_report SET total_sales = total_sales+$subtotal WHERE report_date='$today'");
    } else {
        $conn->query("INSERT INTO daily_report (report_date, total_sales) VALUES ('$today','$subtotal')");
    }

    // Update Monthly Report
    $month = date("Y-m");
    $check2 = $conn->query("SELECT id FROM monthly_report WHERE report_month='$month'");
    if ($check2->num_rows > 0) {
        $conn->query("UPDATE monthly_report SET total_sales = total_sales+$subtotal WHERE report_month='$month'");
    } else {
        $conn->query("INSERT INTO monthly_report (report_month, total_sales) VALUES ('$month','$subtotal')");
    }

    echo "✅ Payment Confirmed & Reports Updated!<br>";
    echo "<a href='daily_report.php?type=daily'>View Daily Report</a>";
}
?>
