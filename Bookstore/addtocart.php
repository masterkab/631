<?php
include 'dbconnect.php';
session_start();

if ($_SESSION['usern'] != '') { // Is a user logged in?
	if(isset($_POST['add']) && !empty($_POST['add'])) {
		$sqlStmt="SELECT Count(*) FROM carts WHERE username='" .
		$_SESSION['usern'] . "'";
		// Find the next available item number
		$result=mysqli_query($con, $sqlStmt);
		if($result->num_rows==0) { // if nothing in cart, first is 1
			$nextItemNo=1;
		} else {
			$mySel=$result->fetch_assoc();
			$nextItemNo=$mySel["Count(*)"];
			$nextItemNo++;
		}
		// Now, we need the quantity, price, and title of the book
		$sqlStmt="SELECT price,title,quantity FROM books WHERE isbn='" .
		$_POST['add'] . "'";
		$result=mysqli_query($con,$sqlStmt);
		if($result->num_rows!=0) {
			$mySel=$result->fetch_assoc();
			$inStock=$mySel["quantity"];
			if($inStock>0) { // There must be at least 1 book
				// Add the book to the cart.
				$myPrice=$mySel["price"];
				$sqlStr="INSERT INTO carts (username,itemno,itemisbn,itemqty,itemprice) VALUES('" . $_SESSION['usern'] . "','" . $nextItemNo . "','" . $_POST['add'] . "','1','" . $mySel["price"] . "')";
				$sqlStmt=$con->prepare($sqlStr);
				if($result=mysqli_stmt_execute($sqlStmt)==1) {
					$retVal=true;
					$errMsg=$mySel["title"] . ' has been added to your shopping cart.';
				} else {
					// Something went wrong here.
					$retVal=false;
					$errMsg='Error on INSERT.';
				}
			} else {
				// No books in stock, so we don't try to add.
				$retVal=false;
				$errMsg=$_POST['add'].' is out of stock';
			}
		} else {
			// This should never happen, but the book wasn't found.
			$retVal=false;
			$errMsg=$_POST['add'] . "not found in database.";
		}
	} else {
		// Something went wrong with the POST call.
		$retVal=false;
		$errMsg="Malformed POST request.";
	}
} else {
	// This shouldn't happen.  The user is not logged in.
	$retVal=false;
	$errMsg="Unable to find username in SESSION.";	
}

// Now, send back the result of the operation.
header("Content-type: text/plain");

echo "$retVal:$errMsg";

?>
