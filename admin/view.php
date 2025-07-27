<?php include "../db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .product-image {
      max-height: 200px;
      object-fit: cover;
    }
    .product-card {
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .card-body {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <h2 class="text-center mb-4">Product List</h2>

  <a href="dashboard.php" class="btn btn-warning">Back</a><br><br>

  <!-- Filter & Search Form -->
  <div class="row g-3 mb-4 align-items-end">
    <div class="col-md-4">
      <label class="form-label">Search by Name</label>
      <input type="text" id="searchInput" class="form-control" placeholder="Product name">
    </div>

    <div class="col-md-4">
      <label class="form-label">Filter by Category</label>
      <select id="filterSelect" class="form-select">
        <option value="">All Categories</option>
        <?php
        $categories = $conn->query("SELECT * FROM category ORDER BY name ASC");
        while ($cat = $categories->fetch_assoc()):
        ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
  </div>

  <!-- Product Grid -->
  <div id="productContainer" class="row g-4"></div>
</div>

<script>
  function fetchProducts() {
    const search = $('#searchInput').val();
    const filter = $('#filterSelect').val();

    $.get("ajax_fetch_products.php", { search, filter }, function (data) {
      $('#productContainer').html(data);
    });
  }

  $('#searchInput').on('keyup', fetchProducts);
  $('#filterSelect').on('change', fetchProducts);

  function confirmDelete(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "Product will be deleted!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `delete.php?id=${id}`;
      }
    });
  }

  // Initial load
  $(document).ready(fetchProducts);
</script>

</body>
</html>
