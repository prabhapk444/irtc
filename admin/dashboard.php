<?php
session_start();
$_SESSION['admin'] = "admin";
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

$page = $_GET['page'] ?? 'overview';
$validPages = ['overview', 'category', 'products', 'orders', 'users'];
if (!in_array($page, $validPages)) {
  $page = 'overview';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      display: flex;
      margin: 0;
    
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      width: 240px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background: #fff;
      border-right: 1px solid #ccc;
      padding: 30px 20px;
      box-shadow: 2px 0 6px rgba(0, 0, 0, 0.05);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      color: royalblue;
    }

    .nav-link {
      display: flex;
      align-items: center;
      padding: 10px 15px;
      margin-bottom: 10px;
      text-decoration: none;
      color: #333;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .nav-link i {
      margin-right: 10px;
    }

    .nav-link.active,
    .nav-link:hover {
      background: rgba(65, 105, 225, 0.2);
      color: royalblue;
      font-weight: 600;
    }

    .main {
      margin-left: 240px; /* Sidebar width */
      width: calc(100% - 240px);
      padding: 30px;
      min-height: 100vh;
     
    }

    .card {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    }

  </style>
</head>
<body>

  <!-- Sidebar -->
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

  <!-- Main Content -->
  <div class="main">
    <?php include "includes/{$page}.php"; ?>
  </div>

</body>
</html>
