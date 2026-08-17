<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pharmacy Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }
    /* Navbar */
    .navbar {
      background: #1f2a38;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }
    .navbar-brand {
      font-weight: 700;
      letter-spacing: 0.5px;
      font-size: 22px;
    }
    .navbar-nav .nav-link {
      font-size: 16px;
      padding: 10px 15px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .navbar-nav .nav-link:hover {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 6px;
    }
    .navbar-nav .nav-link.text-danger:hover {
      color: #ff6b6b !important;
    }

   
  </style>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="dashboard.php"><i class="fa-solid fa-capsules"></i> Pharmacy Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="medicines.php"><i class="fa-solid fa-pills"></i> Medicines</a></li>
          <li class="nav-item"><a class="nav-link" href="customers.php"><i class="fa-solid fa-users"></i> Customers</a></li>
          <li class="nav-item"><a class="nav-link" href="sales_report.php"><i class="fa-solid fa-cart-shopping"></i> Sales</a></li>
          <li class="nav-item"><a class="nav-link" href="reports.php"><i class="fa-solid fa-file-lines"></i> Reports</a></li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  
   

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
