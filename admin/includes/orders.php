<?php
include("db.php");
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$alert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);


    $currentStatus = $conn->query("SELECT status FROM orders WHERE id = $order_id")->fetch_assoc()['status'];
    if ($currentStatus === 'Delivered') {
        $alert = 'This order has already been delivered. No further updates allowed.';
    } else {
        $conn->query("UPDATE orders SET status = '$status' WHERE id = $order_id");

        $res = $conn->query("SELECT name, email FROM orders WHERE id = $order_id");
        $order = $res->fetch_assoc();

        $itemsResult = $conn->query("
            SELECT p.name, oi.quantity, oi.price 
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = $order_id
        ");

        $itemsHTML = '';
        $total = 0;
        while ($item = $itemsResult->fetch_assoc()) {
            $lineTotal = $item['quantity'] * $item['price'];
            $total += $lineTotal;
            $itemsHTML .= "{$item['name']} x{$item['quantity']} = ₹" . number_format($lineTotal, 2) . "<br>";
        }

      
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'karanprabha22668@gmail.com';
            $mail->Password = 'vctn lmqf xjkl umfz';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('karanprabha22668@gmail.com', 'Railway Food Ordering');
            $mail->addAddress($order['email'], $order['name']);
            $mail->isHTML(true);

            if ($status === 'Processing') {
                $mail->Subject = "Order #$order_id - Processing";
                $mail->Body = "<p>Hi {$order['name']},</p><p>Your order #$order_id is currently being processed. We'll notify you once it's ready!</p>";
            } elseif ($status === 'Ready to Delivery') {
                $mail->Subject = "Order #$order_id - Ready to Delivery";
                $mail->Body = "<p>Hi {$order['name']},</p>
                              <p>Your order is <strong>Ready to Delivery</strong>.</p>
                              <p><strong>Order Details:</strong><br>$itemsHTML</p>
                              <p><strong>Total:</strong> ₹" . number_format($total, 2) . "</p>
                              <p>Thank you for ordering!</p>";
            } elseif ($status === 'Delivered') {
                $mail->Subject = "Order #$order_id - Delivered";
                $mail->Body = "<p>Dear {$order['name']},</p><p>Your order #$order_id has been delivered successfully. We hope you enjoyed your meal! 😊</p><p>Thank you for using Railway Food Ordering!</p>";
            }

            $mail->send();
            $alert = 'Status updated and email sent successfully!';
        } catch (Exception $e) {
            $alert = 'Status updated but email failed to send.';
        }
    }
}

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
 
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .order-card { transition: 0.3s ease; }
    .order-card:hover { transform: scale(1.01); }
  </style>
</head>
<body>
<div class="container my-5">
  <h2 class="mb-4 text-center">All Orders</h2>

  <?php if ($alert): ?>
    <script>
      Swal.fire({
        title: 'Info',
        text: '<?= $alert ?>',
        icon: 'info',
        confirmButtonColor: '#3085d6'
      });
    </script>
  <?php endif; ?>

  <div class="row mb-4 g-3">
    <div class="col-md-4">
      <input type="date" id="filter-date" class="form-control" placeholder="Search by Date">
    </div>
    <div class="col-md-4">
      <select id="filter-status" class="form-select">
        <option value="">All Status</option>
        <option value="Pending">Pending</option>
        <option value="Processing">Processing</option>
        <option value="Ready to Delivery">Ready to Delivery</option>
        <option value="Delivered">Delivered</option>
      </select>
    </div>
    <div class="col-md-4">
      <input type="text" id="filter-text" class="form-control" placeholder="Search by Name / Email / Phone">
    </div>
  </div>


  <div class="row g-4" id="order-container">
      <?php $hasOrders = false; ?>
    <?php while($row = $orders->fetch_assoc()): ?>
      <div class="col-md-6 order-card"
           data-status="<?= strtolower($row['status']) ?>"
           data-name="<?= strtolower($row['name']) ?>"
           data-email="<?= strtolower($row['email']) ?>"
           data-phone="<?= strtolower($row['phone']) ?>"
           data-date="<?= date('Y-m-d', strtotime($row['created_at'])) ?>">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title">Order #<?= $row['id'] ?> - <?= htmlspecialchars($row['name']) ?></h5>
            <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
            <p><strong>Train:</strong> <?= htmlspecialchars($row['train_no']) ?> - <?= htmlspecialchars($row['station']) ?></p>
            <p><strong>Items:</strong><br><?= $row['items'] ?></p>
            <p><strong>Total:</strong> ₹<?= number_format($row['total_amount'], 2) ?></p>
            <p><strong>Status:</strong> <span class="badge bg-info text-dark"><?= htmlspecialchars($row['status']) ?></span></p>
            <p><strong>Date:</strong> <?= date('d-m-Y h:i A', strtotime($row['created_at'])) ?></p>

            <?php if ($row['status'] === 'Delivered'): ?>
              <div class="alert alert-success mt-2"> Delivered orders can't be modified.</div>
            <?php else: ?>
              <form method="post" class="mt-2 d-flex gap-2">
                <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                <select name="status" class="form-select w-auto">
                  <option <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                  <option <?= $row['status'] === 'Processing' ? 'selected' : '' ?>>Processing</option>
                  <option <?= $row['status'] === 'Ready to Delivery' ? 'selected' : '' ?>>Ready to Delivery</option>
                  <option <?= $row['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                </select>
                <button type="submit" class="btn btn-primary">Update</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
     <?php if (!$hasOrders): ?>
    <div class="col-12 text-center text-muted">
      <p class="fs-5 mt-5"> No orders found.</p>
    </div>
  <?php endif; ?>
  </div>
</div>

<!-- Filters JS -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".order-card");

  function filterOrders() {
    const dateVal = document.getElementById("filter-date").value;
    const statusVal = document.getElementById("filter-status").value.toLowerCase();
    const searchVal = document.getElementById("filter-text").value.toLowerCase();

    cards.forEach(card => {
      const date = card.dataset.date;
      const status = card.dataset.status;
      const name = card.dataset.name;
      const email = card.dataset.email;
      const phone = card.dataset.phone;

      const matchDate = !dateVal || date === dateVal;
      const matchStatus = !statusVal || status === statusVal;
      const matchText = !searchVal || name.includes(searchVal) || email.includes(searchVal) || phone.includes(searchVal);

      card.style.display = (matchDate && matchStatus && matchText) ? "block" : "none";
    });
  }

  document.getElementById("filter-date").addEventListener("change", filterOrders);
  document.getElementById("filter-status").addEventListener("change", filterOrders);
  document.getElementById("filter-text").addEventListener("keyup", filterOrders);
});
</script>
</body>
</html>
