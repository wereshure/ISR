<?php
// Include necessary files and start the session
include('includes/header.php');
include ('../config/dbcon.php'); // Database connection
include ('../functions/authenticator.php'); // Authentication check
include ('includes/export.php'); // Adjust the path if needed


// Set default timezone
date_default_timezone_set('UTC');

// Fetch data for stock report
function getStockReport($con) {
    $query = "SELECT products.name, products.brand, categories.name AS category, products.qty, products.original_price 
              FROM products
              JOIN categories ON products.category_id = categories.id";
    $result = $con->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch data for sales report
function getSalesReport($con, $startDate, $endDate) {
    $query = "SELECT id, created_at AS order_date, customer_name, 
                     SUM(total_price) AS total_sales
              FROM orders
              WHERE created_at BETWEEN ? AND ?
              GROUP BY id";

    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param('ss', $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die("Query failed: " . $con->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}


// Handle export request
if (isset($_POST['export_type'])) {
    $exportType = $_POST['export_type'];
    $reportType = $_POST['report_type'];
    $startDate = $_POST['start_date'] ?? null;
    $endDate = $_POST['end_date'] ?? null;

    // Get data based on the report type
    if ($reportType === 'stock') {
        $data = getStockReport($con);
    } elseif ($reportType === 'sales') {
        $data = getSalesReport($con, $startDate, $endDate);
    }

    // Export logic (to PDF or Excel)
    /* include 'includes/export.php'; */
    exportReport($data, $exportType, $reportType);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reports</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<div class="container">
    <h1>Reports</h1>

    <!-- Stock Report Section -->
    <h2>Stock Report</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Qty</th>
                <th>original_price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stockData = getStockReport($con);
            foreach ($stockData as $row) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['brand']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['qty']}</td>
                        <td>{$row['original_price']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Sales Report Section -->
    <h2>Sales Report</h2>
    <form method="POST" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
        <button type="submit" name="view_sales">View Sales Report</button>
    </form>

    <?php
    if (isset($_POST['view_sales'])) {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $salesData = getSalesReport($con, $startDate, $endDate);
    ?>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Customer Name</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($salesData as $row) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['order_date']}</td>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['total_sales']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <?php } ?>

    <!-- Export Section -->
    <h2>Export Reports</h2>
    <form method="POST" action="code.php">
        <label for="report_type">Report Type:</label>
        <select id="report_type" name="report_type">
            <option value="stock">Stock Report</option>
            <option value="sales">Sales Report</option>
        </select>
        <label for="export_type">Export As:</label>
        <select id="export_type" name="export_type">
            <option value="pdf">PDF</option>
            <option value="excel">Excel</option>
        </select>
        <button type="submit" name="export-btn">Export</button>
    </form>

</div>

</body>
</html>
