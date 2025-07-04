<?php
include "../db.php";

$action = ""; 
if (isset($_POST['add'])) {
  $name = trim($_POST['name']);
  if ($name !== "") {
    $stmt = $conn->prepare("INSERT INTO category (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $action = "added";
  }
}


if (isset($_POST['update'])) {
  $id = intval($_POST['id']);
  $name = trim($_POST['name']);
  if ($name !== "") {
    $stmt = $conn->prepare("UPDATE category SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $action = "updated";
  }
}


if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM category WHERE id = $id");
  $action = "deleted";
}

$result = $conn->query("SELECT * FROM category ORDER BY id DESC");
?>


<style>
  .form-inline input {
    max-width: 300px;
  }
  .table-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
  }
</style>

<div class="card p-4">
  <h4 class="mb-3">Category Management</h4>

 
  <form method="POST" class="row g-2 align-items-center mb-4">
    <div class="col-auto">
      <input type="text" name="name" class="form-control" placeholder="Enter category name" required />
    </div>
    <div class="col-auto">
      <button type="submit" name="add" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Category
      </button>
    </div>
  </form>


  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Category Name</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td>
              <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['id']): ?>
                <form method="POST" class="d-flex">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <input type="text" name="name" class="form-control me-2" value="<?= htmlspecialchars($row['name']) ?>" required>
                  <button type="submit" name="update" class="btn btn-success btn-sm me-1">✔️</button>
                  <a href="?page=category" class="btn btn-secondary btn-sm">❌</a>
                </form>
              <?php else: ?>
                <?= htmlspecialchars($row['name']) ?>
              <?php endif; ?>
            </td>
            <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
            <td class="table-actions">
              <a href="?page=category&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
              <a href="?page=category&delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                <i class="bi bi-trash3"></i> Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>


<?php if ($action): ?>
  <script>
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: 'Category <?= $action ?> successfully!',
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    });
   
    setTimeout(() => {
      window.location.href = "?page=category";
    }, 2200);
  </script>
<?php endif; ?>
