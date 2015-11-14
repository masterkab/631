<?php
	$con = mysqli_connect('localhost','root','',"bookstore");
		if(mysqli_connect_errno()){
            print"Connect faild: " . mysqli_connect_error();
            exit();
        }
			
?>