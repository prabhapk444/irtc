
<div class="sidebar">
  <h2>Admin Panel</h2>

  <a href="dashboard.php?page=overview" class="nav-link <?= $page == 'overview' ? 'active' : '' ?>">
    <i class="bi bi-speedometer2"></i> Overview
  </a>

  <a href="dashboard.php?page=category" class="nav-link <?= $page == 'category' ? 'active' : '' ?>">
    <i class="bi bi-tags"></i> Category
  </a>

  <a href="dashboard.php?page=products" class="nav-link <?= $page == 'products' ? 'active' : '' ?>">
    <i class="bi bi-box"></i> Products
  </a>

  <a href="dashboard.php?page=orders" class="nav-link <?= $page == 'orders' ? 'active' : '' ?>">
    <i class="bi bi-cart-check"></i> Orders
  </a>

  <a href="dashboard.php?page=users" class="nav-link <?= $page == 'users' ? 'active' : '' ?>">
    <i class="bi bi-people"></i> Users
  </a>

  <a href="logout.php" class="nav-link">
    <i class="bi bi-box-arrow-right"></i> Logout
  </a>
</div>
