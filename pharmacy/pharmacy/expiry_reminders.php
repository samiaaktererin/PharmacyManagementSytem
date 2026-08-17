<?php include 'header.php'; ?>
<?php
include 'db.php';

$sql = "SELECT * FROM medicines ORDER BY expiry_date ASC";
$result = $conn->query($sql);

$today = date("Y-m-d");
$nearExpiryDate = date("Y-m-d", strtotime("+30 days"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expiry Date Reminders</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .demo-box {
      max-width: 900px;
      background: #fff;
      margin: 40px auto;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    h2 {
      text-align: center;
      font-size: 26px;
      color: #007bff;
      margin-bottom: 20px;
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
      font-size: 15px;
    }

    th, td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #e0e0e0;
    }

    th {
      background: #007bff;
      color: #fff;
      text-transform: uppercase;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    tr:hover {
      background: #f1f1f1;
    }

    /* Expired row style */
    .expired {
      background: #ff4d4d !important;
      color: white;
      font-weight: bold;
    }

    /* Near expiry row style */
    .near-expiry {
      background: #fff3cd !important;
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
  <h2>📅 Expiry Date Reminders</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Medicine Name</th>
        <th>Batch No</th>
        <th>Quantity</th>
        <th>Expiry Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $expiry = $row['expiry_date'];
              $rowClass = "";
              if ($expiry < $today) {
                  $rowClass = "expired"; // expired
              } elseif ($expiry <= $nearExpiryDate) {
                  $rowClass = "near-expiry"; // near expiry
              }
              echo "<tr class='{$rowClass}'>
                      <td data-label='ID'>{$row['id']}</td>
                      <td data-label='Medicine Name'>{$row['name']}</td>
                      <td data-label='Batch No'>{$row['batch_no']}</td>
                      <td data-label='Quantity'>{$row['quantity']}</td>
                      <td data-label='Expiry Date'>{$row['expiry_date']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='5'>No medicines found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php include 'footer.php'; ?>
