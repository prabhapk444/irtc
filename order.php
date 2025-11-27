<!DOCTYPE html>
<html>
<head>
  <title>Order Summary</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

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
          <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="col-12">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="col-12">
          <label for="phone" class="form-label">Phone Number</label>
          <input type="tel" id="phone" name="phone" class="form-control" required>
        </div>

        <div class="col-12">
          <label for="train_no" class="form-label">Train Number</label>
          <input type="text" id="train_no" name="train_no" class="form-control" required>
        </div>

        <div class="col-12">
          <label for="station" class="form-label">Delivery Station</label>
          <input type="text" id="station" name="station" class="form-control" required>
        </div>

        <div class="col-12">
          <label class="form-label">Payment Method</label>
          <select id="payment_method" name="payment_method" class="form-select" required>
            <option value="">Select Payment Method</option>
            <option value="cash">Cash</option>
            <option value="online">Online</option>
          </select>
        </div>

        <!-- Hidden Grand Total -->
        <input type="hidden" id="hiddenAmount">

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

      html += `
        <tr>
          <td>${item.name}</td>
          <td>${item.qty}</td>
          <td>₹${item.price}</td>
          <td>₹${total.toFixed(2)}</td>
        </tr>`;
    });

    html += `</tbody><tfoot>
      <tr><td colspan="3"><strong>Total</strong></td>
      <td><strong>₹${grandTotal.toFixed(2)}</strong></td></tr></tfoot></table>`;

    document.getElementById("order-summary").innerHTML = html;
    document.getElementById("hiddenAmount").value = grandTotal;
  }

  renderOrder();


 function submitFinalOrder() {
  const form = document.getElementById("order-form");
  const formData = new FormData(form);
  const userDetails = Object.fromEntries(formData.entries());

  console.log("Submitting order:", userDetails, orderData);

  fetch("submit_order.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ...userDetails, items: orderData })
  })
  .then(res => {
    console.log("Response status:", res.status);
    return res.json();
  })
  .then(data => {
    console.log("Response data:", data);
    if(data.success){
      Swal.fire("Order Placed!", "Redirecting to Home...", "success")
      .then(()=>{
        localStorage.removeItem("cart");
        localStorage.removeItem("order_data");
        window.location.href = "home.php";
      });
    } else {
      Swal.fire("Failed!", "Something went wrong.", "error");
    }
  })
  .catch(error => {
    console.error("Error submitting order:", error);
    Swal.fire("Error!", "Failed to submit order.", "error");
  });
}



  $("#payment_method").change(function () {

    let allValid = true;

    $("#order-form input[required]").each(function(){
      if($(this).val().trim() === ""){
        allValid = false;
      }
    });

    if(!allValid){
      Swal.fire("Incomplete Form", "Please fill all form fields first.", "warning");
      $(this).val("");
      return;
    }

    if($(this).val() === "online"){
        
        let amount = document.getElementById("hiddenAmount").value * 100;

        let options = {
          "key": "rzp_live_jTgfBBLTMsGEcf",
          "amount": amount,
          "currency": "INR",
          "name": "Railway Food Ordering System",
          "description": "Order Payment",
          "handler": function (response){
              Swal.fire("Payment Successful!", "", "success").then(()=>{
                  submitFinalOrder();
              });
          },
          "theme": { "color": "#F37254" }
        };

        let rzp1 = new Razorpay(options);
        rzp1.open();
    }
  });

  


  

 document.getElementById("order-form").addEventListener("submit", function(e){
    e.preventDefault();
    submitFinalOrder();
});


</script>

</body>
</html>
