<?php
session_start();
include 'db.php';

$error = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($res->num_rows>0){
        $user = $res->fetch_assoc();
        if(password_verify($pass, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: home.php");
            exit();
        } else {
            $error = "❌ Wrong password.";
        }
    } else {
        $error = "❌ No user found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pharmacy Login</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      display: flex;
      height: 100vh;
    }
    .left-panel {
  flex: 1;
  background: url('pharmacy-bg.jpg') no-repeat center center/cover;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 60px;
  position: relative;
}
.left-panel::before {
  content: "";
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.7); /* dark overlay */
}
.left-panel .overlay {
  position: relative;
  z-index: 2;
  text-align: left;
  max-width: 450px;
}
.left-panel h1 {
  font-size: 42px;
  margin-bottom: 20px;
  color: #f8f9fa;
}
.left-panel p {
  font-size: 18px;
  line-height: 1.6;
  margin-bottom: 15px;
}
.left-panel .tagline {
  margin-top: 20px;
  font-size: 20px;
  font-weight: bold;
  color: #00ff99;
  font-style: italic;
}

    .right-panel {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #fff;
      box-shadow: -3px 0 10px rgba(0,0,0,0.1);
    }
    .login-box {
      width: 100%;
      max-width: 350px;
      padding: 30px;
      border-radius: 10px;
      background: #fff;
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #1e1e2f;
    }
    .login-box input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .login-box button {
      width: 100%;
      padding: 12px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }
    .login-box button:hover {
      background: #218838;
    }
    .links {
      margin-top: 10px;
      text-align: center;
    }
    .links a {
      color: #007bff;
      text-decoration: none;
    }
    .links a:hover {
      text-decoration: underline;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
<div class="left-panel">
  <div class="overlay">
    <h1>💊 Your Trusted Online Pharmacy</h1>
    <p>
      ✅ 100% Genuine Medicines<br>
      🏥 Licensed & Verified Pharmacists<br>
      🚚 Express Home Delivery (24/7)<br>
      👨‍⚕️ Free Doctor Consultation<br>
      📦 Easy Order & Hassle-free Returns<br>
      💳 Secure Payment Options
    </p>
    <p class="tagline">"Health First, Always!"</p>
  </div>
</div>

<div class="right-panel">
  <div class="login-box">
    <h2>Login</h2>
    <?php if($error): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <div class="links">
      <a href="register.php">Create Account</a> | 
      <a href="forgot_password.php">Forgot Password?</a>
    </div>
  </div>
</div>

</body>
</html>
