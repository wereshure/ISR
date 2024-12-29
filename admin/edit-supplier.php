<?php 

include('includes/header.php');
include('../middleware/adminMiddleware.php');

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
                if(isset($_GET['id']))
                {
                        $id = $_GET['id'];
                        $supplier = getByID("suppliers", $id);

                        if(mysqli_num_rows($supplier) > 0)
                        {
                            $data = mysqli_fetch_array($supplier);
                            ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit Supplier
                                        <a href="supplier.php" class="btn btn-primary float-end">Back</a>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="code.php" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                            <input type="hidden" name="supplier_id" value="<?= $data['id']; ?>">
                                                <div class="col-md-6">
                                                    <label class="mb-0">Name</label>
                                                    <input type="text" required name="name" value="<?= $data['name'] ?>" placeholder="Enter Supplier Name" class="form-control">
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary" name="update_supplier_btn">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php
                        }
                        else
                        {
                            echo "Supplier not found for given Id";
                        }
                        
                }
                else
                {
                    echo "Id missing from url";
                }
            ?>
        </div>
    </div>
</div>


<?php include('includes/footer.php');?>