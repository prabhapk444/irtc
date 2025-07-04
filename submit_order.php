<?php
include("db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['items'])) {
  echo json_encode(['success' => false, 'message' => 'No data received']);
  exit;
}

$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);
$phone = $conn->real_escape_string($data['phone']);
$train_no = $conn->real_escape_string($data['train_no']);
$station = $conn->real_escape_string($data['station']);
$total_price = 0;


foreach ($data['items'] as $item) {
  $total_price += $item['qty'] * $item['price'];
}

$stmt = $conn->prepare("INSERT INTO orders (name, email, phone, train_no, station, total_price, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssssd", $name, $email, $phone, $train_no, $station, $total_price);

$stmt->execute();
$order_id = $stmt->insert_id;

foreach ($data['items'] as $item) {
  $pid = intval($item['id']);
  $qty = intval($item['qty']);
  $price = floatval($item['price']);

  $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) 
                VALUES ($order_id, $pid, $qty, $price)");

 
  $conn->query("UPDATE products SET quantity = quantity - $qty WHERE id = $pid");
}

echo json_encode(['success' => true]);
