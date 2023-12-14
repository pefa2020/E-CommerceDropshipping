<?php
	$cnx = new mysqli('localhost', 'root', 'password1', 'demo');
	
	if ($cnx->connection_error) {
		die('Connection failed: ' . $cnx->connect_error);
	}
	//echo "SUCCESS";
	
	$ProductName = filter_input(INPUT_POST, 'product');
	//echo $product;
	
	$FullName = filter_input(INPUT_POST, 'fullname');
	//echo $FullName;

	$Email = filter_input(INPUT_POST, 'email');
	//echo $Email;
	
	$Address = filter_input(INPUT_POST, 'address');
	//echo $Address;
	
	$City = filter_input(INPUT_POST, 'city');
	//echo $City;
	
	$State = filter_input(INPUT_POST, 'state');
	//echo $State;
	
	$Zip = filter_input(INPUT_POST, 'zip');
	//echo $Zip;
	
	$CardName = filter_input(INPUT_POST, 'cardname');
	//echo $CardName;
	
	$CardNumber = filter_input(INPUT_POST, 'cardnumber');
	//echo $CardNumber;
	
	$ExpDate = filter_input(INPUT_POST, 'expdate');
	//echo $ExpDate;
	
	$Cvv = filter_input(INPUT_POST, 'cvv');
	//echo $Cvv;

	if ($ProductName == null || $ProductName == FALSE) {
		echo "Invalid index. Check again.";
	} else {
		echo $ProductName;
		echo "About to insert";
		$insertQuery = 'INSERT INTO ORDERS (ProductName, FullName, Email, Address, City, State, Zip, CardName, CardNumber, ExpDate, Cvv) VALUES("' . $ProductName . '", "' . $FullName . '",  "' . $Email . '", "' . $Address . '", "' . $City . '", "' . $State . '", "' . $Zip . '", "' . $CardName . '", "' . $CardNumber . '", "' . $ExpDate . '", ' . $Cvv . ')';
		$cnx->autocommit(FALSE);
		$cnx->query($insertQuery);
		if (!$cnx -> commit()) {
			echo "Commit transaction failed";
		} else {
			echo "Transaction SUCCESSFUL";
			header("Location: home.php");
			exit();
			
		}
	}
	
	$cnx->close();
	
?>
