<?php
include 'dbconnect.php';
include 'common.php';
session_start();


if ($_SESSION['usern'] != '') { // Is a user logged in?
	if((isset($_POST['orderno']) && !empty($_POST['orderno']))) {
		// cancel the order
		$sqlStr="UPDATE orders SET orderstatus='x' WHERE ordernumber='".$_POST['orderno']."'";
		$sqlStmt=$con->prepare($sqlStr);
		if($result=mysqli_stmt_execute($sqlStmt)==1) {
			$retVal=true;
			$errMsg='Order '.$_POST['orderno'].' has been cancelled.';
			harvestBooksFromCancelledOrders($_POST['orderno']);
		} else {
			// Something went wrong here.
			$retVal=false;
			$errMsg='Error on UPDATE.';
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

echo "$retVal:$errMsg:";

?>
