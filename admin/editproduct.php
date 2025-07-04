<?php
include "../db.php";

$product = null;
$message = "";
$success = false;
$categories = $conn->query("SELECT id, name FROM category ORDER BY name ASC");

// Fetch product details by ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = intval($_GET['id']);
  $res = $conn->query("SELECT * FROM products WHERE id = $id");
  if ($res->num_rows > 0) {
    $product = $res->fetch_assoc();
  } else {
    $message = "Product not found.";
  }
}

// Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
  $id = intval($_POST['id']);
  $name = trim($_POST['name']);
  $category = intval($_POST['category']);
  $description = trim($_POST['description']);
  $price = floatval($_POST['price']);
  $quantity = intval($_POST['quantity']);
  $is_show = isset($_POST['is_show']) ? 1 : 0;

  $imagePath = $_POST['existing_image'];
  if (isset($_FILES['image_url']) && $_FILES['image_url']['size'] > 0) {
    $image = $_FILES['image_url'];
    $imageName = time() . "_" . basename($image['name']);
    $targetDir = "../images/";
    $targetFilePath = $targetDir . $imageName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($imageFileType, $allowedTypes)) {
      if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
        if (file_exists("../" . $imagePath)) {
          unlink("../" . $imagePath);
        }
        $imagePath = "images/" . $imageName;
      } else {
        $message = "Image upload failed.";
      }
    } else {
      $message = "Invalid image type.";
    }
  }

  // Update DB
  $stmt = $conn->prepare("UPDATE products SET name=?, category_id=?, description=?, price=?, quantity=?, image_url=?, is_show=? WHERE id=?");
  $stmt->bind_param("sissdsii", $name, $category, $description, $price, $quantity, $imagePath, $is_show, $id);
  $stmt->execute();

  $success = true;
  $message = "Product updated successfully!";
  $product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .input-group .form-control {
      max-width: 150px;
    }
    .form-container {
      max-width: 700px;
      margin: auto;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }
    .img-thumbnail {
      max-height: 120px;
    }
  </style>
  <script>
    function fetchProduct() {
      const id = document.getElementById('product_id').value;
      if (id.trim() !== '') {
        window.location.href = `editproduct.php?id=${id}`;
      }
    }
  </script>
</head>
<body>

<div class="container my-5">
  <h2 class="text-center mb-4">Edit Product</h2>

  <!-- Product ID Input -->
  <form method="GET" class="mb-4 text-center">
    <label for="product_id" class="form-label me-2">Enter Product ID</label>
    <div class="input-group justify-content-center">
      <input type="number" id="product_id" name="id" class="form-control" placeholder="ID" required>
      <button type="button" class="btn btn-primary" onclick="fetchProduct()"><i class="bi bi-search"></i></button>
    </div>
  </form>

  <div class="form-container">
    <?php if ($product): ?>
      <!-- Edit Form -->
      <form method="POST" enctype="multipart/form-data" class="card p-4 bg-white">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="hidden" name="existing_image" value="<?= $product['image_url'] ?>">

        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category" class="form-select" required>
            <option value="">Select Category</option>
            <?php while($cat = $categories->fetch_assoc()): ?>
              <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required value="<?= $product['price'] ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" required value="<?= $product['quantity'] ?>">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Current Image</label><br>
          <img src="../<?= $product['image_url'] ?>" class="img-thumbnail">
        </div>

        <div class="mb-3">
          <label class="form-label">Change Image (Optional)</label>
          <input type="file" name="image_url" class="form-control" accept="image/*">
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="is_show" value="1" <?= $product['is_show'] ? 'checked' : '' ?>>
          <label class="form-check-label">Show</label>
        </div>

        <div class="d-grid">
          <button type="submit" name="update" class="btn btn-success">
            <i class="bi bi-save"></i> Update Product
          </button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>

<?php if ($message): ?>
<script>
  Swal.fire({
    icon: '<?= $success ? 'success' : 'error' ?>',
    title: '<?= $success ? 'Success!' : 'Oops!' ?>',
    text: '<?= $message ?>',
    confirmButtonColor: '#3085d6',
  });
</script>
<?php endif; ?>

</body>
</html>
