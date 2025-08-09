<?php
include "../db.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get and delete the image file
    $res = $conn->query("SELECT image_url FROM products WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $image = "../" . $row['image_url'];
        if (file_exists($image)) {
            unlink($image);
        }
    }

    // Attempt to delete the product
    if ($conn->query("DELETE FROM products WHERE id = $id") === TRUE) {
        header("Location: view.php");
        exit();
    } else {
        // Show error message
        echo "Error deleting product: " . $conn->error;
    }
}
?>
