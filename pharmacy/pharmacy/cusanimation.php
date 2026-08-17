
<?php 
include 'db.php';

php?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pharmacy Management</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
      background: #f4f6f9;
    }

    /* Sidebar */
    .sidebar {
      background-color: #1e1e2f;
      color: white;
      width: 260px;
      padding: 20px;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 25px;
    }
    .menu { margin-bottom: 20px; }
    .menu-title {
      font-weight: bold;
      margin: 10px 0 5px;
      font-size: 15px;
      color: #f0ad4e;
    }
    .submenu a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 8px 12px;
      border-radius: 4px;
      font-size: 14px;
      transition: background 0.3s;
    }
    .submenu a:hover { background-color: #444; }
    .sidebar a.logout {
      margin-top: auto;
      background-color: #b22222;
      text-align: center;
      padding: 10px;
      border-radius: 4px;
      text-decoration: none;
      color: white;
    }
    .sidebar a.logout:hover { background-color: #800000; }

    /* Main content */
    .main-content {
      flex-grow: 1;
      padding: 30px;
      overflow-y: auto;
      transition: all 0.5s ease;
    }

    .demo-box {
      background: white;
      padding: 20px;
      margin-bottom: 15px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .demo-box:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    h1 { margin-top: 0; }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Pharmacy</h2>

    <!-- Customer Management Submenu -->
    <div class="menu">
      <div class="menu-title">D. Customer Management</div>
      <div class="submenu">
        <a href="customers.php">Customer Details & Prescription Upload</a>
      </div>
    </div>

    <a href="logout.php" class="logout">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="content">
    <h1>Welcome to Pharmacy Management System</h1>
    <p>Select a menu option from the left to get started.</p>
  </div>

  <script>
    function showContent(page) {
      const contentDiv = document.getElementById("content");

      // Fade out current content
      contentDiv.style.opacity = 0;

      const xhr = new XMLHttpRequest();
      xhr.open("GET", page, true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          contentDiv.innerHTML = xhr.responseText;

          // Apply fade-in and card-style animation
          contentDiv.style.transition = "opacity 0.5s ease, transform 0.5s ease";
          contentDiv.style.transform = "translateY(10px)";
          setTimeout(() => {
            contentDiv.style.opacity = 1;
            contentDiv.style.transform = "translateY(0)";
          }, 50);

          // Style loaded forms and tables as cards
          const forms = contentDiv.querySelectorAll("form, .form-box, table");
          forms.forEach(el => {
            el.style.background = "#fff";
            el.style.padding = "20px";
            el.style.borderRadius = "12px";
            el.style.boxShadow = "0 4px 15px rgba(0,0,0,0.1)";
            el.style.transition = "transform 0.3s ease, box-shadow 0.3s ease";
            el.addEventListener("mouseover", () => {
              el.style.transform = "translateY(-3px)";
              el.style.boxShadow = "0 8px 20px rgba(0,0,0,0.15)";
            });
            el.addEventListener("mouseout", () => {
              el.style.transform = "translateY(0)";
              el.style.boxShadow = "0 4px 15px rgba(0,0,0,0.1)";
            });
          });
        } else {
          contentDiv.innerHTML = "<p style='color:red;text-align:center;'>Error loading page.</p>";
          contentDiv.style.opacity = 1;
        }
      };
      xhr.send();
    }
  </script>
</body>
</html>
