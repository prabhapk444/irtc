<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    .login-container {
      height: 100vh;
    }
    .login-image {
      background: url('images/Admin.png') no-repeat center center;
      background-size: cover;
      height: 100%;
    }
    .login-form {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
      padding: 40px;
    }
    .login-box {
      width: 100%;
      max-width: 400px;
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn-login {
      background-color: royalblue;
      color: white;
    }
    .btn-login:hover {
      background-color: darkblue;
    }
  </style>
</head>
<body>

<div class="container-fluid login-container">
  <div class="row h-100">
    <!-- Left Side Image -->
    <div class="col-md-6 d-none d-md-block p-0 login-image"></div>

    <!-- Right Side Form -->
    <div class="col-md-6 login-form">
      <div class="login-box">
        <h3 class="text-center text-primary mb-4">Admin Login</h3>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required />
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-login">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));


    if (strtolower($username) !== 'admin') {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: 'Only admin user is allowed!'
            });
        </script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($adminPassword);
        $stmt->fetch();

        if (password_verify($password, $adminPassword)) {
            $_SESSION['admin'] = $username;
            echo "<script>
              Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'Redirecting to Dashboard...',
                timer: 2000,
                showConfirmButton: false
              }).then(() => {
                window.location.href = 'dashboard.php';
              });
            </script>";
        } else {
            echo "<script>
              Swal.fire({
                icon: 'error',
                title: 'Incorrect Password',
                text: 'Please try again!'
              });
            </script>";
        }
    } else {
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'User Not Found',
            text: 'No admin found with that username.'
          });
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
