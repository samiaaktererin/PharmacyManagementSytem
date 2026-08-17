<?php include 'header.php'; ?>
<?php
include 'db.php'; // Database connection

$threshold = 10;
$sql = "SELECT * FROM medicines ORDER BY quantity ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Tracking</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
      color: #333;
    }

    h2 {
      text-align: center;
      color: #333;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .demo-box {
      max-width: 900px;
      background: #ffffff;
      margin: 40px auto;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
      overflow: hidden;
      border-radius: 10px;
    }

    th, td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background: #007bff;
      color: #fff;
      font-weight: bold;
      text-transform: uppercase;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    tr:hover {
      background: #f1f1f1;
    }

    .low-stock {
      background: #ffe5e5 !important;
      color: #d32f2f;
      font-weight: bold;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      th {
        display: none;
      }
      tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
      }
      td {
        text-align: right;
        padding-left: 50%;
        position: relative;
      }
      td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: bold;
        text-transform: uppercase;
      }
    }
  </style>
</head>
<body>

<div class="demo-box">
  <h2>📦 Stock Tracking</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Medicine Name</th>
        <th>Batch No</th>
        <th>Quantity</th>
        <th>Expiry Date</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $lowClass = ($row['quantity'] < $threshold) ? "low-stock" : "";
              echo "<tr class='{$lowClass}'>
                      <td data-label='ID'>{$row['id']}</td>
                      <td data-label='Medicine Name'>{$row['name']}</td>
                      <td data-label='Batch No'>{$row['batch_no']}</td>
                      <td data-label='Quantity'>{$row['quantity']}</td>
                      <td data-label='Expiry Date'>{$row['expiry_date']}</td>
                      <td data-label='Price'>{$row['selling_price']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='6'>No medicines found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php include 'footer.php'; ?>
