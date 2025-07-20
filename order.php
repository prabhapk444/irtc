<!DOCTYPE html>
<html>
<head>
  <title>Order Summary</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
     .form-wrapper {
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    padding: 30px;
    background-color: #fff;
  }
  </style>
</head>
<body>

<?php include("header.php"); ?>

<div class="container my-5">
  <h2>Order Summary</h2>
  <div id="order-summary"></div>
<div class="container mt-5">
  <h4 class="text-center mb-4">Enter Your Details</h4>
  <div class="form-wrapper col-md-6 mx-auto">
    <form id="order-form" class="row g-3">
      <div class="col-12">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required />
      </div>
      <div class="col-12">
       <label for="email" class="form-label">Email</label>
       <input type="email" name="email" id="email" class="form-control" placeholder="enter your email id" required>
      </div>
      <div class="col-12">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required />
      </div>
      <div class="col-12">
        <label for="train_no" class="form-label">Train Number</label>
        <input type="text" id="train_no" name="train_no" class="form-control" placeholder="Enter train number" required />
      </div>
      <div class="col-12">
        <label for="station" class="form-label">Delivery Station</label>
        <input type="text" id="station" name="station" class="form-control" placeholder="Enter station name" required />
      </div>
       <div class="col-12">
    <label for="payment_method" class="form-label">Payment Method</label>
    <select id="payment_method" name="payment_method" class="form-select" required>
      <option value="">Select Payment Method </option>
      <option value="cash">Cash</option>
      <option value="online">Online</option>
    </select>
  </div>


      <div class="col-12">
        <button type="submit" class="btn btn-warning">Place Order</button>
      </div>
    </form>
  </div>
</div>

</div>

<?php include("footer.php"); ?>
<script>
  const orderData = JSON.parse(localStorage.getItem('order_data') || '[]');

  function renderOrder() {
    if (!orderData.length) {
      document.getElementById("order-summary").innerHTML =
        "<div class='alert alert-danger'>No order data found.</div>";
      return;
    }

    let html = "<table class='table'><thead><tr><th>Name</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>";
    let grandTotal = 0;
    orderData.forEach(item => {
      const total = item.qty * item.price;
      grandTotal += total;
      html += `<tr>
        <td>${item.name}</td>
        <td>${item.qty}</td>
        <td>₹${item.price}</td>
        <td>₹${total.toFixed(2)}</td>
      </tr>`;
    });
    html += `</tbody><tfoot><tr><td colspan="3"><strong>Total</strong></td><td><strong>₹${grandTotal.toFixed(2)}</strong></td></tr></tfoot></table>`;
    document.getElementById("order-summary").innerHTML = html;
  }

  document.getElementById('order-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const userDetails = Object.fromEntries(formData.entries());

    fetch('submit_order.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        ...userDetails,
        items: orderData
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          title: "Order Placed!",
          text: "Your order was placed successfully. You’ll be redirected to Home page.",
          icon: "success",
          confirmButtonColor: "#ffc107",
          confirmButtonText: "OK"
        }).then(() => {
          localStorage.removeItem("cart");
          localStorage.removeItem("order_data");
          window.location.href = "home.php";
        });
      } else {
        Swal.fire({
          title: "Failed!",
          text: "Failed to place order. Please try again.",
          icon: "error",
          confirmButtonColor: "#dc3545"
        });
      }
    });
  });

  renderOrder();
</script>


</body>
</html>
