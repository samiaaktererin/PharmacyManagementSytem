<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "pharmacy_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$success = '';
$error = '';

if (isset($_POST['upload'])) {
    $customer_name = trim($_POST['customer_name']);
    $customer_id   = intval($_POST['customer_id']);

    // If no ID given, try to create/find by name
    if ($customer_id === 0 && !empty($customer_name)) {
        $stmt = $conn->prepare("SELECT id FROM customers WHERE name = ? LIMIT 1");
        $stmt->bind_param('s', $customer_name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $customer_id = $row['id'];
        } else {
            $stmt_insert = $conn->prepare("INSERT INTO customers (name) VALUES (?)");
            $stmt_insert->bind_param('s', $customer_name);
            $stmt_insert->execute();
            $customer_id = $stmt_insert->insert_id;
            $stmt_insert->close();
        }
        $stmt->close();
    }

    if ($customer_id === 0) {
        $error = "❌ Please enter a valid Customer ID or Name.";
    } else {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fileName = basename($_FILES["prescription"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . preg_replace('/[^A-Za-z0-9_\.-]/', '_', $fileName);
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg','jpeg','png','pdf'];

        if (!in_array($fileType, $allowedTypes)) {
            $error = "❌ Only JPG, PNG, PDF files are allowed!";
        } elseif (!move_uploaded_file($_FILES["prescription"]["tmp_name"], $targetFilePath)) {
            $error = "❌ File upload failed!";
        } else {
            $stmt_upload = $conn->prepare("INSERT INTO prescriptions (customer_id, file_name, file_path) VALUES (?, ?, ?)");
            $stmt_upload->bind_param('iss', $customer_id, $fileName, $targetFilePath);
            if ($stmt_upload->execute()) {
                $success = "✅ Prescription uploaded successfully!";
            } else {
                $error = "❌ Database error: " . $conn->error;
            }
            $stmt_upload->close();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload Prescription</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f3f4f6;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .upload-box {
        background: #fff;
        padding: 30px 35px;
        border-radius: 12px;
        box-shadow: 0 6px 25px rgba(0,0,0,0.1);
        width: 450px;
    }
    h2 {
        margin-bottom: 20px;
        font-weight: 600;
        color: #111;
        text-align: center;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    label {
        font-weight: 500;
        color: #333;
    }
    input[type="text"],
    input[type="number"],
    input[type="file"] {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 15px;
        transition: border 0.3s;
        width: 100%;
    }
    input:focus {
        border-color: #2563eb;
        outline: none;
    }
    button {
        padding: 12px;
        background: #2563eb;
        color: #fff;
        font-size: 16px;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }
    button:hover {
        background: #1e40af;
    }
    .message {
        padding: 12px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 15px;
        text-align: center;
    }
    .message-success {
        background: #e6ffed;
        color: #22863a;
        border: 1px solid #b6f2c1;
    }
    .message-error {
        background: #ffecec;
        color: #d93025;
        border: 1px solid #f5b5b5;
    }
    small {
        font-size: 12px;
        color: #666;
    }
</style>
</head>
<body>
<div class="upload-box">
    <h2>📄 Upload Prescription</h2>

    <?php if($success): ?>
        <div class="message message-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="message message-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="prescription_upload.php" method="post" enctype="multipart/form-data">
        <label>Customer ID <small>(leave blank if new)</small></label>
        <input type="number" name="customer_id" placeholder="Enter customer ID">

        <label>Customer Name <small>(required if ID is blank)</small></label>
        <input type="text" name="customer_name" placeholder="Enter customer name">

        <label>Prescription File</label>
        <input type="file" name="prescription" accept=".jpg,.jpeg,.png,.pdf" required>

        <button type="submit" name="upload">💾 Upload</button>
    </form>
</div>
</body>
</html>
