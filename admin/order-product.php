<?php 
include('../middleware/adminMiddleware.php'); // Ensure admin authentication
include('includes/header.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product = getByID("products", $product_id);

    if (mysqli_num_rows($product) > 0) {
        $product_data = mysqli_fetch_array($product);
    } else {
        $_SESSION['message'] = "Product not found!";
        header("Location: products.php");
        exit();
    }
} else {
    $_SESSION['message'] = "No Product ID provided!";
    header("Location: products.php");
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Order Product
                    <a href="products.php" class="btn btn-primary float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product_data['id']; ?>">
                        <input type="hidden" name="original_qty" value="<?= $product_data['qty']; ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" class="form-control" value="<?= $product_data['name']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="available_qty">Available Quantity</label>
                                    <input type="number" class="form-control" value="<?= $product_data['qty']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_qty">Quantity to Order</label>
                                    <input type="number" name="order_qty" class="form-control" placeholder="Enter quantity" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="original_price">Original Price</label>
                                    <input type="text" class="form-control" value="<?= $product_data['original_price']; ?>" disabled>
                                    <input type="hidden" name="original_price" value="<?= $product_data['original_price']; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selling_price">Selling Price</label>
                                    <input type="number" step="0.01" name="selling_price" class="form-control" placeholder="Enter selling price" required>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control" placeholder="Enter customer name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_contact">Customer Contact</label>
                                    <input type="text" name="customer_contact" class="form-control" placeholder="Enter customer contact" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Customer Address</label>
                                    <textarea name="customer_address" class="form-control" placeholder="Enter customer address" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" name="place_order_btn" class="btn btn-success">Place Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
