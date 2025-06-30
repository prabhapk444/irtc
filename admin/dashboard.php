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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
   
      color: #222;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .sidebar {
      width: 240px;
      background-color: #fff;
      padding: 20px;
      border-right: 1px solid #ccc;
      display: flex;
      flex-direction: column;
    }

    .sidebar h2 {
      margin-bottom: 20px;
      color: royalblue;
    }

    .nav-link {
      display: flex;
      align-items: center;
      padding: 10px;
      border-radius: 8px;
      color: #222;
      text-decoration: none;
      margin-bottom: 10px;
    }

    .nav-link.active,
    .nav-link:hover {
      background-color: rgba(65, 105, 225, 0.2);
    }

    .main {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .card {
     
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <?php include "includes/sidebar.php"; ?>

  <div class="main">
    <div class="content">
      <?php include "includes/{$page}.php"; ?>
    </div>
  </div>

</body>
</html>
