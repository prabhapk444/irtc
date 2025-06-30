<?php
include "../db.php";
$result = $conn->query("SELECT username, email, phone, created_at FROM register ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registered Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
     
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      margin-top: 40px;
    }
    .table-wrapper {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 20px;
      font-weight: 600;
      color: royalblue;
    }
  
    table tbody tr:hover {
      background-color: #f1f1f1;
    }
    .no-data {
      text-align: center;
      color: #888;
      font-style: italic;
      padding: 20px;
    }
  </style>
</head>
<body>

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

</body>
</html>
