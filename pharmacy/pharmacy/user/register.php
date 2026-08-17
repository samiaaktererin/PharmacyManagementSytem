<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(!empty($name) && !empty($email) && !empty($password)){
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $pass);

        if($stmt->execute()){
            echo "<div class='alert alert-success text-center mt-3'>✅ Registered Successfully. <a href='login.php' class='alert-link'>Login</a></div>";
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>❌ Registration failed. Try again.</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-warning text-center mt-3'>⚠️ Please fill in all fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .register-container {
      max-width: 400px;
      margin: 60px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .register-container h3 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .btn-custom {
      background: #007bff;
      color: #fff;
      font-weight: bold;
      border-radius: 8px;
    }
    .btn-custom:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

<div class="register-container">
  <h3>Create an Account</h3>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Enter a strong password" required>
    </div>
    <button type="submit" class="btn btn-custom w-100">Register</button>
  </form>
  <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>
