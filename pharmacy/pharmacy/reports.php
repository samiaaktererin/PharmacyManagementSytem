<?php
include 'db.php';

$type = $_GET['type'] ?? 'daily'; // daily or monthly

if ($type === 'daily') {
    $query = "SELECT medicine_name, 
                     SUM(quantity) AS total_qty, 
                     SUM(quantity * selling_price) AS total_sales,
                     SUM((selling_price - cost_price) * quantity) AS profit
              FROM profit
              WHERE sale_date = CURDATE()
              GROUP BY medicine_name";
    $title = "Daily Sales & Profit Report";
} else {
    $query = "SELECT medicine_name, 
                     SUM(quantity) AS total_qty, 
                     SUM(quantity * selling_price) AS total_sales,
                     SUM((selling_price - cost_price) * quantity) AS profit
              FROM profit
              WHERE MONTH(sale_date) = MONTH(CURDATE()) 
                AND YEAR(sale_date) = YEAR(CURDATE())
              GROUP BY medicine_name";
    $title = "Monthly Sales & Profit Report";
}

$result = $conn->query($query);

$medNames = [];
$salesData = [];
$profitData = [];

while($row = $result->fetch_assoc()) {
    $medNames[] = $row['medicine_name'];
    $salesData[] = $row['total_sales'];
    $profitData[] = $row['profit'];
    $data[] = $row;
}

$result->data_seek(0); // Reset pointer for table loop
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
      margin-top: 40px;
    }
    h2 {
      text-align: center;
      color: #2c3e50;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .btn-toggle {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    .btn-toggle a {
      margin: 0 10px;
    }
    table {
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    thead th {
      background: #2c3e50;
      color: #fff;
      font-weight: 600;
      text-transform: uppercase;
    }
    tbody tr:hover {
      background: #f1f1f1;
    }
    .profit { color: green; font-weight: bold; }
    .loss { color: red; font-weight: bold; }
    .chart-container {
      margin-top: 40px;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
<div class="container">
  <h2><?= htmlspecialchars($title) ?></h2>
  
  <div class="btn-toggle">
    <a href="?type=daily" class="btn btn-primary <?= $type === 'daily' ? 'disabled' : '' ?>">Daily Report</a>
    <a href="?type=monthly" class="btn btn-secondary <?= $type === 'monthly' ? 'disabled' : '' ?>">Monthly Report</a>
  </div>

  <table class="table table-bordered table-striped text-center">
    <thead>
      <tr>
        <th>Medicine Name</th>
        <th>Total Quantity Sold</th>
        <th>Total Sales</th>
        <th>Profit</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $totalSales = 0;
      $totalProfit = 0;

      if ($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
          $profitClass = $row['profit'] >= 0 ? 'profit' : 'loss';
          $totalSales += $row['total_sales'];
          $totalProfit += $row['profit'];
      ?>
      <tr>
        <td><?= htmlspecialchars($row['medicine_name']) ?></td>
        <td><?= (int)$row['total_qty'] ?></td>
        <td>$<?= number_format($row['total_sales'],2) ?></td>
        <td class="<?= $profitClass ?>">$<?= number_format($row['profit'],2) ?></td>
      </tr>
      <?php endwhile; ?>
      <tr class="table-light fw-bold">
        <td colspan="2">Grand Total</td>
        <td>$<?= number_format($totalSales,2) ?></td>
        <td class="<?= $totalProfit >= 0 ? 'profit' : 'loss' ?>">$<?= number_format($totalProfit,2) ?></td>
      </tr>
      <?php else: ?>
      <tr>
        <td colspan="4">No sales data available</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <?php if (!empty($medNames)): ?>
  <div class="chart-container">
    <canvas id="salesProfitChart"></canvas>
  </div>
  <?php endif; ?>
</div>

<script>
const ctx = document.getElementById('salesProfitChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($medNames) ?>,
        datasets: [
            {
                label: 'Total Sales',
                data: <?= json_encode($salesData) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Profit',
                data: <?= json_encode($profitData) ?>,
                type: 'line',
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Sales & Profit Visualization',
                font: { size: 18 }
            },
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
</body>
</html>
<?php $conn->close(); ?>
