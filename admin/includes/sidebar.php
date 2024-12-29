<?php
  // Check if the session is started
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  // Get the current page name
  $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);

  // Only show the sidebar if the user is authenticated and not on login/register pages
  if (isset($_SESSION['auth']) && ($page != "login.php" && $page != "register.php")):
?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="" target="_blank">
        <span class="ms-1 font-weight-bold text-white">Inventory System for Retailer</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link text-white active <?= $page == "index.php"? 'active bg-gradient-primary':''; ?>" href="index.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <!-- User Management -->
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "user_management.php"? 'active bg-gradient-primary':''; ?>" href="user_management.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt</i>
            </div>
            <span class="nav-link-text ms-1">User Management</span>
          </a>
        </li>
        <!-- Categories -->
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "category.php"? 'active bg-gradient-primary':''; ?>" href="category.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">All Categories</span>
          </a>
        </li>
        <!-- Add Category -->
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "add-category.php"? 'active bg-gradient-primary':''; ?>" href="add-category.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">add</i>
            </div>
            <span class="nav-link-text ms-1">Add Category</span>
          </a>
        </li>
        <!-- Products -->
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "products.php"? 'active bg-gradient-primary':''; ?>" href="products.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">All Products</span>
          </a>
        </li>
        <!-- Add Product -->
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "add-product.php"? 'active bg-gradient-primary':''; ?>" href="add-product.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">add</i>
            </div>
            <span class="nav-link-text ms-1">Add Product</span>
          </a>
        </li>
        <!-- Suppliers -->
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "supplier.php"? 'active bg-gradient-primary':''; ?>" href="supplier.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">All Suppliers</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "add-supplier.php"? 'active bg-gradient-primary':''; ?>" href="add-supplier.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">add</i>
            </div>
            <span class="nav-link-text ms-1">Add Supplier</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "supplier-order-management.php"? 'active bg-gradient-primary':''; ?>" href="supplier-order-management.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt</i>
            </div>
            <span class="nav-link-text ms-1">Supplier Order</span>
          </a>
        </li>
        <!-- Order Management -->
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "order-management.php"? 'active bg-gradient-primary':''; ?>" href="order-management.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt</i>
            </div>
            <span class="nav-link-text ms-1">Order Management</span>
          </a>
        </li>
        <!-- Reports -->
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "reports.php"? 'active bg-gradient-primary':''; ?>" href="reports.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">bar_chart</i>
            </div>
            <span class="nav-link-text ms-1">Reports</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0">
      <div class="mx-3">
        <a class="btn bg-gradient-primary mt-4 w-100" href="../logout.php">Logout</a>
      </div>
    </div>
</aside>
<?php endif; ?>
