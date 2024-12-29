<?php

/* if (session_status() === PHP_SESSION_NONE) {
    session_start();
} */

include('../config/dbcon.php');
include('../functions/myfunctions.php');
require_once 'libraries/PhpSpreadsheet/vendor/autoload.php'; // Include TCPDF or PhpSpreadsheet using Composer
require_once 'libraries/tcpdf/tcpdf.php';


use PhpSpreadsheet\Spreadsheet;
use PhpSpreadsheet\Writer\Xlsx;


// Ensure only admins and retailers can access
if (!isset($_SESSION['auth']) || !in_array($_SESSION['auth_user']['role_as'], ['admin', 'retailer'])) {
    header("Location: ../index.php");
    exit;
}


// Adding a Category
if (isset($_POST['add_category_btn'])) {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';
    $image = $_FILES['image']['name'];
    $path = "../uploads";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $cate_query = "INSERT INTO categories 
    (name, brand, description, meta_title, meta_description, meta_keywords, status, popular, image)
    VALUES ('$name', '$brand', '$description', '$meta_title', '$meta_description', '$meta_keywords', '$status', '$popular', '$filename')";

    $cate_query_run = mysqli_query($con, $cate_query);

    if ($cate_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        redirect("add-category.php", "Category added successfully");
    } else {
        redirect("add-category.php", "Something went wrong");
    }
}

// Updating a Category
elseif (isset($_POST['update_category_btn'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];
    $path = "../uploads";
    $update_filename = $new_image ? time() . '.' . pathinfo($new_image, PATHINFO_EXTENSION) : $old_image;

    $update_query = "UPDATE categories SET name='$name', brand='$brand', description='$description', meta_title='$meta_title', 
    meta_description='$meta_description', meta_keywords='$meta_keywords', 
    status='$status', popular='$popular', image='$update_filename' WHERE id='$category_id'";

    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        if ($new_image) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("../uploads/" . $old_image)) {
                unlink("../uploads/" . $old_image);
            }
        }
        redirect("edit-category.php?id=$category_id", "Category updated successfully");
    } else {
        redirect("edit-category.php?id=$category_id", "Something went wrong");
    }
}

// Deleting a Category
elseif (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $category_query = "SELECT * FROM categories WHERE id='$category_id'";
    $category_query_run = mysqli_query($con, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['image'];

    $delete_query = "DELETE FROM categories WHERE id='$category_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }
        echo 200;
    } else {
        echo 500;
    }
}

// Adding a Product
elseif (isset($_POST['add_product_btn'])) {
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $brand = mysqli_real_escape_string($con, $_POST['brand']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $image = $_FILES['image']['name'];
    $path = "../uploads";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $product_query = "INSERT INTO products (category_id, supplier_id, name, brand, description, original_price, selling_price, qty, image) 
                      VALUES ('$category_id', '$supplier_id', '$name', '$brand', '$description', '$original_price', '$selling_price', '$qty', '$filename')";

    $product_query_run = mysqli_query($con, $product_query);

    if ($product_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        $_SESSION['message'] = "Product added successfully!";
        header("Location: add-product.php");
        exit();
    } else {
        $_SESSION['message'] = "Error adding product.";
        header("Location: add-product.php");
        exit();
    }
}

// Updating a Product
elseif (isset($_POST['update_product_btn'])) {
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $brand = mysqli_real_escape_string($con, $_POST['brand']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];
    $path = "../uploads";
    $update_filename = $new_image ? time() . '.' . pathinfo($new_image, PATHINFO_EXTENSION) : $old_image;

    $update_query = "UPDATE products SET category_id='$category_id', supplier_id='$supplier_id', name='$name', brand='$brand', description='$description', 
                     original_price='$original_price', selling_price='$selling_price', qty='$qty', image='$update_filename' 
                     WHERE id='$product_id'";

    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        if ($new_image) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists($path . '/' . $old_image)) {
                unlink($path . '/' . $old_image);
            }
        }
        $_SESSION['message'] = "Product updated successfully!";
        header("Location: edit-product.php?id=$product_id");
        exit();
    } else {
        $_SESSION['message'] = "Error updating product.";
        header("Location: edit-product.php?id=$product_id");
        exit();
    }
}

// Deleting a Product
elseif (isset($_POST['delete_product_btn'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

    // Fetch the product details
    $product_query = "SELECT * FROM products WHERE id='$product_id'";
    $product_query_run = mysqli_query($con, $product_query);

    if (mysqli_num_rows($product_query_run) > 0) {
        $product_data = mysqli_fetch_array($product_query_run);
        $image = $product_data['image'];

        // Delete product record
        $delete_query = "DELETE FROM products WHERE id='$product_id'";
        $delete_query_run = mysqli_query($con, $delete_query);

        if ($delete_query_run) {
            // Delete product image from server
            if (file_exists("../uploads/" . $image)) {
                unlink("../uploads/" . $image);
            }
            $_SESSION['message'] = "Product deleted successfully!";
            echo 200;
        } else {
            echo 500;
        }
    } else {
        echo 404; // Product not found
    }
}


// Updating a User
elseif (isset($_POST['update_user_btn'])) {
    $user_id = $_POST['user_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $role_as = mysqli_real_escape_string($con, $_POST['role_as']);

    // Update query to modify the user information in the database
    $update_user_query = "UPDATE users SET name='$name', email='$email', phone='$phone', role_as='$role_as' WHERE id='$user_id'";
    $update_user_query_run = mysqli_query($con, $update_user_query);

    if ($update_user_query_run) {
        // Redirect back to edit page or user management with success message
        header("Location: edit-user.php?id=$user_id");
        $_SESSION['message'] = "User updated successfully";
    } else {
        // Redirect back with error message if update failed
        header("Location: edit-user.php?id=$user_id");
        $_SESSION['message'] = "User update failed. Please try again.";
    }
}

elseif(isset($_POST['update_order_btn'])) {
    $order_id = $_POST['order_id'];
    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_address = $_POST['customer_address'];
    $qty = $_POST['qty'];
    $selling_price = $_POST['selling_price'];
    $total_price = $_POST['total_price'];

    $query = "UPDATE orders SET 
              customer_name = '$customer_name', 
              customer_contact = '$customer_contact', 
              customer_address = '$customer_address', 
              qty = '$qty', 
              selling_price = '$selling_price', 
              total_price = '$total_price' 
              WHERE id = $order_id";

    $query_run = mysqli_query($con, $query);

    if($query_run) {
        header("Location: order-management.php?id=$order_id");
        $_SESSION['message']="Order Updated Successfully";
        exit(0);
    } else {
        echo "Error updating order";
    }
}

elseif (isset($_POST['place_order_btn'])) {
    $product_id = $_POST['product_id'];
    $original_qty = $_POST['original_qty'];
    $order_qty = $_POST['order_qty'];
    $selling_price = $_POST['selling_price']; // Custom selling price from the form
    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_address = $_POST['customer_address'];

    // Validate order quantity
    if ($order_qty > $original_qty) {
        $_SESSION['message'] = "Order quantity exceeds available stock!";
        header("Location: order-product.php?id=$product_id");
        exit();
    }

    $total_price = $order_qty * $selling_price; // Use custom selling price

    // Insert into orders table
    $order_query = "INSERT INTO orders (product_id, customer_name, customer_contact, customer_address, qty, selling_price, total_price)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($order_query);
    $stmt->bind_param('isssidd', $product_id, $customer_name, $customer_contact, $customer_address, $order_qty, $selling_price, $total_price);

    if ($stmt->execute()) {
        // Update product quantity
        $new_qty = $original_qty - $order_qty;
        $update_qty_query = "UPDATE products SET qty = ? WHERE id = ?";
        $stmt = $con->prepare($update_qty_query);
        $stmt->bind_param('ii', $new_qty, $product_id);
        $stmt->execute();

        $_SESSION['message'] = "Order placed successfully!";
        header("Location: products.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to place order. Please try again.";
        header("Location: order-product.php?id=$product_id");
        exit();
    }
}


// Check if delete request is made
elseif (isset($_POST['delete_order_btn'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);

    // Fetch the order details
    $order_query = "SELECT * FROM orders WHERE id='$order_id'";
    $order_query_run = mysqli_query($con, $order_query);

    if (mysqli_num_rows($order_query_run) > 0) {
        $order_data = mysqli_fetch_array($order_query_run);

        $product_id = $order_data['product_id'];
        $order_qty = $order_data['qty'];

        // Fetch the current quantity of the product
        $product_query = "SELECT qty FROM products WHERE id='$product_id'";
        $product_query_run = mysqli_query($con, $product_query);

        if (mysqli_num_rows($product_query_run) > 0) {
            $product_data = mysqli_fetch_array($product_query_run);
            $current_qty = $product_data['qty'];

            // Add the order quantity back to the product quantity
            $updated_qty = $current_qty + $order_qty;

            $update_product_query = "UPDATE products SET qty='$updated_qty' WHERE id='$product_id'";
            mysqli_query($con, $update_product_query);
        }

        // Delete the order
        $delete_order_query = "DELETE FROM orders WHERE id='$order_id'";
        $delete_order_query_run = mysqli_query($con, $delete_order_query);

        if ($delete_order_query_run) {
            $_SESSION['message'] = "Order and product quantity updated successfully!";
            header("Location: order-management.php");
            exit();
        } else {
            $_SESSION['message'] = "Error deleting order!";
            header("Location: order-management.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Order not found!";
        header("Location: order-management.php");
        exit();
    }
}

elseif (isset($_POST['place_supplier_order_btn'])) {
    $supplier_id = mysqli_real_escape_string($con, $_POST['supplier_id']);
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $qty = mysqli_real_escape_string($con, $_POST['qty']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    if ($supplier_id && $product_id && $qty > 0 && $price > 0) {
        $order_query = "INSERT INTO supplier_orders (supplier_id, product_id, qty, price, order_date, status)
                        VALUES ('$supplier_id', '$product_id', '$qty', '$price', NOW(), '$status')";
        $order_query_run = mysqli_query($con, $order_query);

        if ($order_query_run) {
            $_SESSION['message'] = "Order placed successfully!";
            header("Location: supplier.php");
            exit();
        } else {
            $_SESSION['message'] = "Failed to place order.";
            header("Location: order-to-supplier.php?supplier_id=$supplier_id");
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid input. Please check the form and try again.";
        header("Location: order-to-supplier.php?supplier_id=$supplier_id");
        exit();
    }
}

elseif (isset($_POST['update_supplier_order'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE supplier_orders SET status = '$status' WHERE id = '$order_id'";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        echo 200; // Success response
    } else {
        echo 500; // Error response
    }
}

// Check if export request is made
if (isset($_POST['export-btn'])) {
    $reportType = $_POST['report_type']; // 'stock' or 'sales'
    $exportType = $_POST['export_type']; // 'pdf' or 'excel'
    $startDate = $_POST['start_date'] ?? null; // For sales report
    $endDate = $_POST['end_date'] ?? null; // For sales report

    // Fetch data based on the report type
    if ($reportType === 'stock') {
        $query = "SELECT products.name AS Product, products.brand AS Brand, categories.name AS Category, 
                         products.qty AS Quantity, products.original_price AS OriginalPrice 
                  FROM products
                  JOIN categories ON products.category_id = categories.id";
        $result = $con->query($query);
        $data = $result->fetch_all(MYSQLI_ASSOC);
    } elseif ($reportType === 'sales' && $startDate && $endDate) {
        $query = "SELECT id AS OrderID, created_at AS OrderDate, customer_name AS CustomerName, 
                         SUM(total_price) AS TotalSales
                  FROM orders
                  WHERE created_at BETWEEN ? AND ?
                  GROUP BY id";

        $stmt = $con->prepare($query);
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        die("Invalid report type or missing parameters.");
    }

    // Export as PDF or Excel
    if ($exportType === 'pdf') {
        generatePDF($data, $reportType);
    } elseif ($exportType === 'excel') {
        generateExcel($data, $reportType);
    } else {
        die("Invalid export type.");
    }
}




// Default redirect if no specific action was triggered
else {
    header('Location: ../index.php');
}

?>
