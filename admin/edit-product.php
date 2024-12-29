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
                        $product = getByID("products", $id);

                        if(mysqli_num_rows($product) > 0)
                        {
                            $data = mysqli_fetch_array($product);
                            ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit Product
                                            <a href="products.php" class="btn btn-primary float-end">Back</a>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="code.php" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <label class="mb-0">Select Category</label>
                                                    <select name="category_id" class="form-select mb-2" >
                                                    <option selected>Select Category</option>
                                                        <?php
                                                            $categories = getAll("categories");
        
                                                            if(mysqli_num_rows($categories) > 0)
                                                            {
                                                                foreach ($categories as $key => $item) {
                                                                    ?>
                                                                        <option value="<?= $item['id']; ?>" <?= $data['category_id'] == $item['id']?'selected':'' ?> ><?= $item['name']; ?></option>
                                                                    <?php                                            
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "No category available";
                                                            }
                                                            
                                                        ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="mb-0">Select Supplier</label>
                                                    <select name="supplier_id" class="form-select">
                                                    <option selected>Select Supplier</option>
                                                        <?php
                                                            $suppliers = getAll("suppliers");
        
                                                            if(mysqli_num_rows($suppliers) > 0)
                                                            {
                                                                foreach ($suppliers as $key => $item) {
                                                                    ?>
                                                                        <option value="<?= $item['id']; ?>" <?= $data['supplier_id'] == $item['id']?'selected':'' ?> ><?= $item['name']; ?></option>
                                                                    <?php                                            
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "No supplier available";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                                                <div class="col-md-6">
                                                    <label class="mb-0">Name</label>
                                                    <input type="text" required name="name" value="<?= $data['name'] ?>" placeholder="Enter Product Name" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="mb-0">Brand</label>
                                                    <input type="text" required name="brand" value="<?= $data['brand'] ?>"  placeholder="Enter Brand" class="form-control">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="mb-0">Description</label>
                                                    <textarea rows="3" required name="description" placeholder="Enter description" class="form-control"><?= $data['description'] ?> </textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="mb-0">Original Price</label>
                                                    <input type="text" name="original_price" value="<?= $data['original_price'] ?>" placeholder="Enter Original Price" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="mb-0">Selling Price</label>
                                                    <input type="text" name="selling_price" value="<?= $data['selling_price'] ?>" placeholder="Enter Selling Price" class="form-control">
                                                </div>


                                                <div class="col-md-12">
                                                    <label class="mb-0">Upload Image</label>
                                                    <input type="hidden" name="old_image" value="<?= $data['image']; ?>">
                                                    <input type="file" name="image" class="form-control">
                                                    <label for="mb-0">Current Image</label>
                                                    <img src="../uploads/<?= $data['image']; ?>" alt="Product Image" height="50px" width="50px">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="mb-0">Quantity</label>
                                                    <input type="number" name="qty" value="<?= $data['qty'] ?>" placeholder="Enter Quantity" class="form-control">
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary" name="update_product_btn">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php
                        }
                        else
                        {
                            echo "Product not found for given Id";
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