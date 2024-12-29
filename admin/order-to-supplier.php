<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');

// Fetch suppliers and products
$suppliers = getAll("suppliers");
$products = getAll("products");
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Place Order to Supplier</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <!-- Select Supplier -->
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <select name="supplier_id" class="form-control" required>
                                <option value="" disabled selected>Select Supplier</option>
                                <?php
                                if (mysqli_num_rows($suppliers) > 0) {
                                    foreach ($suppliers as $supplier) {
                                        echo "<option value='{$supplier['id']}'>{$supplier['name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Select Product -->
                        <div class="form-group">
                            <label for="product">Product</label>
                            <select name="product_id" class="form-control" id="product-select" required>
                                <option value="" disabled selected>Select Product</option>
                                <?php
                                if (mysqli_num_rows($products) > 0) {
                                    foreach ($products as $product) {
                                        echo "<option value='{$product['id']}' data-price='{$product['selling_price']}'>{$product['name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Display Price -->
                        <div class="form-group">
                            <label for="price">Price per Unit</label>
                            <input type="number" name="price" id="price" class="form-control" readonly>
                        </div>

                        <!-- Input Quantity -->
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input type="number" name="qty" id="qty" class="form-control" required>
                        </div>

                        <!-- Display Total Price -->
                        <div class="form-group">
                            <label for="total_price">Total Price</label>
                            <input type="number" name="total_price" id="total_price" class="form-control" readonly>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" name="place_supplier_order_btn" class="btn btn-primary">Place Order</button>
                        <a href="supplier.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('product-select').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    document.getElementById('price').value = price;

    // Update total price if quantity is already entered
    const qty = document.getElementById('qty').value;
    if (qty) {
        document.getElementById('total_price').value = qty * price;
    }
});

document.getElementById('qty').addEventListener('input', function() {
    const price = document.getElementById('price').value;
    const qty = this.value;
    if (price) {
        document.getElementById('total_price').value = qty * price;
    }
});
</script>

<?php include('includes/footer.php'); ?>
