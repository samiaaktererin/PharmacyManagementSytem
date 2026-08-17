<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Pharmacy - Home</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f8f9fa; }

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
        .navbar .logo { font-size:22px; font-weight:bold; }
        .navbar ul { list-style:none; margin:0; padding:0; display:flex; gap:20px; }
        .navbar ul li { display:inline; }
        .navbar ul li a {
            color:white;
            text-decoration:none;
            font-size:16px;
            transition:0.3s;
        }
        .navbar ul li a:hover { text-decoration:underline; color:#ffc107; }
        .cart-link {
            background:#ffc107; padding:6px 12px; border-radius:5px;
            color:#333 !important; font-weight:bold;
        }

        .hero {
            background:
                linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                url('images/pharmacy1.jpg') no-repeat center center / cover;
            height:350px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:white;
            text-align:center;
            flex-direction:column;
        }
        .hero h1 { font-size:40px; margin:0; }
        .hero p { font-size:18px; margin:10px 0; }
        .hero a {
            background:#ffc107; color:#333; padding:12px 20px;
            border-radius:6px; font-weight:bold; text-decoration:none;
            margin-top:15px; transition:background 0.3s;
        }
        .hero a:hover { background:#ff9800; }

        /* 🔹 Features */
        .features {
            display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
            gap:20px; margin:40px auto; width:90%;
        }
        .feature-box {
            background:white; border-radius:8px; padding:20px; text-align:center;
            box-shadow:0 2px 6px rgba(0,0,0,0.1);
        }
        .feature-box h3 { margin:10px 0; color:#007bff; }

        /* 🔹 Categories */
        .categories { width:90%; margin:40px auto; }
        .categories h2 { text-align:center; margin-bottom:20px; }
        .grid {
            display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
            gap:20px;
        }
        .card {
            background:white; padding:15px; border-radius:8px;
            text-align:center; box-shadow:0 2px 6px rgba(0,0,0,0.1);
            transition:0.3s;
        }
        .card:hover { transform:translateY(-5px); }
        .card img { width:120px; height:120px; object-fit:contain; margin-bottom:10px; }

        /* 🔹 Footer */
        footer {
            background:#343a40; color:white; text-align:center;
            padding:20px; margin-top:40px;
        }
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

<!-- 🔹 Hero Section -->
<div class="hero">
    <h1>Welcome to My Online Pharmacy</h1>
    <p>Genuine Medicines | Fast Delivery | Doctor Consultation</p>
    <a href="shop.php">🛒 Shop Now</a>
</div>

<!-- 🔹 Features -->
<div class="features">
    <div class="feature-box">
        <h3>💊 100% Genuine Medicines</h3>
        <p>We provide only verified medicines directly from trusted suppliers.</p>
    </div>
    <div class="feature-box">
        <h3>🚚 Fast Home Delivery</h3>
        <p>Same-day delivery inside city and 24-hour nationwide service.</p>
    </div>
    <div class="feature-box">
        <h3>👨‍⚕️ Doctor Consultation</h3>
        <p>Free online doctor consultation with every first order.</p>
    </div>
    <div class="feature-box">
        <h3>🏥 Licensed Pharmacy</h3>
        <p>Our pharmacy is certified and follows all healthcare guidelines.</p>
    </div>
</div>

<!-- 🔹 Popular Categories -->
<div class="categories">
    <h2>Popular Categories</h2>
    <div class="grid">
        <div class="card">
            <img src="images/medicine.png" alt="Medicines">
            <h4>Medicines</h4>
        </div>
        <div class="card">
            <img src="images/cosmetic.png" alt="Cosmetics">
            <h4>Cosmetics</h4>
        </div>
        <div class="card">
            <img src="images/equipment.png" alt="Medical Equipment">
            <h4>Medical Equipment</h4>
        </div>
        <div class="card">
            <img src="images/grocery.png" alt="Grocery">
            <h4>Grocery & Nutrition</h4>
        </div>
    </div>
</div>

<!-- 🔹 Footer -->
<footer>
    <p>📞 Helpline: +880 1234 567890 | ✉️ Email: support@mypharmacy.com</p>
    <p>© <?= date("Y") ?> My Pharmacy. All rights reserved.</p>
</footer>

</body>
</html>
