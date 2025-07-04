<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    
    include("header.php");
    ?>
  <div class="container my-5">
    <h2 class="mb-4">Your Shopping Cart</h2>
    <div id="cart-items"></div>
    <div class="mt-4 text-end">
      <button id="process-order" class="btn btn-warning">Process Order</button>
    </div>
  </div>


  <?php
    
    include("footer.php");
    ?>

  <script>
    function renderCart() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const cartContainer = document.getElementById('cart-items');
      if (cart.length === 0) {
        cartContainer.innerHTML = "<div class='alert alert-warning'>Your cart is empty.</div>";
        return;
      }

      let html = "<table class='table'><thead><tr><th>Image</th><th>Name</th><th>Qty</th><th>Price</th><th>Actions</th></tr></thead><tbody>";
      cart.forEach((item, index) => {
        html += `<tr>
          <td><img src="${item.image}" width="60" /></td>
          <td>${item.name}</td>
          <td>
            <button class="btn btn-sm btn-secondary me-1" onclick="changeQty(${index}, -1)">-</button>
            ${item.qty}
            <button class="btn btn-sm btn-secondary ms-1" onclick="changeQty(${index}, 1)">+</button>
          </td>
          <td>₹${(item.qty * item.price).toFixed(2)}</td>
          <td><button class="btn btn-sm btn-danger" onclick="removeItem(${index})">Remove</button></td>
        </tr>`;
      });
      html += "</tbody></table>";
      cartContainer.innerHTML = html;
    }

    function changeQty(index, delta) {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart[index].qty += delta;
      if (cart[index].qty <= 0) cart.splice(index, 1);
      localStorage.setItem('cart', JSON.stringify(cart));
      renderCart();
    }

    function removeItem(index) {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart.splice(index, 1);
      localStorage.setItem('cart', JSON.stringify(cart));
      renderCart();
    }

    document.getElementById("process-order").addEventListener("click", () => {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      if (cart.length === 0) {
        alert("Cart is empty!");
        return;
      }

 
      localStorage.setItem('order_data', JSON.stringify(cart));
      window.location.href = "order.php";
    });

    renderCart();
  </script>
</body>
</html>
