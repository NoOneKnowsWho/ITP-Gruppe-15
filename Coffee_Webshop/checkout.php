<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <title>Checkout</title>
  <style>
    .checkout-item {
      border-bottom: 1px solid #ccc;
      padding: 10px 0;
    }
    .checkout-item img {
      width: 50px;
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  
  <h1>Ihr Warenkorb</h1>
  <div id="checkoutContainer"></div>
  <div id="totalSum"></div>

  <script src="checkout.js"></script>
  <a href="VielenDank.php" style="padding: 10px 20px; background-color:rgb(2, 2, 3); color: white; text-decoration: none; border-radius: 5px;">Zahlen</a>
  <?php include 'footer.php'; ?>
</body>
</html>