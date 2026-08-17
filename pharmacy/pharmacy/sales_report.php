


<?php
include 'db.php';

$report_type = $_GET['type'] ?? 'daily'; // daily or monthly

if($report_type == 'monthly') {
    $sql = "SELECT medicine_name, SUM(quantity) AS total_qty,
                   SUM(selling_price*quantity) AS total_sales,
                   SUM((selling_price - cost_price)*quantity) AS total_profit
            FROM profit
            WHERE MONTH(sale_date) = MONTH(CURDATE()) AND YEAR(sale_date) = YEAR(CURDATE())
            GROUP BY medicine_name";
    $title = "Monthly Sales & Profit Report";
} else {
    $sql = "SELECT medicine_name, SUM(quantity) AS total_qty,
                   SUM(selling_price*quantity) AS total_sales,
                   SUM((selling_price - cost_price)*quantity) AS total_profit
            FROM profit
            WHERE sale_date = CURDATE()
            GROUP BY medicine_name";
    $title = "Daily Sales & Profit Report";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        h2 {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 25px;
            text-align: center;
        }
        .btn-toggle a {
            margin: 0 5px;
        }
        .table thead th {
            background: #2c3e50;
            color: #fff;
            text-transform: uppercase;
        }
        .table tbody tr:hover {
            background: #f1f1f1;
        }
        .profit { color: green; font-weight: bold; }
        .loss { color: red; font-weight: bold; }
        .summary-row {
            background: #e9ecef;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($title) ?></h2>

    <div class="text-center btn-toggle mb-3">
        <a href="?type=daily" class="btn btn-primary <?= $report_type === 'daily' ? 'disabled' : '' ?>">Daily Report</a>
        <a href="?type=monthly" class="btn btn-secondary <?= $report_type === 'monthly' ? 'disabled' : '' ?>">Monthly Report</a>
    </div>

    <table class="table table-bordered table-striped text-center">
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Total Quantity</th>
                <th>Total Sales</th>
                <th>Profit / Loss</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grand_sales = 0;
            $grand_profit = 0;

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $profit_class = ($row['total_profit'] >= 0) ? 'profit' : 'loss';
                    $grand_sales += $row['total_sales'];
                    $grand_profit += $row['total_profit'];

                    echo "<tr>
                            <td>".htmlspecialchars($row['medicine_name'])."</td>
                            <td>".(int)$row['total_qty']."</td>
                            <td>$".number_format($row['total_sales'], 2)."</td>
                            <td class='$profit_class'>$".number_format($row['total_profit'], 2)."</td>
                          </tr>";
                }

                $grand_class = ($grand_profit >= 0) ? 'profit' : 'loss';
                echo "<tr class='summary-row'>
                        <td colspan='2'>Grand Total</td>
                        <td>$".number_format($grand_sales, 2)."</td>
                        <td class='$grand_class'>$".number_format($grand_profit, 2)."</td>
                      </tr>";
            } else {
                echo "<tr><td colspan='4'>No sales data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php $conn->close(); ?>
