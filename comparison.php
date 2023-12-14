<?php
	$cnx = new mysqli('localhost', 'root', 'password1', 'demo');
    	
	if ($cnx->connect_error) {
		die('Connection failed: ' . $cnx->connect_error);
	}
	$index = filter_input(INPUT_POST, 'index',FILTER_VALIDATE_INT);
	$comparedToIndex = 0; // default, not valid
	if($index == null || $index == FALSE) {
		echo "Invalid index. Check again.";
	} else {
		//echo $index;
		if ($index >=26 && $index <= 50) {
			$comparedToIndex = $index-25;
			//echo $comparedToIndex;
		} else if ($index < 26 && $index <=50) {
			$comparedToIndex = $index+25;
			//echo $comparedToIndex;
		}

		$leftProductName = "";
		$leftProductDescription = "";
		$leftProductPrice = 0.0;
		$leftImageURL = "";
		$leftReviewScore = 0.0;
		
		$rightProductName = "";
		$rightProductDescription = "";
		$rightProductPrice = 0.0;
		$rightImageURL = "";
		$rightReviewScore = 0.0;
		
		$cnx = new mysqli('localhost', 'root', 'password1', 'demo');
		if ($cnx->connect_error) {
			die('Connection failed: ' . $cnx->connect_error);
		}
		
		$query = 'SELECT * FROM PRODUCTS;'; 
    		$cursor = $cnx->query($query);
    		$counter = 1;
    		
		while ($row = $cursor->fetch_assoc()) {
			//echo $counter;
			if ($counter==$index) {
				//echo " Yes ";
				$leftProductName = $row['ProductName'];
				$leftProductDescription = $row['ProductDescription'];
				$leftProductPrice = $row['ProductPrice'];
				$leftImageURL = $row['ImageURL'];
				$leftReviewScore = $row['ReviewScore'];
				//echo $leftReviewScore . "\n";
			}
			if ($counter==$comparedToIndex) {
				//echo " Yep ";
				$rightProductName = $row['ProductName'];
				$rightProductDescription = $row['ProductDescription'];
				$rightProductPrice = $row['ProductPrice'];
				$rightImageURL = $row['ImageURL'];
				$rightReviewScore = $row['ReviewScore'];
				//echo $rightReviewScore . "\n";
			}
			$counter++;
		}
		
		// 5% for Marked up Price
		$leftMarkedPrice = round(0.05*$leftProductPrice + $leftProductPrice,2);
		$rightMarkedPrice = round(0.05*$rightProductPrice + $rightProductPrice,2);
    		$cnx->close();
    	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="comparison.css">
</head>
<body>

<h2 style="text-align:center">Pricing Tables</h2>
<p style="text-align:center">See how your product compares to...</p>

<div class="parent">

<div class="columns">
  <ul class="price">
    <li class="header" style="background-color:#04AA6D; padding:50px;"><?php echo $leftProductName; ?></li>
    <br>
    <li><img src="<?php echo $leftImageURL; ?>" style="width:200px;height:200px;"></li>
    <li><p style="text-align:justify;"><?php echo $leftProductDescription; ?></p></li>
    <li><p>Rating (out of 5): <?php printf("%1.1f", $leftReviewScore); ?></p></li>
    <li class="<?php if($leftProductPrice > $rightProductPrice){
    		     	echo "grey";
    		     } else {
    		     	echo "yellow";
    		     }?>">$ <?php printf("%4.2f", $leftMarkedPrice); ?></li>
    <li class="grey">
    	<form method="post" action="checkout.php" class="inline">
    		<button href="checkout.php" type="submit" name="directedIndex" value="<?php echo $index; ?>" class="button">Buy now</button>
    	</form>
    </li>
  </ul>
</div>

<div class="columns">
  <ul class="price">
    <li class="header" style="background-color:#04AA6D; padding:50px;"><?php echo $rightProductName; ?></li>
    <br>
    <li><img src="<?php echo $rightImageURL; ?>" style="width:200px;height:200px;"></li>
    <li><p style="text-align:justify;"><?php echo $rightProductDescription; ?></p></li>
    <li><p>Rating (out of 5): <?php printf("%1.1f", $rightReviewScore); ?></p></li>
    <li class="<?php if($leftProductPrice > $rightProductPrice){
    		     	echo "yellow";
    		     } else {
    		     	echo "grey";
    		     }?>">$ <?php printf("%4.2f", $rightMarkedPrice); ?></li>
    <li class="grey">
    	<form method="post" action="checkout.php" class="inline">
    		<button href="checkout.php" type="submit" name="directedIndex" value="<?php echo $comparedToIndex; ?>" class="button">Buy now</button>
    	</form>
    </li>
  </ul>
</div>

</body>
</html>


