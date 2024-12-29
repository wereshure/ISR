<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid">
    <!-- Brand Name -->
    <a class="navbar-brand" href="index.php">Inventory System for Retailer</a>
    
    <!-- Navbar Toggle for Mobile View -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Navbar Links -->
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <!-- Home Link -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        
        <!-- Collection Link -->
        <li class="nav-item">
          <a class="nav-link" href="categories.php">Collection</a>
        </li>

        <!-- Authentication Links -->
        <?php if (isset($_SESSION['auth'])): ?>
          <!-- Dropdown for Authenticated Users -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $_SESSION['auth_user']['name']; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="profile.php">Profile</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><a class="dropdown-item" href="../admin/logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Login and Register Links for Non-Authenticated Users -->
          <li class="nav-item">
            <a class="nav-link" href="../login.php">Login as Customer</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
