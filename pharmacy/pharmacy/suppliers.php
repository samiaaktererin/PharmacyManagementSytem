<?php include 'header.php'; ?>
<h2>Sales Report</h2>
<p>Here you can see all sales transactions.</p>
<?php include 'footer.php'; ?>


<?php
include 'db.php'; // Database connection

// ---------- ADD Supplier ----------
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $company_group = $_POST['company_group'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "INSERT INTO suppliers (name, company_group, contact, email, address) 
            VALUES ('$name','$company_group','$contact','$email','$address')";
    $conn->query($sql);
    header("Location: suppliers.php");
    exit();
}

// ---------- DELETE Supplier ----------
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM suppliers WHERE id=$id");
    header("Location: suppliers.php");
    exit();
}

// ---------- UPDATE Supplier ----------
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $company_group = $_POST['company_group'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "UPDATE suppliers 
            SET name='$name', company_group='$company_group', contact='$contact', email='$email', address='$address' 
            WHERE id=$id";
    $conn->query($sql);
    header("Location: suppliers.php");
    exit();
}

// Fetch all suppliers
$result = $conn->query("SELECT * FROM suppliers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supplier Management</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #007bff; color: white; }
        input, button { padding: 6px; margin: 4px; }
        .form-box { background: #f9f9f9; padding: 15px; border-radius: 6px; width: 550px; }
        .btn-del { background: red; color: white; padding: 5px 10px; border: none; cursor: pointer; }
        .btn-edit { background: orange; color: white; padding: 5px 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>

<h2>Supplier Management</h2>

<!-- Add/Edit Supplier Form -->
<div class="form-box">
    <form method="post">
        <input type="hidden" name="id" id="id">
        <input type="text" name="name" id="name" placeholder="Supplier Name" required><br>
        <input type="text" name="company_group" id="company_group" placeholder="Company Group"><br>
        <input type="text" name="contact" id="contact" placeholder="Contact Number"><br>
        <input type="email" name="email" id="email" placeholder="Email"><br>
        <input type="text" name="address" id="address" placeholder="Address"><br>
        <button type="submit" name="add" id="addBtn">Add Supplier</button>
        <button type="submit" name="update" id="updateBtn" style="display:none;">Update Supplier</button>
    </form>
</div>

<!-- Supplier List -->
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Company Group</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['company_group'] ?></td>
        <td><?= $row['contact'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['address'] ?></td>
        <td>
            <button class="btn-edit" onclick="editSupplier('<?= $row['id'] ?>','<?= $row['name'] ?>','<?= $row['company_group'] ?>','<?= $row['contact'] ?>','<?= $row['email'] ?>','<?= $row['address'] ?>')">Edit</button>
            <a href="suppliers.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">
                <button class="btn-del">Delete</button>
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

<script>
function editSupplier(id, name, company_group, contact, email, address){
    document.getElementById("id").value = id;
    document.getElementById("name").value = name;
    document.getElementById("company_group").value = company_group;
    document.getElementById("contact").value = contact;
    document.getElementById("email").value = email;
    document.getElementById("address").value = address;

    document.getElementById("addBtn").style.display = "none";
    document.getElementById("updateBtn").style.display = "inline-block";
}
</script>

</body>
</html>
