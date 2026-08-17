<?php
//session_start();
require_once 'db.php'; // Database connection

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    // CSRF Validation
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid form submission. Please refresh and try again.';
    } else {
        $name    = trim($_POST['name'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        // Validation
        if ($name === '' || $phone === '' || $address === '') {
            $error = 'All fields are required.';
        } elseif (!preg_match('/^\+?\d{10,15}$/', $phone)) {
            $error = 'Phone must be 10–15 digits, optional leading +.';
        } elseif (strlen($address) > 255) {
            $error = 'Address cannot exceed 255 characters.';
        }

        // Insert into DB
        if ($error === '') {
            $stmt = $conn->prepare("INSERT INTO customers (name, phone, address) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param('sss', $name, $phone, $address);
                if ($stmt->execute()) {
                    $success = '✅ Customer added successfully!';
                } else {
                    $error = 'Database error: ' . htmlspecialchars($stmt->error);
                }
                $stmt->close();
            } else {
                $error = 'Database error: Failed to prepare statement.';
            }
        }
    }
}

// Fetch customers
$customers = [];
$query = "SELECT id, name, phone, address, created_at FROM customers ORDER BY created_at DESC";
if ($result = $conn->query($query)) {
    $customers = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}
?>
<?php include 'header.php'; ?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f3f4f6;
        margin: 0;
        padding: 0;
        color: #333;
    }
    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    h2 {
        margin-bottom: 10px;
        font-weight: 600;
        color: #111;
    }
    p.description {
        margin-bottom: 20px;
        color: #555;
    }
    .message-success, .message-error {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-weight: 500;
        font-size: 14px;
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
    .grid-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-top: 20px;
    }
    .sales-report, .add-customer {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    .sales-report:hover, .add-customer:hover {
        transform: translateY(-2px);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 15px;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
    }
    table thead {
        background: #2563eb;
        color: #fff;
        font-weight: bold;
    }
    table th, table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }
    table tr:hover {
        background: #f9fafb;
    }
    form {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    form label {
        font-weight: 500;
        color: #333;
    }
    form input, form textarea {
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 15px;
        width: 100%;
        transition: border 0.3s;
    }
    form input:focus, form textarea:focus {
        border-color: #2563eb;
        outline: none;
    }
    form button {
        background: #2563eb;
        color: #fff;
        padding: 12px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }
    form button:hover {
        background: #1e40af;
    }
    footer {
        color: #000 !important;
    }
    @media (max-width: 900px) {
        .grid-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <h2>📊 Customer Management Dashboard</h2>
    <p class="description">View customer sales records and add new customers with ease.</p>

    <?php if ($success): ?>
        <div class="message-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="message-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="grid-container">
        <!-- Customer List -->
        <div class="sales-report">
            <h3>📜 Customer Sales Report</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($customers)): ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">No customers found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($customers as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= htmlspecialchars($c['name']) ?></td>
                                <td><?= htmlspecialchars($c['phone']) ?></td>
                                <td><?= htmlspecialchars($c['address']) ?></td>
                                <td><?= $c['created_at'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Customer -->
        <div class="add-customer">
            <h3>📝 Add New Customer</h3>
            <form method="post" action="customers.php">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter full name">

                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" pattern="\+?\d{10,15}" title="10–15 digits, may start with +" required placeholder="+8801XXXXXXXXX">

                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" maxlength="255" required placeholder="Enter address"></textarea>

                <button type="submit" name="add">💾 Save Customer</button>
            </form>
        </div>
    </div>
</div>



