<?php 
session_start(); // Start the session

include('../middleware/adminMiddleware.php');
include('includes/header.php');
include('dashboard.php'); // Including the PHP file that handles the logic
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-lg-7 position-relative z-index-2">
                    <div class="card card-plain mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <!-- Low Stock Alerts -->
                                <div class="col-lg-6">
                                    <div class="alert alert-warning">
                                        <h5>Low Stock Alerts</h5>
                                        <p><?= $lowStockCount; ?> products with low stock.</p>
                                        <ul>
                                            <?php
                                                if(!empty($lowStockProducts)) {
                                                    foreach($lowStockProducts as $product) {
                                                        echo "<li>" . $product['name'] . " (Brand: " . $product['brand'] . ", Qty: " . $product['qty'] . ")</li>";
                                                    }
                                                } else {
                                                    echo "<li>No products with low stock.</li>";
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Total Products in Stock -->
                                <div class="col-lg-6">
                                    <div class="alert alert-info">
                                        <h5>Total Products in Stock</h5>
                                        <p><?= $totalStock; ?> items in stock.</p>
                                    </div>
                                </div>

                                <!-- Total Revenue -->
                                <div class="col-lg-6">
                                    <div class="alert alert-success">
                                        <h5>Total Revenue</h5>
                                        <p>RM<?= number_format($totalRevenue, 2); ?> revenue generated.</p>
                                    </div>
                                </div>

                                <!-- Daily Sales -->
                                <div class="col-lg-6">
                                    <div class="alert alert-primary">
                                        <h5>Daily Sales</h5>
                                        <p><?= $dailySales['daily_sales']; ?> sales today, RM<?= number_format($dailySales['daily_revenue'], 2); ?> revenue.</p>
                                    </div>
                                </div>

                                <!-- Weekly Sales -->
                                <div class="col-lg-6">
                                    <div class="alert alert-light">
                                        <h5>Weekly Sales</h5>
                                        <p><?= $weeklySales['weekly_sales']; ?> sales this week, RM<?= number_format($weeklySales['weekly_revenue'], 2); ?> revenue.</p>
                                    </div>
                                </div>

                                <!-- Pending Supplier Orders -->
                                <div class="col-lg-12">
                                    <div class="alert alert-danger">
                                        <h5>Pending Supplier Orders</h5>
                                        <p><?= $pendingSupplierOrderCount; ?> pending orders.</p>
                                        <ul>
                                            <?php
                                                if(!empty($pendingSupplierOrders)) {
                                                    foreach($pendingSupplierOrders as $order) {
                                                        echo "<li>Order ID: " . $order['id'] . " - " . $order['supplier_name'] . " (Total: RM" . number_format($order['total_price'], 2) . ", Date: " . $order['order_date'] . ")</li>";
                                                    }
                                                } else {
                                                    echo "<li>No pending supplier orders.</li>";
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Pending Supplier Orders -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
