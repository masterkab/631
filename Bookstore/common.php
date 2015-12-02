<?php

function harvestBooksFromCancelledOrders($con,$orderno) {
	$sqlStmt="SELECT * FROM orders WHERE ordernumber='".$orderno."'";
	$result=mysqli_query($con,$sqlStmt);
	if($result->num_rows==0) { // fail
		error_log("harvestBooksFromCancelledOrders: order number ".$orderno." not found.");
	} else {
		$sqlStmt="SELECT * FROM items WHERE ordernumber='".$orderno."'";
		$result2=mysqli_query($con,$sqlStmt);
		while($row_array=mysqli_fetch_array($result2)) {
			// put the books back on the shelf
			$inISBN=$row_array['itemisbn'];
			$inQty=$row_array['itemqty'];
			$sqlStr="UPDATE books SET quantity=quantity+".$inQty." WHERE isbn='".$inISBN."'";
			$sqlStmt=$con->prepare($sqlStr);
			if(!($result3=mysqli_stmt_execute($sqlStmt)==1)) {
				error_log("harvestBooksFromCancelledOrders: Failed on update of ".$inISBN." in books table.");
			}
		}
	}
}

function removeBookFromInventory($con,$isbn,$quantity) {
// TODO: implement removeBooksFromInventory
	$sqlStmt="SELECT quantity FROM books WHERE isbn='".$isbn."'";
	$result=mysqli_query($con,$sqlStmt);
	if($result->num_rows==0) { // fail
		error_log("removeBookFromInventory: Unable to locate book ".$isbn." in inventory.");
	} else {
		$mySel=$result->fetch_assoc();
		$inStock=$mySel['quantity'];
		if($inStock>=$quantity) {
			$sqlStr="UPDATE books SET quantity=quantity-".$quantity." WHERE isbn='".$isbn."'";
			$sqlStmt=$con->prepare($sqlStr);
			if(!($result2=mysqli_stmt_execute($sqlStmt)==1)) {
				error_log("removeBooksFromInventory: failed on update of ".$isbn." in books table.");
			}
		}
	}
}

function getCountOfItemsInBasket($con) {

	if (!($_SESSION['usern']=='')) {
		$sqlStmt="SELECT Count(*) AS basketcount FROM carts WHERE username='".$_SESSION['usern']."'";
		$result=$con->query($sqlStmt);
		if($result->num_rows>0) {
			$mySel=$result->fetch_assoc();
			error_log("Found an item");
			$retVal=$mySel['basketcount'];
		} else {
			error_log("Found nothing");
			$retVal=0;
		}
	} else {
		$retVal=0;
	}
	return $retVal;
}
?>
