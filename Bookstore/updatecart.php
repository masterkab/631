<?php
include 'dbconnect.php';
session_start();

if ($_SESSION['usern'] != '') { // Is a user logged in?
	if(isset($_POST['isbn']) && !empty($_POST['isbn']) &&
	  (isset($_POST['quantity']) && !empty($_POST['quantity']))) {
		$newQty=$_POST['quantity'];
		// We need the quantity of the book
		$sqlStmt="SELECT quantity,title FROM books WHERE isbn='" .
		$_POST['isbn'] . "'";
		$result=mysqli_query($con,$sqlStmt);
		if($result->num_rows!=0) {
			$mySel=$result->fetch_assoc();
			$inStock=$mySel["quantity"];
			if($inStock >= $newQty) { // There must be enough books
				// Update the book in the cart.
				$myPrice=$mySel["price"];
				$sqlStr="UPDATE carts SET itemqty='". $_POST["quantity"] . "' WHERE username='" . $_SESSION['usern'] . "' AND itemisbn='" . $_POST["isbn"] ."'";
				$sqlStmt=$con->prepare($sqlStr);
				if($result=mysqli_stmt_execute($sqlStmt)==1) {
					$retVal=true;
					$errMsg=$mySel["title"] . ' quantity has been updated your shopping cart.';
				} else {
					// Something went wrong here.
					$retVal=false;
					$errMsg='Error on UPDATE.';
				}
			} else {
				// Not enough books in stock, so we don't try to update.
				$retVal=false;
				$errMsg=$_POST['title'].' is unavailable in that quantity';
			}
		} else {
			// This should never happen, but the book wasn't found.
			$retVal=false;
			$errMsg=$_POST['isbn'] . "not found in database.";
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
