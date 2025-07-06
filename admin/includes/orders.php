<?php
include("db.php");

$orders = $conn->query("
  SELECT o.*, 
         GROUP_CONCAT(CONCAT(p.name, ' x', oi.quantity, ' = ₹', oi.price * oi.quantity) SEPARATOR '<br>') as items,
         SUM(oi.price * oi.quantity) as total_amount
  FROM orders o
  JOIN order_items oi ON o.id = oi.order_id
  JOIN products p ON oi.product_id = p.id
  GROUP BY o.id
  ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Orders</title>
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">All Orders</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>#Order ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Train No</th>
        <th>Station</th>
        <th>Items</th>
        <th>Total (₹)</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $orders->fetch_assoc()): ?>
        <tr>
          <td>#<?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['train_no']) ?></td>
          <td><?= htmlspecialchars($row['station']) ?></td>
          <td><?= $row['items'] ?></td>
          <td><strong>₹<?= number_format($row['total_amount'], 2) ?></strong></td>
          <td><?= date('d-m-Y h:i A', strtotime($row['created_at'])) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
