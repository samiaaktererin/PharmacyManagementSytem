<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pharmacy Search</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
/* Reset & Base */
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Arial, sans-serif; }
body { background: #f4f7fc; color: #333; min-height: 100vh; display: flex; flex-direction: column; }

/* Header */
header {
  display: flex; justify-content: space-between; align-items: center;
  padding: 20px 50px; background: #1e1e2f; color: #fff;
  position: sticky; top:0; z-index: 100; box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
header .logo { font-size: 24px; font-weight: bold; color: #f0ad4e; }
header nav a { color: #fff; text-decoration: none; margin-left: 20px; font-size: 16px; transition: 0.3s; }
header nav a:hover { color: #ffc107; }

/* Hero Section */
.hero {
  text-align: center;
  padding: 80px 20px 40px 20px;
}
.hero h1 { font-size: 40px; color: #1e1e2f; margin-bottom: 15px; }
.hero p { font-size: 18px; color: #666; margin-bottom: 30px; max-width: 600px; margin-left:auto; margin-right:auto; }
.hero .search-container {
  display: flex; justify-content: center; gap: 10px; max-width: 600px; margin: 0 auto;
}
.hero .search-container input {
  flex: 1; padding: 12px 15px; border-radius: 8px 0 0 8px; border: 1px solid #ccc; font-size: 16px;
}
.hero .search-container button {
  padding: 12px 20px; border: none; background: #4e73df; color: #fff; border-radius: 0 8px 8px 0;
  cursor: pointer; font-size: 16px; transition: 0.3s;
}
.hero .search-container button:hover { background: #1cc88a; }

/* Results */
.results-container { max-width: 1000px; margin: 40px auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px,1fr)); gap: 20px; }
.card {
  background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.15); }
.card h3 { font-size: 20px; color: #4e73df; margin-bottom: 10px; }
.card p { font-size: 16px; color: #555; margin: 5px 0; }
.card .price { font-weight: bold; color: #1cc88a; margin-top: 10px; }

/* No results - vertically centered */
.no-results-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 50vh; /* center vertically */
  flex-direction: column;
  text-align: center;
}
.no-results-container p {
  font-size: 22px;
  color: #dc3545;
  margin-bottom: 20px;
}

/* Footer */
footer { background: #1e1e2f; color: #fff; text-align: center; padding: 30px 50px; margin-top: auto; opacity: 0.85; }

@media (max-width: 480px) {
  .hero .search-container { flex-direction: column; }
  .hero .search-container input, .hero .search-container button { width: 100%; border-radius: 8px; }
  header { flex-direction: column; gap: 15px; }
  .hero h1 { font-size: 32px; }
  .hero p { font-size: 16px; }
}
</style>
</head>
<body>

<!-- Header -->
<header>
  <div class="logo"><i class="fa-solid fa-capsules"></i> Pharmacy</div>
  <nav>
    <a href="user/login.php"><i class="fa-solid fa-user"></i> Customer Login</a>
    <a href="admin/login.php"><i class="fa-solid fa-user-shield"></i> Admin Login</a>
  </nav>
</header>

<!-- Hero Section -->
<section class="hero">
  <h1>Find Your Medicine</h1>
  <p>Search and browse medicines, check stock, and view prices easily.</p>
  <div class="search-container">
    <form method="GET" action="">
      <input type="text" name="q" placeholder="Search medicine..." required value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    </form>
  </div>
</section>

<!-- Results -->
<?php
if (isset($_GET['q'])) {
    $q = trim($_GET['q']);
    if (empty($q)) {
        echo "<div class='no-results-container'><p>Please enter a search term.</p></div>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM medicines WHERE name LIKE CONCAT('%', ?, '%')");
        $stmt->bind_param("s", $q);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='results-container'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>
                        <h3>".htmlspecialchars($row['name'])."</h3>
                        <p>Generic: ".htmlspecialchars($row['generic_name'])."</p>
                        <p>Stock: ".htmlspecialchars($row['quantity'])."</p>
                        <p class='price'>Price: ৳".htmlspecialchars($row['selling_price'])."</p>
                      </div>";
            }
            echo "</div>";
        } else {
            $stmt2 = $conn->prepare("SELECT generic_name FROM medicines WHERE name LIKE CONCAT('%', ?, '%') LIMIT 1");
            $stmt2->bind_param("s", $q);
            $stmt2->execute();
            $generic_res = $stmt2->get_result();

            if ($generic_res->num_rows > 0) {
                $gen = $generic_res->fetch_assoc()['generic_name'];
                echo "<div class='no-results-container'>
                        <p>No exact match found. Showing alternatives for '".htmlspecialchars($gen)."'.</p>
                      </div>";

                $stmt3 = $conn->prepare("SELECT * FROM medicines WHERE generic_name = ?");
                $stmt3->bind_param("s", $gen);
                $stmt3->execute();
                $alt_res = $stmt3->get_result();

                echo "<div class='results-container'>";
                while ($row = $alt_res->fetch_assoc()) {
                    echo "<div class='card'>
                            <h3>".htmlspecialchars($row['name'])."</h3>
                            <p>Stock: ".htmlspecialchars($row['quantity'])."</p>
                            <p class='price'>Price: ৳".htmlspecialchars($row['selling_price'])."</p>
                          </div>";
                }
                echo "</div>";
                $stmt3->close();
            } else {
                echo "<div class='no-results-container'><p>No medicines or alternatives found for '".htmlspecialchars($q)."'.</p></div>";
            }
            $stmt2->close();
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!-- Footer -->
<footer>
  &copy; 2025 Pharmacy. All rights reserved.
</footer>

</body>
</html>
