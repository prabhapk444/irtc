<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us - Railway Food Ordering System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .about-section {
      padding: 60px 20px;
    }
    .about-title {
      color: royalblue;
      font-weight: bold;
    }
    .highlight {
      font-weight: 600;
    }
    .mission-vision {
      
      padding: 50px 20px;
      border-radius: 10px;
    }
    .mission-vision h2 {
      color: royalblue;
      font-weight: bold;
    }
  </style>
</head>
<body>

<?php include("header.php"); ?>

<div class="about-section">
  <div class="container">
    <h1 class="text-center mb-4 about-title text-dark">About Railway Food Ordering System</h1>

    <div class="row align-items-center">
      <div class="col-md-6">
        <p class="fs-5">
          <strong>Railway Food Ordering System</strong> is a convenient platform designed to help passengers pre-order fresh and hygienic meals directly to their train seat. We aim to revolutionize the way food is accessed during train journeys across India.
        </p>
        <p class="fs-5">
          Whether it's <span class="highlight text-warning">biryani, dosa, snacks</span>, or fresh juices, we partner with local vendors and quality restaurants to deliver hot and tasty food at your station stop. You can browse products, place orders, track your status, and enjoy a smooth experience.
        </p>
      </div>
      <div class="col-md-6">
        <img src="images/about.jpg" alt="About Food Delivery" class="img-fluid rounded shadow">
      </div>
    </div>

     <div class="mission-vision text-center">
      <div class="row">
        <div class="col-md-6 mb-4">
          <h2 class="text-warning">Our Mission</h2>
          <p class="fs-5">To ensure every railway passenger gets access to hygienic, tasty, and timely food at their convenience, making train travel more enjoyable.</p>
        </div>
        <div class="col-md-6 mb-4">
          <h2  class="text-warning">Our Vision</h2>
          <p class="fs-5">To become India's most trusted and widespread railway food delivery network, serving every train and every station with excellence.</p>
        </div>
      </div>
    </div><br><br>

    

     <h3 class="text-center mb-4 about-title text-dark">Our Core Values</h3>

<div class="row text-center">
  <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title text-warning">Easy Ordering</h5>
        <p class="card-text">Simple steps to select and order your favorite food from our app or website.</p>
      </div>
    </div>
  </div>

  <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title text-warning">Quality Vendors</h5>
        <p class="card-text">We partner with FSSAI-registered restaurants for safe and hygienic meals.</p>
      </div>
    </div>
  </div>

  <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title text-warning">On-Time Delivery</h5>
        <p class="card-text">Food delivered directly to your train seat at the selected station – fresh and hot!</p>
      </div>
    </div>
  </div>
</div>


    <hr class="my-5" />


   

  </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>
