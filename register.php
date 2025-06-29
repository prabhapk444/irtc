<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
     
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 450px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1 {
      font-size: 24px;
      text-align: center;
      margin-bottom: 20px;
      color: #222;
    }

    .form {
      background-color: #fff;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .title {
      font-size: 28px;
      color: royalblue;
      font-weight: 700;
      text-align: center;
    }

    .form label {
      position: relative;
      display: flex;
      flex-direction: column;
    }

    .form .input {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
      outline: none;
    }

    .form span {
      position: absolute;
      top: 12px;
      left: 15px;
      color: #777;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .form .input:focus + span,
    .form .input:valid + span {
      top: -10px;
      left: 10px;
      font-size: 12px;
      color: royalblue;
      background: white;
      padding: 0 5px;
    }

    .submit {
      background-color: royalblue;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .submit:hover {
      background-color: darkblue;
      cursor: pointer;
    }

    .signin {
      text-align: center;
      font-size: 14px;
    }

    .signin a {
      color: royalblue;
      text-decoration: none;
    }

    .signin a:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .form {
        padding: 20px;
      }
      h1, .title {
        font-size: 22px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Railway Food Ordering System</h1>

  <form class="form" method="POST" action="#">
    <p class="title">Register</p>

    <label>
      <input class="input" type="text" name="username" required />
      <span>Name</span>
    </label>

    <label>
      <input class="input" type="email" name="email" required />
      <span>Email</span>
    </label>

    <label>
      <input class="input" type="tel" name="phone" required pattern="[0-9]{10}" />
      <span>Phone Number</span>
    </label>

    <label>
      <input class="input" type="password" name="password" required />
      <span>Password</span>
    </label>

    <button class="submit" type="submit">Submit</button>

    <p class="signin">Already have an account? <a href="login.php">Sign In</a></p>
  </form>
</div>

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    
    $stmt = $conn->prepare("INSERT INTO register (username, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $phone, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
