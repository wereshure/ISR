<?php
include('..\config\dbcon.php'); // Include your database connection file

// Define the low stock threshold
$lowStockThreshold = 10;  // Example: products with stock <= 10

// Query to get products with low stock
$lowStockQuery = "SELECT name, brand, qty FROM products WHERE qty <= $lowStockThreshold";
$lowStockResult = mysqli_query($con, $lowStockQuery);

$lowStockCount = mysqli_num_rows($lowStockResult); // Get the count of low-stock products

$lowStockProducts = [];

if($lowStockCount > 0) {
    while($row = mysqli_fetch_assoc($lowStockResult)) {
        $lowStockProducts[] = $row; // Store the product name and qty in the array
    }
}

// Query for total stock
$totalStockQuery = "SELECT SUM(qty) AS total_qty FROM products";
$totalStockResult = mysqli_query($con, $totalStockQuery);
$totalStockData = mysqli_fetch_assoc($totalStockResult);
$totalStock = $totalStockData['total_qty'] ?? 0; // Set default to 0 if no stock data

// Query to calculate total revenue from orders
$totalRevenueQuery = "SELECT SUM(selling_price * qty) AS total_revenue FROM orders";
$totalRevenueResult = mysqli_query($con, $totalRevenueQuery);
$totalRevenueData = mysqli_fetch_assoc($totalRevenueResult);
$totalRevenue = $totalRevenueData['total_revenue'] ?? 0; // Set default to 0 if no revenue data

// Query to calculate daily sales and revenue
$dailySalesQuery = "SELECT COUNT(*) AS daily_sales, SUM(selling_price * qty) AS daily_revenue 
                    FROM orders WHERE DATE(created_at) = CURDATE()";
$dailySalesResult = mysqli_query($con, $dailySalesQuery);
$dailySalesData = mysqli_fetch_assoc($dailySalesResult);
$dailySales = [
    'daily_sales' => $dailySalesData['daily_sales'] ?? 0, 
    'daily_revenue' => $dailySalesData['daily_revenue'] ?? 0
];

// Query to calculate weekly sales and revenue
$weeklySalesQuery = "SELECT COUNT(*) AS weekly_sales, SUM(selling_price * qty) AS weekly_revenue 
                     FROM orders WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
$weeklySalesResult = mysqli_query($con, $weeklySalesQuery);
$weeklySalesData = mysqli_fetch_assoc($weeklySalesResult);
$weeklySales = [
    'weekly_sales' => $weeklySalesData['weekly_sales'] ?? 0, 
    'weekly_revenue' => $weeklySalesData['weekly_revenue'] ?? 0
];

// Query to fetch pending supplier orders
$pendingOrdersQuery = "SELECT o.id, s.name as supplier_name, o.total_price, o.order_date 
                       FROM supplier_orders o 
                       INNER JOIN suppliers s ON o.supplier_id = s.id 
                       WHERE o.status = 'pending'";

$pendingOrdersResult = mysqli_query($con, $pendingOrdersQuery);

// Initialize variables
$pendingSupplierOrders = [];
$pendingSupplierOrderCount = 0;
$pendingOrdersQuery = "SELECT o.id, s.name as supplier_name, o.total_price, o.order_date 
                       FROM supplier_orders o 
                       INNER JOIN suppliers s ON o.supplier_id = s.id 
                       WHERE o.status = 'pending'";


// Process query result
if ($pendingOrdersResult && mysqli_num_rows($pendingOrdersResult) > 0) {
    $pendingSupplierOrderCount = mysqli_num_rows($pendingOrdersResult);

    while ($order = mysqli_fetch_assoc($pendingOrdersResult)) {
        $pendingSupplierOrders[] = $order;
    }
}
?>
