<?php
include "../db.php";

$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? '';

$sql = "SELECT products.*, category.name as category_name 
        FROM products 
        JOIN category ON products.category_id = category.id 
        WHERE 1";

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

<?php if ($result->num_rows > 0): ?>
  <?php while($row = $result->fetch_assoc()): ?>
    <div class="col-md-4 d-flex">
      <div class="card product-card w-100">
        <img src="../<?= htmlspecialchars($row['image_url']) ?>" class="card-img-top product-image" alt="Image">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
          <p class="card-text mb-3">
            <?= htmlspecialchars($row['description']) ?><br>
            <small class="text-muted">Category: <?= htmlspecialchars($row['category_name']) ?></small><br>
            <strong>₹<?= $row['price'] ?></strong> | Qty: <?= $row['quantity'] ?>
          </p>
          <button onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-danger btn-sm w-100 mt-auto">
            <i class="bi bi-trash"></i> Delete
          </button>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <div class="col-12">
    <div class="text-center">No products found.</div>
  </div>
<?php endif; ?>
