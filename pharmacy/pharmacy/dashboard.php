<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pharmacy Dashboard</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Arial, sans-serif;
    }
    body {
      background: #f4f7fc;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background: #1e1e2f;
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 20px;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 40px;
      font-size: 24px;
      color: #f0ad4e;
      letter-spacing: 1px;
    }
    .menu { margin-bottom: 20px; }
    .menu-title {
      font-weight: bold;
      font-size: 15px;
      color: #ffc107;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 5px;
      cursor: pointer;
      border-radius: 6px;
      transition: background 0.3s ease;
    }
    .menu-title:hover {
      background: rgba(255,255,255,0.1);
    }
    .submenu {
      display: none;
      flex-direction: column;
      margin: 5px 0 0 10px;
    }
    .submenu a {
      padding: 8px 12px;
      font-size: 14px;
      color: #ddd;
      text-decoration: none;
      border-radius: 6px;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: background 0.3s;
    }
    .submenu a:hover {
      background: #444;
    }
    .logout {
      margin-top: auto;
      padding: 12px;
      background: #dc3545;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      transition: background 0.3s;
    }
    .logout:hover { background: #b02a37; }

    /* Main Wrapper */
    .main-wrapper {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    /* Topbar */
    .topbar {
      background: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ddd;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .search-box {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .search-box input {
      padding: 8px 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      width: 250px;
      font-size: 14px;
      outline: none;
    }
    .search-box button {
      padding: 8px 15px;
      border-radius: 6px;
      border: none;
      background: #28a745;
      color: #fff;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .search-box button:hover { background: #218838; }

    /* Main Content */
    .main-content {
      padding: 30px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .page-header {
      grid-column: 1/-1;
      background: linear-gradient(90deg, #4e73df, #1cc88a);
      color: #fff;
      padding: 25px 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }
    .page-header h1 {
      font-size: 28px;
      margin-bottom: 5px;
    }
    .page-header p {
      font-size: 16px;
      opacity: 0.85;
    }

    /* Cards */
    .card {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .card i {
      font-size: 36px;
      color: #007bff;
      margin-bottom: 10px;
    }
    .card h3 {
      font-size: 22px;
      color: #333;
    }
    .card p {
      color: #666;
      font-size: 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar { width: 220px; }
      .search-box input { width: 180px; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2><i class="fa-solid fa-capsules"></i> Pharmacy</h2>

    <div class="menu">
      <div class="menu-title" onclick="toggleMenu(this)">A. Inventory Management <i class="fa-solid fa-chevron-down"></i></div>
      <div class="submenu">
        <a href="medicines.php"><i class="fa-solid fa-plus"></i> Add/Edit/Delete Medicines</a>
        <a href="stock_tracking.php"><i class="fa-solid fa-boxes-stacked"></i> Stock Tracking</a>
        <a href="expiry_reminders.php"><i class="fa-solid fa-calendar-xmark"></i> Expiry Reminders</a>
      </div>
    </div>

    <div class="menu">
      <div class="menu-title" onclick="toggleMenu(this)">B. Sales & Billing <i class="fa-solid fa-chevron-down"></i></div>
      <div class="submenu">
        <a href="sell_medicine.php"><i class="fa-solid fa-receipt"></i> Sell Medicine</a>
      </div>
    </div>

    <div class="menu">
      <div class="menu-title" onclick="toggleMenu(this)">C. Reporting <i class="fa-solid fa-chevron-down"></i></div>
      <div class="submenu">
        <a href="daily_report.php"><i class="fa-solid fa-chart-line"></i> Daily Report</a>
        <a href="monthly.php"><i class="fa-solid fa-calendar"></i> Monthly Report</a>
        <a href="admin_orders.php"><i class="fa-solid fa-clipboard-list"></i> Admin Orders</a>
      </div>
    </div>

    <div class="menu">
      <div class="menu-title" onclick="toggleMenu(this)">D. Customer Management <i class="fa-solid fa-chevron-down"></i></div>
      <div class="submenu">
        <a href="customers.php"><i class="fa-solid fa-user"></i> Customer Details</a>
        <a href="prescription_upload.php"><i class="fa-solid fa-file-prescription"></i> Upload Prescription</a>
      </div>
    </div>

    <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </div>

  <!-- Main Wrapper -->
  <div class="main-wrapper">
    <div class="topbar">
      <h2>Dashboard</h2>
      <div class="search-box">
        <form method="GET" action="search.php">
          <input type="text" name="q" placeholder="Search medicine..." required>
          <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </div>
    </div>

    <div class="main-content">
      <div class="page-header">
        <h1>Welcome, Admin <i class="fa-solid fa-handshake-angle"></i></h1>
        <p>Manage medicines, customers, sales, and reports efficiently from one dashboard.</p>
      </div>

      <?php
      include 'db.php';
      $total_medicines = $conn->query("SELECT COUNT(*) as total FROM medicines")->fetch_assoc()['total'] ?? 0;
      $total_customers = $conn->query("SELECT COUNT(DISTINCT customer_name) as total FROM sales")->fetch_assoc()['total'] ?? 0;
      $todays_sales = $conn->query("SELECT SUM(grand_total) as total FROM sales WHERE DATE(sale_date)=CURDATE()")->fetch_assoc()['total'] ?? 0;
      $prescriptions = $conn->query("SELECT COUNT(*) as total FROM prescriptions")->fetch_assoc()['total'] ?? 0;
      ?>

      <div class="card">
        <i class="fa-solid fa-pills"></i>
        <h3><?= $total_medicines ?></h3>
        <p>Total Medicines</p>
      </div>
      <div class="card">
        <i class="fa-solid fa-users"></i>
        <h3><?= $total_customers ?></h3>
        <p>Total Customers</p>
      </div>
      <div class="card">
        <i class="fa-solid fa-receipt"></i>
        <h3><?= $todays_sales ?></h3>
        <p>Today's Sales</p>
      </div>
      <div class="card">
        <i class="fa-solid fa-file-prescription"></i>
        <h3><?= $prescriptions ?></h3>
        <p>Prescriptions Uploaded</p>
      </div>
    </div>
  </div>

  <script>
    function toggleMenu(el){
      const submenu = el.nextElementSibling;
      submenu.style.display = submenu.style.display === 'flex' ? 'none' : 'flex';
    }
  </script>
</body>
</html>
