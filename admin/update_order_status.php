<?php
include('../middleware/adminMiddleware.php');

if (isset($_POST['update_status'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $query = "UPDATE supplier_orders SET status = 1 WHERE id = '$order_id'";

    if (mysqli_query($con, $query)) {
        $_SESSION['message'] = "Order status updated successfully.";
        header('Location: supplier-order-management.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to update order status.";
        header('Location: supplier-order-management.php');
        exit(0);
    }
}
