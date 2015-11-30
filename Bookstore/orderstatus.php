<?php

include 'dbconnect.php';
session_start();

	$orderno=$_POST['postordno'];
	$ordstauts=$_POST['postordst'];
	$query_up="UPDATE `orders` SET `orderstatus`='$ordstauts' WHERE ordernumber='$orderno'";
	$resuilt_up=mysqli_query($con,$query_up);
	printSqlErr($resuilt_up,$con);
	/*
if($_POST['postordno']){	
	$orderno=$_POST['postordno'];
	$ordstauts $_POST['postordst'];
	$query_o="SELECT ordernumber,orderstatus FROM orders WHERE ordernumber='$orderno'";			
	$resuilt_o=mysqli_query($con,$query_o);
	printSqlErr($resuilt_o,$con);			
	$num_rows_o=mysqli_num_rows($resuilt_o);

	if ($num_rows_o>0){
		$query_up="UPDATE `orders` SET `orderstatus`='$ordstauts' WHERE ordernumber='$orderno'";
		$resuilt_up=mysqli_query($con,$query_up);
		printSqlErr($resuilt_up,$con);
	}
}*/	
function printSqlErr($reslt,$con){
	if (!$reslt) {
		printf("Error: %s\n", mysqli_error($con));
		exit();
	}
}

?>