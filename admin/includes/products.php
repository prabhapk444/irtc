<?php
include "../db.php";

// Get categories
$categories = $conn->query("SELECT id, name FROM category ORDER BY name ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
  $name = trim($_POST['name']);
  $category = intval($_POST['category']);
  $description = trim($_POST['description']);
  $price = floatval($_POST['price']);
  $quantity = intval($_POST['quantity']);
  $is_show = isset($_POST['is_show']) ? 1 : 0;

  $image = $_FILES['image_url'];
  $targetDir = "../images/";
  $imageName = time() . "_" . basename($image["name"]);
  $targetFilePath = $targetDir . $imageName;

  $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
  $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

  if (in_array($imageFileType, $allowedTypes)) {
    if (move_uploaded_file($image["tmp_name"], $targetFilePath)) {
      $imagePathToStore = "images/" . $imageName;

      $stmt = $conn->prepare("INSERT INTO products (name, category_id, description, price, quantity, image_url, is_show) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sissdsi", $name, $category, $description, $price, $quantity, $imagePathToStore, $is_show);
      $stmt->execute();

      echo "<script>alert('Product added successfully'); window.location.href='view.php';</script>";
    } else {
      echo "<script>alert('Failed to upload image');</script>";
    }
  } else {
    echo "<script>alert('Invalid image type');</script>";
  }
}
?>

<style>
 
  .card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }
  .form-control {
    font-size: 14px;
    padding: 10px;
  }
  .form-check-label {
    font-weight: 500;
  }
  .btn-submit {
    background-color: #0d6efd;
    color: #fff;
  }
  .btn-submit:hover {
    background-color: #0a58ca;
  }
</style>
     <h2 class="text-center mb-4">Add New Product</h2>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card p-4">
   
        <form method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="form-select" required>
              <option value="">Select Category</option>
              <?php while($cat = $categories->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="price" class="form-label">Price</label>
              <input type="number" step="0.01" id="price" name="price" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="quantity" class="form-label">Quantity</label>
              <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="image_url" class="form-label">Product Image</label>
            <input type="file" id="image_url" name="image_url" class="form-control" accept="image/*" required>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_show" id="is_show" value="1" required> 
            <label class="form-check-label" for="is_show">Show</label>
          </div>

          <div class="d-grid">
            <button type="submit" name="add" class="btn btn-submit">Add Product</button>
          </div>
        </form>

        <hr class="my-4" />

        <div class="d-flex justify-content-center gap-3">
          <a href="editproduct.php" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil-square"></i> Edit
          </a>
          <a href="view.php" class="btn btn-outline-success btn-sm">
            <i class="bi bi-eye"></i> View
          </a>
        </div>

      </div>
    </div>
  </div>
</div>
