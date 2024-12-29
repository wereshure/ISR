<?php
include('../config/dbcon.php');
include('includes/header.php');
include('../middleware/adminMiddleware.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM orders WHERE id = $id";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
    } else {
        echo "Order not found";
        exit;
    }
} else {
    echo "ID missing from URL";
    exit;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Edit Order</h4>
            <form action="code.php" method="POST">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

                <div class="form-group mb-3">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" name="customer_name" value="<?= $order['customer_name'] ?>" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="customer_contact">Customer Contact</label>
                    <input type="text" name="customer_contact" value="<?= $order['customer_contact'] ?>" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="customer_address">Customer Address</label>
                    <textarea name="customer_address" class="form-control" required><?= $order['customer_address'] ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="qty">Quantity</label>
                    <input type="number" name="qty" value="<?= $order['qty'] ?>" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="selling_price">Selling Price</label>
                    <input type="text" name="selling_price" value="<?= $order['selling_price'] ?>" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="total_price">Total Price</label>
                    <input type="text" name="total_price" value="<?= $order['total_price'] ?>" class="form-control" required>
                </div>

                <button type="submit" name="update_order_btn" class="btn btn-primary">Update Order</button>
                <a href="order-management.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
