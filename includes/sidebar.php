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

            <!-- Categories -->
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == 'category.php' ? 'active bg-gradient-primary' : ''; ?>" href="category.php" aria-label="All Categories">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center" title="All Categories">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">All Categories</span>
                </a>
            </li>

            <!-- Products -->
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == 'products.php' ? 'active bg-gradient-primary' : ''; ?>" href="products.php" aria-label="All Products">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center" title="All Products">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">All Products</span>
                </a>
            </li>

        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0">
        <div class="mx-3">
            <a class="btn bg-gradient-danger mt-4 w-100" href="../isr/logout.php">Logout</a>
        </div>
    </div>
</aside>
