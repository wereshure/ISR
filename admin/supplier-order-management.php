<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');

$supplier_orders = mysqli_query($con, "
    SELECT supplier_orders.*, 
           suppliers.name AS supplier_name, 
           products.name AS product_name, 
           (supplier_orders.qty * supplier_orders.price) AS total_price 
    FROM supplier_orders
    JOIN suppliers ON supplier_orders.supplier_id = suppliers.id
    JOIN products ON supplier_orders.product_id = products.id
");
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Supplier Orders</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Supplier</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = mysqli_fetch_assoc($supplier_orders)) : ?>
                                <tr>
                                    <td><?= $order['id']; ?></td>
                                    <td><?= $order['supplier_name']; ?></td>
                                    <td><?= $order['product_name']; ?></td>
                                    <td><?= $order['qty']; ?></td>
                                    <td><?= $order['price']; ?></td>
                                    <td><?= number_format($order['total_price'], 2); ?></td>
                                    <td><?= $order['order_date']; ?></td>
                                    <td>
                                        <?= $order['status'] == 1 ? 'Completed' : 'Pending'; ?>
                                    </td>
                                    <td>
                                        <?php if ($order['status'] == 0) : ?>
                                            <form method="POST" action="update_order_status.php" style="display:inline;">
                                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                                <button type="submit" name="update_status" class="btn btn-success btn-sm">Mark as Completed</button>
                                            </form>
                                        <?php else : ?>
                                            <span class="badge bg-success">Completed</span>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
