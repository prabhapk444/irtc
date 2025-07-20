<?php
include("db.php");
include("header.php");

if (!isset($_SESSION['user_id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Please login to view your orders.</div></div>";
    include("footer.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$orders = $conn->query("
  SELECT o.*, 
         GROUP_CONCAT(CONCAT(p.name, ' x', oi.quantity, ' = ₹', oi.price * oi.quantity) SEPARATOR '<br>') as items,
         SUM(oi.price * oi.quantity) as total_amount
  FROM orders o
  JOIN order_items oi ON o.id = oi.order_id
  JOIN products p ON oi.product_id = p.id
  WHERE o.user_id = $user_id
  GROUP BY o.id
  ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container my-5">
  <h2 class="text-center mb-4">My Orders</h2>

  <?php if ($orders->num_rows === 0): ?>
    <div class="alert alert-info text-center">You have no orders yet.</div>
  <?php else: ?>
    <div class="row g-4">
      <?php while($row = $orders->fetch_assoc()): ?>
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Order #<?= $row['id'] ?></h5>
              <p><strong>Date:</strong> <?= date("d-m-Y h:i A", strtotime($row['created_at'])) ?></p>
              <p><strong>Status:</strong> <span class="badge bg-info text-dark"><?= htmlspecialchars($row['status']) ?></span></p>
              <p><strong>Items:</strong><br><?= $row['items'] ?></p>
              <p><strong>Total:</strong> ₹<?= number_format($row['total_amount'], 2) ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>

<?php include("footer.php"); ?>
</body>
</html>
