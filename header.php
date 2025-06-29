<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    .navbar {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .navbar-brand {
      font-size: 1.5rem;
      color: yellow !important;
    }
    .navbar-nav .nav-link {
      font-weight: 500;
      margin-right: 10px;
      color: white !important;
      transition: color 0.3s;
    }
    .navbar-nav .nav-link:hover {
      color: yellow !important;
    }
    .user-tag {
      
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: 500;
      color: white;
      display: inline-block;
      white-space: nowrap;
    }
    .user-tag:hover {
      background-color:yellow;
      cursor: pointer;
    }
    .bi-cart3 {
      font-size: 1.3rem;
      color: white;
    }
    .cart-badge {
      position: absolute;
      top: 0;
      right: 0;
      color: white;
      font-size: 12px;
      padding: 2px 6px;
      border-radius: 50%;
    }

    .cart-badge {
      color:white;
      cursor: pointer;
    }

    @media (max-width: 576px) {
      .navbar-nav .nav-link {
        margin-right: 0;
        padding-left: 10px;
      }
      .user-tag {
        display: block;
        text-align: center;
        margin-top: 10px;
      }
      .navbar-nav.align-items-center {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-3 px-sm-4">
      <a class="navbar-brand fw-bold" href="#">Railway Food Ordering System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
        </ul>

        <ul class="navbar-nav align-items-center">
          <li class="nav-item position-relative me-3">
            <a class="nav-link" href="#">
              <i class="bi bi-cart3"></i>
              <!-- Optional cart count -->
              <!-- <span class="cart-badge">3</span> -->
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="user-tag text-decoration-none">
              <?php echo htmlspecialchars($username); ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>
</html>
