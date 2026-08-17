<?php include 'header.php'; ?>
<?php
include 'db.php';

$today = date("Y-m-d");

// Fetch today's sales and profit
$daily = $conn->query("SELECT SUM(grand_total) AS total_sales, SUM(profit) AS total_profit 
                       FROM sales 
                       WHERE DATE(sale_date) = '$today'");
$daily_report = $daily->fetch_assoc();
$total_sales = $daily_report['total_sales'] ?? 0;
$total_profit = $daily_report['total_profit'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: #f8fafc; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        .card {
            border-radius: 16px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
        }
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .stat-profit {
            font-size: 2rem;
            font-weight: bold;
            color: #28a745;
        }
        .back-link {
            text-decoration: none;
            color: #0d6efd;
            font-weight: 500;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-5 text-center w-50">
        <h2 class="text-primary mb-3">📊 Daily Report</h2>
        <h5 class="text-muted mb-4"><?= date("l, F j, Y") ?></h5>
        
        <div class="mb-4">
            <p class="mb-1 fw-semibold text-dark">Total Sales</p>
            <p class="stat-value">৳<?= number_format($total_sales, 2) ?></p>
        </div>
        <div class="mb-4">
            <p class="mb-1 fw-semibold text-dark">Total Profit</p>
            <p class="stat-profit">৳<?= number_format($total_profit, 2) ?></p>
        </div>
        
        <a href="index.php" class="back-link">⬅ Back to Reports Menu</a>
    </div>
</div>

</body>
</html>
<?php include 'footer.php'; ?>