<?php 
	$cnx = new mysqli('localhost', 'root', 'password1', 'demo');
	
	if ($cnx->connection_error) {
		die('Connection failed: ' . $cnx->connect_error);
	}
	$index = filter_input(INPUT_POST, 'directedIndex', FILTER_VALIDATE_INT);
	if ($index == null || $index == FALSE) {
		echo "Invalid index. Check again.";
	} else {
		//echo $index;
		$cnx = new mysqli('localhost', 'root', 'password1', 'demo');
		if ($cnx->connect_error) {
			die('Connection failed: ' . $cnx->connect_error);
		}
		
		$ProductName = "";
		$ProductPrice = 0.0;
		
		$query = 'SELECT * FROM PRODUCTS;'; 
    		$cursor = $cnx->query($query);
    		$counter = 1;
    		
		while ($row = $cursor->fetch_assoc()) {
			//echo $counter;
			if ($counter==$index) {
				//echo " Yes ";
				$ProductName = $row['ProductName'];
				$ProductPrice = $row['ProductPrice'];
				$MarkedPrice = round(0.05*$ProductPrice + $ProductPrice,2);
				$ProductPrice = $MarkedPrice;
			}
			$counter++;
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="checkout.css">
</head>
<body>

<h2>Checkout Form</h2>
<p>Please fill in your information.</p>
<div class="row">
  <div class="col-75">
    <div class="container">
      <form action="addOrder.php" method="post" id="create">
      
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fname">Full Name</label>
            <input type="text" id="fname" name="fullname" placeholder="John E. Doe" required>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="john@example.com" required>
            <label for="adr">Address</label>
            <input type="text" id="adr" name="address" placeholder="641 J. 20th Street" required>
            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="Newark" required>
            <label for="state">State</label>
            <input type="text" id="state" name="state" placeholder="NJ" required>
            <label for="zip">Zip</label>
            <input type="text" id="zip" name="zip" placeholder="12345" required>
          </div>
	  
	  <!-- We also need to send the product name (the one the customer is buying) -->
	  <input type="hidden" name="product" value="<?php echo $ProductName; ?>">
	  
          <div class="col-50">
            <h3>Payment</h3>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="John Edward Doe" required>
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" required>
            <label for="expdate">Expiration Date</label>
            <input type="text" id="exdate" name="expdate" placeholder="09/2027" required>
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" placeholder="452" required>
          </div>
        </div>
        
        <input type="submit" href="addOrder.php" value="Buy now" class="btn">
      </form>
    </div>
  </div>
  <div class="col-25">
    <div class="container">
      <h4>Cart</h4>
      <p>
      	<a href="#"><?php echo $ProductName; ?></a>
      	<span class="price">$<?php printf("%4.2f", $ProductPrice); ?></span>
      </p>
      <hr>
    </div>
  </div>
</div>

</body>
</html>
