<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Footer</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    a.text-white:hover i {
  color: royalblue;
  transform: scale(1.1);
  transition: 0.3s ease;
}
@media (max-width: 768px) {
  footer .col-md-4 {
    text-align: center;
    margin-bottom: 1.5rem;
  }
}
hr {
  margin-top: 2rem;
}

</style>
<body>

  <footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-start">
      <div class="row">


      <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
          <h5 class="fw-bold mb-3">Follow Us</h5>
          <a href="#" class="me-3 text-white fs-5"><i class="bi bi-facebook"></i></a>
          <a href="#" class="me-3 text-white fs-5"><i class="bi bi-instagram"></i></a>
          <a href="#" class="me-3 text-white fs-5"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="me-3 text-white fs-5"><i class="bi bi-linkedin"></i></a>
        </div>


        <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
          <h5 class="fw-bold mb-3">Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white text-decoration-none">Home</a></li>
            <li><a href="#" class="text-white text-decoration-none">About</a></li>
            <li><a href="#" class="text-white text-decoration-none">Products</a></li>
            <li><a href="#" class="text-white text-decoration-none">Contact</a></li>
          </ul>
        </div>


        


         <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
          <h5 class="fw-bold mb-3">Support</h5>
          <p>Email: support@railwayfood.in</p>
          <p>Phone: +91 98765 43210</p>
          <p>Hours: 9AM – 9PM</p>
        </div>


      </div>

      <hr class="border-light" />
      <div class="text-center">
        <small>© <?php echo date("Y"); ?> Railway Food Ordering System. All Rights Reserved.</small>
      </div>
    </div>
  </footer>

</body>
</html>
