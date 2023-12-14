<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <div class="container">
          <h1>GreenNest Marketplace</h1>
          <h2>Your Source for Wholesome Health in Every Item</h2>
          <a href="#shop" class="btn btn-transparent">Shop now!</a>
        </div>
    </header>
      
    <section class="section--intro">
        <div class="container">
          <div class="col-3 text--center">
            <img src="images/man.jpg"/>
          </div>
          <div class="col-7 details">
            <h3>Elevate Wellness, Multiply your Savings</h3>
            <p>Welcome to GreenNest, your sanctuary for mindful living. Explore a curated realm of wholesale wonders, including everyday essentials, nurturing multivitamins, and a touch of home comfort. Join us in creating a greener haven, where each product tells a story of wellness and connection, from our nest to yours.</p>
          </div>
        </div>
    </section>
      
    <section class="section--primary">
        <div class="container">
          <div class="col-3 features">
            <p>We're not just a store; we're on a mission. GreenNest is dedicated to providing eco-friendly wholesale goods, shaping a sustainable future with purposeful purchases.</p>
          </div>
          <div class="col-3 features">
            <p>Here, you're part of a community making mindful choices for positive impact. Your role isn't just a customer; it's a conscious contributor to global change.</p>
          </div>
          <div class="col-3 features">
            <p>Ready to explore? Check our products at the bottom!</p>
          </div>
        </div>
    </section>
      
    <section class="section--primary--alt">
        <div class="container">
          <h3>Authentic Experience Guarantee</h3>
          <p>GreenNest believes in being upfront. Our commitment to quality isn't a marketing pitch – it's our standard. Whether it's everyday essentials or nurturing multivitamins, rest assured, what you see is what you get. Choose GreenNest for an honest shopping experience where quality is a given.</p>
        </div>
    </section>
      
    <section class="section--primary--light">
        <div class="container">
          <blockquote class="testimonial">
            <p>Took a chance on GreenNest's multivitamins and protein bars; best decision ever! Months of use, and I'm a devoted fan. Quality, taste, and satisfaction that exceeded expectations.</p>
            <cite>
              Satisfied Customer
            </cite>
          </blockquote>
        </div>
    </section>
      
    <section class="section--primary--alt">
        <div class="container text--center">
          <h3>Why us?</h3>
          <div class="col-5 text--left">
            <ul>
              <li>Exceptional Quality</li>
              <li>Sourced from Trusted Farms</li>
              <li>Eco-Friendly Choices</li>
            </ul>
          </div>
          <div class="col-5 text--left">
            <ul>
              <li>Affordable Prices</li>
              <li>Convenient Shopping</li>
              <li>Wellness-Driven Selection</li>
            </ul>
          </div>
        </div>
    </section>
      
    <section class="text--center">
        <div class="container">
          <h3 id="shop">What are you waiting for?</h3>
        </div>
    </section>
    
    <center>
	<table align="center" border="1">
	<?php
		$cnx = new mysqli('localhost', 'root', 'password1', 'demo');
    	
		if ($cnx->connect_error) {
	     		die('Connection failed: ' . $cnx->connect_error);
		}
		$query = 'SELECT * FROM PRODUCTS'; 
    		$cursor = $cnx->query($query);
    		
    		$index = 1;
    		while ($row = $cursor->fetch_assoc()) {
        		$str = '<img style="border-width:100px; width:200px;" src="' . $row['ImageURL'] . '">';
        		echo '<tr>';
        			echo '<td><center>';
        				echo '<form method="post" action="comparison.php" class="inline">';
        				echo '<button class="item" type="submit" name="index" value="' . $index . '" href="comparison.php">' . $row['ProductName'] . '</button>';
        				echo '</form>';
        			echo '</center></td>';
        			echo '<td>' . $str . '</td>';
        		echo '</tr>';
        		$index++;
    		}
    		$cnx->close();
	?>
	</table>
    </center>
    
    <br>
    
    <footer>
        <div class="container">
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
          <p>&copy; 2023 GreenNest. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

