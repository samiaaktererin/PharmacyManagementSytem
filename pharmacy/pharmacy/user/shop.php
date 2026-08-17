<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Add to cart
if(isset($_GET['add'])){
    $id = $_GET['add'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header("Location: shop.php");
    exit();
}

// Search
$search = $_GET['q'] ?? '';
$query = "SELECT * FROM medicines WHERE name LIKE '%$search%' OR category LIKE '%$search%'";
$meds = $conn->query($query);

// Group by categories
$categories = [];
while($row = $meds->fetch_assoc()){
    $categories[$row['category']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Pharmacy Shop</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; margin:0; padding:0; }
        
        /* 🔹 Navbar */
        .navbar {
            background:#007bff;
            color:white;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:12px 30px;
            position: sticky;
            top:0;
            z-index:1000;
        }
        .navbar .logo {
            font-size:20px;
            font-weight:bold;
        }
        .navbar ul {
            list-style:none;
            margin:0;
            padding:0;
            display:flex;
            gap:20px;
        }
        .navbar ul li { display:inline; }
        .navbar ul li a {
            color:white;
            text-decoration:none;
            font-size:16px;
            transition:0.3s;
        }
        .navbar ul li a:hover {
            text-decoration:underline;
            color:#ffc107;
        }
        .cart-link {
            background:#ffc107;
            padding:6px 12px;
            border-radius:5px;
            color:#333 !important;
            font-weight:bold;
        }
        
        .container { width:90%; margin:20px auto; }
        form { margin-bottom:20px; text-align:center; }
        input[type=text] { padding:10px; width:250px; border:1px solid #ccc; border-radius:5px; }
        button { padding:10px 15px; border:none; background:#007bff; color:white; border-radius:5px; cursor:pointer; transition:0.3s; }
        button:hover { background:#0056b3; }
        .category { margin-top:30px; }
        .category h3 { background:#28a745; color:white; padding:10px; border-radius:5px; }
        .grid { display:grid; grid-template-columns: repeat(auto-fill,minmax(220px,1fr)); gap:20px; margin-top:15px; }
        .card { background:white; border-radius:8px; padding:15px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.1); transition:0.3s; }
        .card:hover { transform:translateY(-5px); box-shadow:0 4px 12px rgba(0,0,0,0.2); }
        .card img { width:120px; height:120px; object-fit:contain; margin-bottom:10px; }
        .card h4 { margin:10px 0; color:#333; font-size:18px; }
        .card p { margin:5px 0; font-size:14px; color:#555; }
        .price { font-size:18px; color:#007bff; font-weight:bold; margin:10px 0; }
    </style>
</head>
<body>

<!-- 🔹 Navbar -->
<div class="navbar">
    <div class="logo">💊 My Pharmacy</div>
    <ul>
        <li><a href="home.php">🏠 Home</a></li>
        <li><a href="shop.php">🛍 Shop</a></li>
        <li><a href="cart.php" class="cart-link">🛒 Cart (<?= array_sum($_SESSION['cart']) ?>)</a></li>
        <li><a href="orders.php">📦 My Orders</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
</div>

<div class="container">
    <form>
        <input type="text" name="q" placeholder="Search medicine or product..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <?php if(empty($categories)): ?>
        <p>No products found.</p>
    <?php else: ?>
        <?php foreach($categories as $cat => $items): ?>
        <div class="category">
            <h3><?= htmlspecialchars($cat) ?></h3>
            <div class="grid">
                <?php foreach($items as $m): ?>
                <div class="card">
                    <img src="images/<?= strtolower(str_replace(' ','_',$m['name'])) ?>.png" alt="<?= $m['name'] ?>">
                    <h4><?= $m['name'] ?></h4>
                    <p>Stock: <?= $m['quantity'] ?></p>
                    <p class="price">৳ <?= number_format($m['selling_price'],2) ?></p>
                    <a href="shop.php?add=<?= $m['id'] ?>">
                        <button>Add to Cart</button>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
