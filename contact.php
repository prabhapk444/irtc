<?php
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);
  $submitted = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .contact-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 15px;
    }
    .contact-form {
      background-color: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    @media (max-width: 768px) {
      .contact-img {
        height: 200px;
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>

<?php include("header.php"); ?> 

<div class="container my-5">
  <h1 class="text-center mb-4 text-dark">Get in Touch</h1>
  
  <div class="row align-items-center">
    
    
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="images/Contact us.gif" alt="Contact Us" class="contact-img">
    </div>

  
    <div class="col-md-6">
      <div class="contact-form">
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
          </div>

          <button type="submit" class="btn btn-warning w-100">Send Message</button>
        </form>
      </div>
    </div>

  </div>
</div>

<?php include("footer.php"); ?>

<?php if ($submitted): ?>
<script>
  alert("Thank you! Your message has been received.");
</script>
<?php endif; ?>

</body>
</html>
