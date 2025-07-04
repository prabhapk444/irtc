<?php
include "../db.php";
$result = $conn->query("SELECT username, email, phone, created_at FROM register ORDER BY created_at DESC");
?>


<div class="container">
  <div class="table-wrapper">
    <h2>Registered Users</h2>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Registered At</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): 
            $i = 1;
            while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
            </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="5" class="no-data">No users found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


