<?php

include "db.php"; 
$categories = $conn->query("SELECT * FROM category ORDER BY name ASC");


$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? '';

$sql = "SELECT products.*, category.name AS category_name 
        FROM products 
        JOIN category ON products.category_id = category.id 
        WHERE products.is_show = 1";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND products.name LIKE '%$search%'";
}

if (!empty($filter)) {
    $filter = intval($filter);
    $sql .= " AND category_id = $filter";
}

$sql .= " ORDER BY products.id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .product-card {
      transition: transform 0.3s ease;
    }
    .product-card:hover {
      transform: translateY(-5px);
    }
   .product-image {
  width: 100%;         
  height: 300px;       
  object-fit: cover;  
}

    .search-btn {
      background-color: #ffc107;
      border-color: #ffc107;
      color: #000;
    }
    .search-btn:hover {
      background-color: #e0a800;
      border-color: #d39e00;
    }
  </style>
</head>
<body>

<?php include("header.php"); ?>

<div class="container my-5">
  <h2 class="text-center mb-4">Our Products</h2>

  <form method="GET" class="row g-3 mb-5">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-4">
      <select name="filter" class="form-select">
        <option value="">All Categories</option>
        <?php while($cat = $categories->fetch_assoc()): ?>
          <option value="<?= $cat['id'] ?>" <?= ($filter == $cat['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-4 d-grid">
      <button type="submit" class="btn search-btn">
        <i class="bi bi-search"></i> Search
      </button>
    </div>
  </form>

  <div class="row g-4">
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-md-4" data-aos="fade-up">
          <div class="card product-card h-100 shadow-sm">
           <img src="<?= htmlspecialchars($row['image_url']) ?>" class="card-img-top product-image" alt="<?= htmlspecialchars($row['name']) ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="card-text">
                <?= htmlspecialchars($row['description']) ?>
              </p>

              <div class="mt-auto">
                <strong class="text-primary text-lg">Price :₹<?= $row['price'] ?></strong><br><br> 
               
              <button class="btn btn-warning add-to-cart-btn" 
        data-id="<?= $row['id'] ?>" 
        data-name="<?= htmlspecialchars($row['name']) ?>" 
        data-price="<?= $row['price'] ?>" 
        data-image="<?= htmlspecialchars($row['image_url']) ?>" 
        data-quantity="<?= $row['quantity'] ?>">
  Add to Cart
</button>

              </div>
            </div>
          </div>

        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-warning text-center">No products found.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true
  });

   const isLoggedIn = <?= isset($_SESSION['username']) ? 'true' : 'false' ?>;

  function getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
  }

  function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
  }

 function addToCart(product) {
  if (!isLoggedIn) {
    Swal.fire({
      title: "Please login first!",
      text: "You need to register or login before adding to cart.",
      icon: "warning",
      confirmButtonText: "Go to Register",
      confirmButtonColor: "#ffc107"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "register.php";
      }
    });
    return;
  }

  const cart = getCart();
  const existing = cart.find(item => item.id === product.id);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({ ...product, qty: 1 });
  }
  saveCart(cart);

  Swal.fire({
    title: 'Added to Cart!',
    text: 'Your product has been added successfully.',
    icon: 'success',
    confirmButtonColor: '#ffc107'
  });
}


  document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const product = {
        id: btn.dataset.id,
        name: btn.dataset.name,
        price: parseFloat(btn.dataset.price),
        image: btn.dataset.image,
        stock: parseInt(btn.dataset.quantity)
      };
      addToCart(product);
    });
  });
</script>
</body>
</html>
