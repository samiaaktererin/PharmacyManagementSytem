<?php include 'header.php'; ?>
<?php
include "db.php";

// ---------- ADD Medicine ----------
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $generic = $_POST['generic'];
    $batch = $_POST['batch'];
    $qty = $_POST['qty'];
    $expiry = $_POST['expiry'];
    $price = $_POST['price'];

    $sql = "INSERT INTO medicines (name, generic_name, batch_no, quantity, expiry_date, selling_price) 
            VALUES ('$name','$generic','$batch','$qty','$expiry','$price')";
    $conn->query($sql);
    header("Location: medicines.php");
    exit();
}

// ---------- DELETE Medicine ----------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM medicines WHERE id=$id";
    $conn->query($sql);
    header("Location: medicines.php");
    exit();
}

// ---------- UPDATE Medicine ----------
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $generic = $_POST['generic'];
    $batch = $_POST['batch'];
    $qty = $_POST['qty'];
    $expiry = $_POST['expiry'];
    $price = $_POST['price'];

    $sql = "UPDATE medicines 
            SET name='$name', generic_name='$generic', batch_no='$batch', quantity='$qty', expiry_date='$expiry', selling_price='$price' 
            WHERE id=$id";
    $conn->query($sql);
    header("Location: medicines.php");
    exit();
}

// ---------- Fetch All Medicines ----------
$result = $conn->query("SELECT * FROM medicines ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medicines Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            background: #007bff;
            color: white;
            padding: 15px;
            margin: 0;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        .form-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .form-box input, .form-box button {
            width: 100%;
            padding: 10px;
            margin: 6px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .form-box button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        .form-box button:hover {
            background: #0056b3;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border-bottom: 1px solid #eee;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        .btn-edit {
            background: #ff9800;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-del {
            background: #f44336;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-edit:hover { background: #e68900; }
        .btn-del:hover { background: #d32f2f; }
    </style>
</head>
<body>

<h2>💊 Medicine Management</h2>

<div class="container">
    <!-- Add Medicine Form -->
    <div class="form-box">
        <form method="post">
            <input type="hidden" name="id" id="id">
            <input type="text" name="name" id="name" placeholder="Medicine Name" required>
            <input type="text" name="generic" id="generic" placeholder="Generic Name" required>
            <input type="text" name="batch" id="batch" placeholder="Batch No" required>
            <input type="number" name="qty" id="qty" placeholder="Quantity" required>
            <input type="date" name="expiry" id="expiry" required>
            <input type="number" step="0.01" name="price" id="price" placeholder="Selling Price" required>
            <button type="submit" name="add" id="addBtn">➕ Add Medicine</button>
            <button type="submit" name="update" id="updateBtn" style="display:none;">✏️ Update Medicine</button>
        </form>
    </div>
<h1>Medicine list</h1>
    <!-- Medicine List -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Generic</th>
            <th>Batch No</th>
            <th>Quantity</th>
            <th>Expiry</th>
            <th>Selling Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['generic_name'] ?></td>
            <td><?= $row['batch_no'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['expiry_date'] ?></td>
            <td><?= $row['selling_price'] ?></td>
            <td>
                <button class="btn-edit" onclick="editMedicine(<?= $row['id'] ?>, '<?= $row['name'] ?>', '<?= $row['generic_name'] ?>', '<?= $row['batch_no'] ?>', <?= $row['quantity'] ?>, '<?= $row['expiry_date'] ?>', <?= $row['selling_price'] ?>)">Edit</button>
                <a href="medicines.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">
                    <button class="btn-del">Delete</button>
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<script>
function editMedicine(id, name, generic, batch, qty, expiry, price) {
    document.getElementById("id").value = id;
    document.getElementById("name").value = name;
    document.getElementById("generic").value = generic;
    document.getElementById("batch").value = batch;
    document.getElementById("qty").value = qty;
    document.getElementById("expiry").value = expiry;
    document.getElementById("price").value = price;

    document.getElementById("addBtn").style.display = "none";
    document.getElementById("updateBtn").style.display = "inline-block";
}
</script>

</body>
</html>
