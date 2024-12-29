<?php 
include('includes/header.php');
include('../middleware/adminMiddleware.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Category Selection -->
                            <div class="col-md-6">
                                <label class="mb-0">Select Category</label>
                                <select name="category_id" class="form-select mb-2" required>
                                   <option value="" selected disabled>Select Category</option>
                                    <?php
                                        $categories = getAll("categories");
                                        if(mysqli_num_rows($categories) > 0)
                                        {
                                            foreach ($categories as $item) {
                                                echo "<option value='{$item['id']}'>{$item['name']}</option>";
                                            }
                                        }
                                        else
                                        {
                                            echo "<option disabled>No category available</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <!-- Supplier Selection -->
                            <div class="col-md-6">
                                <label class="mb-0">Select Supplier</label>
                                <select name="supplier_id" class="form-select" required>
                                   <option value="" selected disabled>Select Supplier</option>
                                    <?php
                                        $suppliers = getAll("suppliers");
                                        if(mysqli_num_rows($suppliers) > 0)
                                        {
                                            foreach ($suppliers as $item) {
                                                echo "<option value='{$item['id']}'>{$item['name']}</option>";
                                            }
                                        }
                                        else
                                        {
                                            echo "<option disabled>No supplier available</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <!-- Product Name -->
                            <div class="col-md-6">
                                <label class="mb-0">Product Name</label>
                                <input type="text" name="name" placeholder="Enter Product Name" class="form-control" required>
                            </div>

                            <!-- Brand Name -->
                            <div class="col-md-6">
                                <label class="mb-0">Brand</label>
                                <input type="text" name="brand" placeholder="Enter Brand" class="form-control" required>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label class="mb-0">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description" class="form-control" required></textarea>
                            </div>

                            <!-- Original Price -->
                            <div class="col-md-6">
                                <label class="mb-0">Original Price</label>
                                <input type="number" step="0.01" name="original_price" placeholder="Enter Original Price" class="form-control" required>
                            </div>

                            <!-- Selling Price -->
                            <div class="col-md-6">
                                <label class="mb-0">Selling Price</label>
                                <input type="number" step="0.01" name="selling_price" placeholder="Enter Selling Price" class="form-control" required>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-12">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-6">
                                <label class="mb-0">Quantity</label>
                                <input type="number" name="qty" placeholder="Enter Quantity" class="form-control" required>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary" name="add_product_btn">Save Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
