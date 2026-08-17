<?php include 'header.php'; ?>
<?php include 'db.php'; ?>

<?php
// Fetch medicines with stock
$medicines = $conn->query("SELECT * FROM medicines WHERE quantity > 0 ORDER BY name ASC");
?>

<div class="container mt-5">
    <!-- Page Header -->
    <!-- <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Sales Report</h2>
        <p class="text-muted">Here you can see all sales transactions.</p>
    </div> -->

    <!-- Sell Medicine Section -->
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-success mb-4">💊 Sell Medicine (Invoice)</h3>

        <form method="POST" action="process_sale.php">
            <!-- Customer Name -->
            <div class="mb-3">
                <label class="form-label"><b>Customer Name:</b></label>
                <input type="text" name="customer_name" class="form-control" placeholder="Enter customer name" required>
            </div>

            <!-- Medicine Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Select</th>
                            <th>Medicine Name</th>
                            <th>Available Stock</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $medicines->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="medicine_id[]" value="<?= $row['id'] ?>">
                            </td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td class="text-center"><?= $row['quantity'] ?></td>
                            <td>
                                <input type="number" 
                                       name="price[<?= $row['id'] ?>]" 
                                       class="form-control"
                                       step="0.01" 
                                       min="0" 
                                       value="<?= isset($row['selling_price']) ? $row['selling_price'] : 0 ?>">
                            </td>
                            <td>
                                <input type="number" 
                                       name="quantity[<?= $row['id'] ?>]" 
                                       class="form-control"
                                       min="1" 
                                       max="<?= $row['quantity'] ?>">
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tax Input -->
            <div class="mb-3">
                <label class="form-label"><b>Tax (%):</b></label>
                <input type="number" name="tax_rate" value="5" step="0.01" class="form-control">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    Generate Invoice
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
