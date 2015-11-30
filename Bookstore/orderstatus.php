<?php

include 'dbconnect.php';
session_start();

	$orderno=$_POST['postordno'];
	$ordstauts=$_POST['postordst'];
	$query_up="UPDATE `orders` SET `orderstatus`='$ordstauts' WHERE ordernumber='$orderno'";
	$resuilt_up=mysqli_query($con,$query_up);
	printSqlErr($resuilt_up,$con);

function printSqlErr($reslt,$con){
	if (!$reslt) {
		printf("Error: %s\n", mysqli_error($con));
		exit();
	}
}

?>