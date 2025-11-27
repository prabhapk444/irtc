<?php
session_start();
require 'db.php';
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['items'])) {
  echo json_encode(['success' => false, 'message' => 'No data received']);
  exit;
}

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);
$phone = $conn->real_escape_string($data['phone']);
$train_no = $conn->real_escape_string($data['train_no']);
$station = $conn->real_escape_string($data['station']);
$payment = $conn->real_escape_string($data['payment_method']);
$total_price = 0;


foreach ($data['items'] as $item) {
  $total_price += $item['qty'] * $item['price'];
}

$stmt = $conn->prepare("INSERT INTO orders (user_id, name, email, phone, train_no, station, payment_method, total_price, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("isssssds", $user_id, $name, $email, $phone, $train_no, $station, $payment, $total_price);

$stmt->execute();
$order_id = $stmt->insert_id;


foreach ($data['items'] as $item) {
  $pid = intval($item['id']);
  $qty = intval($item['qty']);
  $price = floatval($item['price']);

  $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $pid, $qty, $price)");
  $conn->query("UPDATE products SET quantity = quantity - $qty WHERE id = $pid");
}


$orderDetails = "<table border='1' cellspacing='0' cellpadding='8' style='border-collapse: collapse; width: 100%;'>
<tr style='background-color: #f2f2f2;'>
  <th>Product</th>
  <th>Quantity</th>
  <th>Price</th>
  <th>Total</th>
</tr>";

foreach ($data['items'] as $item) {
  $pname = htmlspecialchars($item['name']);
  $qty = intval($item['qty']);
  $price = number_format($item['price'], 2);
  $total = number_format($item['qty'] * $item['price'], 2);
  $orderDetails .= "
  <tr>
    <td>$pname</td>
    <td>$qty</td>
    <td>₹$price</td>
    <td>₹$total</td>
  </tr>";
}

$orderDetails .= "<tr>
  <td colspan='3'><strong>Grand Total</strong></td>
  <td><strong>₹" . number_format($total_price, 2) . "</strong></td>
</tr></table>";


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
  $mail->addAddress($email, $name);
  $mail->isHTML(true);
  $mail->Subject = 'Order Confirmation - Railway Food Ordering';
  $mail->Body = "
    <h3>Hello $name,</h3>
    <p>Your order has been successfully placed. Thank you for using our Railway Food Ordering System!</p>
    <p><strong>Order ID:</strong> $order_id</p>
    <p><strong>Train No:</strong> $train_no</p>
    <p><strong>Delivery Station:</strong> $station</p>
    <p><strong>Payment Method:</strong> " . ucfirst($payment) . "</p>
    <h4>Order Details:</h4>
    $orderDetails
    <br><p>You can track your order from the My Order page.</p>
    <p>Thank You!<br><strong>Railway Food Ordering Team</strong></p>
  ";

  $mail->send();
} catch (Exception $e) {

}

echo json_encode(['success' => true]);
