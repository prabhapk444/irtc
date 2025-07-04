<?php
include "../db.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = intval($_GET['id']);
  

  $res = $conn->query("SELECT image_url FROM products WHERE id = $id");
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $image = "../" . $row['image_url'];
    if (file_exists($image)) {
      unlink($image);
    }
  }

  $conn->query("DELETE FROM products WHERE id = $id");
  header("Location: view.php");
}
?>
