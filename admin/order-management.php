<?php 
include('includes/header.php');
include('../middleware/adminMiddleware.php');

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Order Management</h4>
                </div>
                <div class="card-body" id="orders_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product ID</th>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Quantity</th>
                                <th>Selling Price</th>
                                <th>Total Price</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $orders = getAll("orders");

                                if(mysqli_num_rows($orders) > 0) {
                                    foreach($orders as $item) 
                                    {
                                        ?>
                                            <tr>
                                                <td><?= $item['id']; ?></td>
                                                <td><?= $item['product_id']; ?></td>
                                                <td><?= $item['customer_name']; ?></td>
                                                <td><?= $item['customer_contact']; ?></td>
                                                <td><?= $item['customer_address']; ?></td>
                                                <td><?= $item['qty']; ?></td>
                                                <td><?= $item['selling_price']; ?></td>
                                                <td><?= $item['total_price']; ?></td>
                                                <td><?= $item['created_at']; ?></td>
                                                <td>
                                                    <a href="edit-order.php?id=<?= $item['id']; ?>" class="btn btn-primary">Edit</a>
                                                    <form action="code.php" method="POST"> 
                                                        <input type="hidden" name="order_id" value="<?= $item['id']; ?>">                                                   
                                                        <button type="submit" class="btn btn-danger" name= "delete_order_btn" value="<?= $item['id']; ?>">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                } else {
                                    echo "No records found";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>
