<?php
$host = "localhost";
$user = "root";   // default XAMPP user
$pass = "";       // default XAMPP password (keep blank if none)
$db   = "pharmacy_db"; // your database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}
$conn->query("SET time_zone = '+06:00'");

// echo "✅ Database Connected Successfully!";
?>
