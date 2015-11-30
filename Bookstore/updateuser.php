<?php

include 'dbconnect.php';
session_start();


if($_POST['postuser']){	
	$username=$_POST['postuser'];
	$query_u="SELECT `username`, `isenabled` FROM `users` WHERE username='$username'";			
	$resuilt_u=mysqli_query($con,$query_u);
	printSqlErr($resuilt_u,$con);			
	$num_rows_u=mysqli_num_rows($resuilt_u);

	if ($num_rows_u>0){
		while($row_array_u=mysqli_fetch_array($resuilt_u)){
			if ($row_array_u['isenabled']=='y'||$row_array_u['isenabled']=='Y'){
				$query_up="UPDATE `users` SET `isenabled`='n' WHERE username='$username'";
			}else{
				$query_up="UPDATE `users` SET `isenabled`='y' WHERE username='$username'";
			}	
				$resuilt_up=mysqli_query($con,$query_up);
			printSqlErr($resuilt_up,$con);	
			echo"<script type='text/javascript'>alert('successfully updated');</script>";						
								
		}
	}else{
		echo "<script type='text/javascript'>alert('User is not found');</script>";
	}		$username=$_POST['user_name'];
	/*echo $username;
	$query_u="SELECT `username`, `isenabled` FROM `users` WHERE username='$username'";			
	$resuilt_u=mysqli_query($con,$query_u);
	printSqlErr($resuilt_u,$con);			
	$num_rows_u=mysqli_num_rows($resuilt_u);
					
	if ($num_rows_u>0){
		while($row_array_u=mysqli_fetch_array($resuilt_u)){
			if ($row_array_u['isenabled']=='y'||$row_array_u['isenabled']=='Y'){
				$query_up="UPDATE `users` SET `isenabled`='n' WHERE username='$username'";
			}else{
				$query_up="UPDATE `users` SET `isenabled`='y' WHERE username='$username'";
			}	
			$resuilt_up=mysqli_query($con,$query_up);
			printSqlErr($resuilt_up,$con);	
			echo"<script type='text/javascript'>alert('successfully updated');</script>";						
								
		}
	}else{
		echo "<script type='text/javascript'>alert('User is not found');</script>";
		}*/
	
	}
	function printSqlErr($reslt,$con){
		if (!$reslt) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
	}

?>