<?php 

include('../middleware/adminMiddleware.php');
include('includes/header.php');

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Suppliers</h4>
                </div>
                <div class="card-body" id="supplier_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $suppliers = getAll("suppliers");

                                if(mysqli_num_rows($suppliers) > 0)
                                {
                                    foreach($suppliers as $item)
                                    {
                                        ?>
                                            <tr>
                                                <td> <?= $item['id']; ?></td>
                                                <td> <?= $item['name']; ?></td>
                                                <td>
                                                    <a href="edit-supplier.php?id=<?= $item['id']; ?>" class="btn btn-primary">Edit</a>  
                                                    <button type="button" class="btn btn-danger delete_supplier_btn" value="<?= $item['id']; ?>">Delete</button>
                                                    <a href="order-to-supplier.php?supplier_id=<?= $item['id']; ?>" class="btn btn-success">Order to Supplier</a>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "<tr><td colspan='3'>No records found</td></tr>";
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
