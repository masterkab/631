<?php
include 'dbconnect.php';
session_start();

$nextItemNo=0;
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
				// First, check to verify that the book is not in the cart already
				$sqlStr2="SELECT itemqty FROM carts WHERE username='".$_SESSION['usern']."' AND itemisbn='".$_POST['add']."'";
				$result2=mysqli_query($con,$sqlStr2);
				if($result2->num_rows!=0) { // we expect this to be zero if not in table
					// The book is already in the cart.  
					$nextItemNo--;
					$mySel2=$result2->fetch_assoc();
					// Are there enough books in stock to add one more?
					if(($mySel2['itemqty']+1)>$mySel['quantity']) { // no
						$retVal=false;
						$errMsg="Insufficient inventory to meet request.";
					} else { // yes 
						$sqlStr3="UPDATE carts SET itemqty=itemqty+1 WHERE itemisbn='".$_POST['add']."'";
						$sqlStmt3=$con->prepare($sqlStr3);
						if($result=mysqli_stmt_execute($sqlStmt3)==1) {
							$retVal=true;
							$errMsg=$mySel["title"] . ' has been added to your shopping cart.';
						} else {
							$retVal=false;
							$errMsg='Error on UPDATE';
						}
					}
				} else {
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
						error_log("Query: ".$sqlStmt);
					}
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

echo "$retVal:$errMsg:$nextItemNo:";

?>
