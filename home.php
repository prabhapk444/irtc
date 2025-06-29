<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Railway Food Ordering System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .banner-img {
      height: 600px;
      object-fit: cover;
    }
  </style>
</head>
<body>

<?php include("header.php"); ?>


<div class="text-center py-4">
  <h1 class="text-dark">Welcome to Railway Food Ordering System</h1>
</div>


<div id="foodCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#foodCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#foodCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#foodCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/briyani.jpg" class="d-block w-100 banner-img" alt="Briyani">
    </div>
    <div class="carousel-item">
      <img src="images/dosa.jpg" class="d-block w-100 banner-img" alt="Dosa">
    </div>
    <div class="carousel-item">
      <img src="images/juice.jpg" class="d-block w-100 banner-img" alt="Juice">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#foodCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#foodCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div><br><br>


<div class="container my-5">
  <h2 class="text-center text-dark mb-4">Popular Items on Train</h2>
  <div class="row g-4">

    <!-- Card 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="images/briyani.jpg" class="card-img-top" alt="Briyani">
        <div class="card-body">
          <h5 class="card-title">Spicy Chicken Biryani</h5>
          <p class="card-text">Tasty and hot biryani delivered right to your train seat.</p>
          <a href="products.php" class="btn btn-warning">Buy Now</a>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="images/dosa.jpg" class="card-img-top" alt="Dosa">
        <div class="card-body">
          <h5 class="card-title">Crispy Dosa Varieties</h5>
          <p class="card-text">South Indian dosa with chutneys and sambar onboard.</p>
          <a href="products.php" class="btn btn-warning">Buy Now</a>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="images/juice.jpg" class="card-img-top" alt="Juice">
        <div class="card-body">
          <h5 class="card-title">Fresh Juices & Beverages</h5>
          <p class="card-text">Stay refreshed with a wide range of juices and drinks.</p>
          <a href="products.php" class="btn btn-warning">Buy Now</a>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="text-center">
  <button class="btn btn-warning">View More</button>
</div><br><br>


<?php include("footer.php"); ?>

</body>
</html>
