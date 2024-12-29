<?php 

include('../middleware/adminMiddleware.php');
include('includes/header.php');

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Products</h4>
                </div>
                <div class="card-body" id="products_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $products = getAll("products");

                                if(mysqli_num_rows($products) > 0)
                                {
                                    foreach($products as $item)
                                    {
                                        ?>
                                            <tr>
                                                <td><?= $item['id']; ?></td>
                                                <td><?= $item['name']; ?></td>
                                                <td><img src="../uploads/<?= $item['image']; ?>" width="60px" height="60px" alt="<?= $item['name']; ?>"></td>
                                                <td>
                                                    <?= $item['qty']; ?>
                                                    <a href="order-product.php?id=<?= $item['id']; ?>" class="btn btn-info">Order</a> 
                                                </td>
                                                
                                                <td>
                                                    <a href="edit-product.php?id=<?= $item['id']; ?>" class="btn btn-primary">Edit</a>                                                    
                                                        <button type="button" class="btn btn-danger delete_product_btn" value="<?= $item['id']; ?>">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                }
                                else
                                {
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


<?php include('includes/footer.php');?>