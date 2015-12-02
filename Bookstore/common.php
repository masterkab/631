<?php

function harvestBooksFromCancelledOrders($con,$orderno) {
// TODO: implement harvestBooksFromCancelledOrders
}

function removeBookFromInventory($con,$isbn,$quantity) {
// TODO: implement removeBooksFromInventory
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
