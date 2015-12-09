<?php
include 'dbconnect.php';
session_start ();
ob_start();
if ($_SESSION ['admin'] == "") {
	header ( "Location:admin.php" );
}
$r_user=$r_address=$r_ccexpdate=$r_ccnumber=$r_cctype=$r_city=$r_email=$r_fname=$r_lname=$r_pass=$r_phone=$r_rpass=$r_state=$r_zip='';
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Tim Bookstore</title>
	<meta name="keywords" content="" />
<meta name="description" content="" />
	<link rel="stylesheet" type="text/css"	href="css/bookstore.css">
	
<link rel="stylesheet" href="css/coda-slider.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="css/table.css" type="text/css" />

<script src="js/jquery-1.2.6.js" type="text/javascript"></script>
<script src="js/jquery.scrollTo-1.3.3.js" type="text/javascript"></script>
<script src="js/jquery.localscroll-1.2.5.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.serialScroll-1.2.1.js" type="text/javascript" charset="utf-8"></script>
<!--<script src="js/coda-slider.js" type="text/javascript" charset="utf-8"></script>-->
<script src="js/jquery.easing.1.3.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	
	<!-- import Jquery for AJAX -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script> 
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script type="text/javascript">
	
		function ordstChange(element,orderno,orstauts){
			document.getElementById(element).disabled=true;			
			$.post('orderstatus.php',{postordno:orderno,postordst:orstauts},function(data){});
		}
		function order_inv()	{
			document.getElementsByClassName('o_d')[0].style.display = "inline";
			document.getElementsByClassName('o_s')[0].style.display = "none";
			$('#res_op').empty();
		}								
							
	</script>
	
</head>
<body>
	<div class="" id="head">
		<div id="slider">
	<div id="tim_wrapper">
         <div id="tim_sidebar"> 
			<div id="header">
                <h1><a href="#"><img src="images/Logo1.png" width="200px" height="100px" margin-left:"10px"; title="Tim Book Store" alt="#" /></a></h1>
            </div> 

           
            </div>
		
		<div id="logout">
			<form class="" action="" method="post" id="login">
				<label>Admin! <?php $username=$_SESSION['admin'];echo $username; ?></label></br>
				<button type="submit" class="" name="logout" id="logOutButton">Logout</button>
				<button type="submit" class="" name="main" id="AdminButton">Admin</button>
				<button type="submit" class="" name="" id="listOrdersButton">List orders</button>
				<button type="submit" class="" name="order_o" id="openOrdersButton">Open Orders</button>				
				<button type="submit" class="" name="order_it" id="orderItemsButton">Order Items</button>
				<button type="submit" class="" name="litems" id="listItemsButton">List Items</button>
				<button type="button" class="" onclick="order_inv()" id="orderInventoryButton">Order inventory</button>
			</form>
		</div>
		
		
	<div id="search">
		<h3>Search Order </h3>
		<form action="" method="post">
					<div  class="o_d" style="display:none">
					<strong  style="">Order Date From:</strong>
					<input  type="date" dateformat="d M y" class=""  id="fromDate_Id" name="fromdate" placeholder="">
					<strong  style="">To:</strong>
					<input type="date" class=""  id="toDate_Id" name="todate" placeholder="">
					<label><input type="checkbox" name="search_cd" value="itemc">Items</label>	
					</br>
					<button type="submit" class="" id="searchButton" name="Search_d">Search</button>
					</div>
					
					
                <div  class="searchbook">
					<input type="text" class="" id="search_id" name="tosearch" placeholder="search book">
				</div>				
						<label><input type="radio" name="search_r" value="ordernumber">Order no.</label>								
					<label><input type="radio" name="search_r" value="username">Username</label>										
					<label><input type="radio" name="search_r" value="orderstatus">Order status</label>		
				<div class="">
					<button type="submit" class="" id="searchButton" name="search_u">Search</button>
				</div>
		</form>
	</div>
	
	<div id="res_op">
		
<?php
	
	
	//if admin press
	//----------------------------------------------------------------------------------------------------------	
	if(isset ( $_POST ['main'] )){
		header ( "Location:adminafterlogin.php" );
	}
	//if search engin press
	//----------------------------------------------------------------------------------------------------------
	else if (isset ( $_POST ['search_b'] )&&isset ( $_POST ['search_c'] )) {
		$tosearch=$_POST ['tosearch'];
		if(isset ( $_POST ['search_r'] ))$typesearch=$_POST['search_r'];
		
		if(!empty($tosearch)&&!empty($typesearch)){
			
			$query="SELECT `ordernumber`, `username`, `orderdate`, `ordsecnum`, `orderstatus`, `ordertotal`
					FROM `orders` WHERE $typesearch Like '%$tosearch%'";
			
			$resuilt=mysqli_query($con,$query);
			printSqlErr($resuilt,$con);
			
			$num_rows_o=mysqli_num_rows($resuilt);
			
			if ($num_rows_o>0){
			echo'	<h3>List search resuilts for orders and items:</h3>
					<table align="center">					
					';
			while($row_array_o=mysqli_fetch_array($resuilt)){
				echo '<tr width="150px">';
				echo '<td width="150px"><strong >Order no:</strong> ' . $row_array_o ['ordernumber'] . '</td>
					  <td width="150px"><strong >Username:</strong> ' . $row_array_o ['username'] . '</td>
					  <td width="150px"><strong >Date:</strong> ' . $row_array_o ['orderdate'] . '</td>
					  <td width="150px"><strong >Total:</strong> ' . $row_array_o ['ordertotal'] . '</td>
					  <td width="150px"><strong >Status:</strong> ' . $row_array_o ['orderstatus'] . '</td>
				      ';
				echo '<td>';
				echo '<form action="" method="post">';
				if ($row_array_o ['orderstatus']=='o'){$a='c';$b='d';$a_val="Canceled";$b_val="Delivered";}
					else if ($row_array_o ['orderstatus']=='d'){$a='o';$b='c';$a_val="Open";$b_val="Canceled";}
					else if($row_array_o ['orderstatus']=='c'){$a='o';$b='d';$a_val="Open";$b_val="Delivered";}
				echo'<input id='.$row_array_o['ordernumber'].' type="button" value='.$a_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o['ordernumber'].'\',\''.$a.'\')";>';
				 echo'<input id='.$row_array_o['username'].' type="button" value='.$b_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o['ordernumber'].'\',\''.$b.'\')";>';
				echo '</form></td>';		
				echo '</tr>';
				$query_t='SELECT * FROM items WHERE ordernumber='.$row_array_o ['ordernumber'].'';			
				$resuilt_t=mysqli_query($con,$query_t);
				printSqlErr($resuilt_t,$con);			
				$num_rows_t=mysqli_num_rows($resuilt_t);
				if ($num_rows_t>0){
					echo'	
											
						<tr align="left">
						<th width="150px"></th>
						<th width="150px">Item no.</th>
						<th width="150px">ISBN</th>
						<th width="150px">Quantity</th>
						<th width="150px">Price</th>
						
					</tr>
					
					';
					while($row_array_t=mysqli_fetch_array($resuilt_t)){
						echo '<tr width="150px">';
						echo '<td width="150px"></td>
						  <td width="150px">' . $row_array_t ['itemno'] . '</td>
						  <td width="150px">' . $row_array_t ['itemisbn'] . '</td>
						  <td width="150px">' . $row_array_t ['itemqty'] . '</td>
						  <td width="150px">' . $row_array_t ['itemprice'] . '</td>
					      </br>';
					
						echo '<td>';
						echo '</td></tr>';	
					}
					//print "</table>";
				}
				echo'<tr></tr>';	
			}		
		}
		else{
			print "There were no such rows in the table <br/>";
			}
		print "</table>";
	 }
	}
	//if search engin press
	//----------------------------------------------------------------------------------------------------------
	else if (isset ( $_POST ['search_b'] )) {
		$tosearch=$_POST ['tosearch'];
		if(isset ( $_POST ['search_r'] ))$typesearch=$_POST['search_r'];
		
		if(!empty($tosearch)&&!empty($typesearch)){
			
			$query="SELECT `ordernumber`, `username`, `orderdate`, `ordsecnum`, `orderstatus`, `ordertotal`
					FROM `orders` WHERE $typesearch Like '%$tosearch%'";
			
			$resuilt=mysqli_query($con,$query);
			printSqlErr($resuilt,$con);
			
			$num_rows=mysqli_num_rows($resuilt);
			
			//print header of table
			if ($num_rows>0){
				echo'	<h3>List search resuilts for orders:</h3>';				
				echo'
					<table align="center">
					<tr align="left">
						<th width="150px">Order no.</th>
						<th width="150px">Username</th>
						<th width="150px">Date</th>
						<th width="150px">Total</th>
						<th width="150px">Status</th>
					</tr>
					
					<tobody>';
					
				while($row_array=mysqli_fetch_array($resuilt)){
					//echo '<col width="64px">';
					echo '<tr width="150px"></td>';
					echo '<td width="150px">' . $row_array ['ordernumber'] . '</td>
						  <td width="150px">' . $row_array ['username'] . '</td>
						  <td width="150px">' . $row_array ['orderdate'] . '</td>
						  <td width="150px">' . $row_array ['ordertotal'] . '</td>
						  <td width="150px">' . $row_array ['orderstatus'] . '</td>
					      ';
					
					echo '<td>';
					echo '<form action="" method="post">';
					if ($row_array ['orderstatus']=='o'){$a='c';$b='d';$a_val="Canceled";$b_val="Delivered";}
					else if ($row_array ['orderstatus']=='d'){$a='o';$b='c';$a_val="Open";$b_val="Canceled";}
					else if($row_array ['orderstatus']=='c'){$a='o';$b='d';$a_val="Open";$b_val="Delivered";}
					echo'<input id='.$row_array['ordernumber'].' type="button" value='.$a_val.' 
					 onclick="ordstChange(this.id,\''.$row_array['ordernumber'].'\',\''.$a.'\')";>';
					 echo'<input id='.$row_array['username'].' type="button" value='.$b_val.' 
					 onclick="ordstChange(this.id,\''.$row_array['ordernumber'].'\',\''.$b.'\')";>';
					 echo '</form>';
					echo '</td></tr>';
					
				}				
				echo'</tbody>';				
				echo' </table>';
				//echo '<form action="" method="post"><button name="editbook" type="submit">Edit last book</button></form>';
            }
			else {
				print "There were no such rows in the table <br/>";
			}
			//print "</table>";
			
		}else{
			echo "<script type='text/javascript'>alert('Please Select field to Search and Enter Text to search');</script>";
		}
	}
	//
	//----------------------------------------------------------------------------------------------------------	
	else if (isset($_POST['lorders'])){
		$query_o="SELECT * FROM orders ORDER BY ordernumber";			
		$resuilt_o=mysqli_query($con,$query_o);
		printSqlErr($resuilt_o,$con);			
		$num_rows_o=mysqli_num_rows($resuilt_o);
		if ($num_rows_o>0){
			echo'	<h3>List all orders:</h3>
					<table align="center">					
					
					<tr align="left">
						<th width="150px">Order no.</th>
						<th width="150px">Username</th>
						<th width="150px">Date</th>
						<th width="150px">Total</th>
						<th width="150px">Status</th>
						
					</tr>
					
					';
			while($row_array_o=mysqli_fetch_array($resuilt_o)){
				echo '<tr width="150px">';
					echo '<td width="150px">' . $row_array_o ['ordernumber'] . '</td>
						  <td width="150px">' . $row_array_o ['username'] . '</td>
						  <td width="150px">' . $row_array_o ['orderdate'] . '</td>
						  <td width="150px">' . $row_array_o ['ordertotal'] . '</td>
						  <td width="150px">' . $row_array_o ['orderstatus'] . '</td>
					      </br>';
					
					echo '<td>';
					
					echo '<form action="" method="post">';
					if ($row_array_o ['orderstatus']=='o'){$a='c';$b='d';$a_val="Canceled";$b_val="Delivered";}
					else if ($row_array_o ['orderstatus']=='d'){$a='o';$b='c';$a_val="Open";$b_val="Canceled";}
					else if($row_array_o ['orderstatus']=='c'){$a='o';$b='d';$a_val="Open";$b_val="Delivered";}
					echo'<input id='.$row_array_o['ordernumber'].' type="button" value='.$a_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o ['ordernumber'].'\',\''.$a.'\')";>';
					 echo'<input id='.$row_array_o['username'].' type="button" value='.$b_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o ['ordernumber'].'\',\''.$b.'\')";>';
					 echo '</form>';
					echo '</td></tr>';
					
			}		
		}
		else{
			print "There were no such rows in the table <br/>";
			}
		print "</table>";
	}
	//
	//----------------------------------------------------------------------------------------------------------	
	else if (isset($_POST['litems'])){
		$query_o="SELECT * FROM items ORDER BY ordernumber,itemno";			
		$resuilt_o=mysqli_query($con,$query_o);
		printSqlErr($resuilt_o,$con);			
		$num_rows_o=mysqli_num_rows($resuilt_o);
		if ($num_rows_o>0){
			echo'	<h3>List all items:</h3>
					<table align="center">					
					
					<tr align="left">
						<th width="150px">Order no.</th>
						<th width="150px">Item no.</th>
						<th width="150px">ISBN</th>
						<th width="150px">Quantity</th>
						<th width="150px">Price</th>
						
					</tr>
					
					';
			while($row_array_o=mysqli_fetch_array($resuilt_o)){
				echo '<tr width="150px">';
					echo '<td width="150px">' . $row_array_o ['ordernumber'] . '</td>
						  <td width="150px">' . $row_array_o ['itemno'] . '</td>
						  <td width="150px">' . $row_array_o ['itemisbn'] . '</td>
						  <td width="150px">' . $row_array_o ['itemqty'] . '</td>
						  <td width="150px">' . $row_array_o ['itemprice'] . '</td>
					      </br>';
					
					echo '<td>';
					echo '</td></tr>';
			}
		}
		else{
			print "There were no such rows in the table <br/>";
			}
		print "</table>";
	}
	//if regiter press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST['order_o'] )){
		$query_o="SELECT * FROM orders WHERE orderstatus='o'";			
		$resuilt_o=mysqli_query($con,$query_o);
		printSqlErr($resuilt_o,$con);			
		$num_rows_o=mysqli_num_rows($resuilt_o);
		if ($num_rows_o>0){
			echo'	<h3>List all orders:</h3>
					<table align="center">					
					
					<tr align="left">
						<th width="150px">Order no.</th>
						<th width="150px">Username</th>
						<th width="150px">Date</th>
						<th width="150px">Total</th>
						<th width="150px">Status</th>
						
					</tr>
					
					<tobody>';
			while($row_array_o=mysqli_fetch_array($resuilt_o)){
				echo '<tr width="150px">';
					echo '<td width="150px">' . $row_array_o ['ordernumber'] . '</td>
						  <td width="150px">' . $row_array_o ['username'] . '</td>
						  <td width="150px">' . $row_array_o ['orderdate'] . '</td>
						  <td width="150px">' . $row_array_o ['ordertotal'] . '</td>
						  <td width="150px">' . $row_array_o ['orderstatus'] . '</td>
					      </br>';
					
					echo '<td>';
					
					echo '<form action="" method="post">';
					if ($row_array_o ['orderstatus']=='o'){$a='c';$b='d';$a_val="Canceled";$b_val="Delivered";}
					else if ($row_array_o ['orderstatus']=='d'){$a='o';$b='c';$a_val="Open";$b_val="Canceled";}
					else if($row_array_o ['orderstatus']=='c'){$a='o';$b='d';$a_val="Open";$b_val="Delivered";}
					echo'<input id='.$row_array_o['ordernumber'].' type="button" value='.$a_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o ['ordernumber'].'\',\''.$a.'\')";>';
					 echo'<input id='.$row_array_o['username'].' type="button" value='.$b_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o ['ordernumber'].'\',\''.$b.'\')";>';
					 echo '</form>';
					echo '</td></tr>';
					
			}		
		}
		else{
			print "There were no such rows in the table <br/>";
			}
		print "</tobody></table>";
				
	}
	
	else if(isset ( $_POST ['search_d'] )){
		
		
	}
	//if logout press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['logout'] )){
		$_SESSION['admin']='';
		header ( "Location:admin.php" );
		
	}
	//enter password
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['order_it'] )){
		$query_o="SELECT * FROM orders";			
		$resuilt_o=mysqli_query($con,$query_o);
		printSqlErr($resuilt_o,$con);			
		$num_rows_o=mysqli_num_rows($resuilt_o);
		if ($num_rows_o>0){
			echo'	<h3>List all orders and items:</h3>
					<table align="center">';
			while($row_array_o=mysqli_fetch_array($resuilt_o)){
				echo '					
					 
					  <tr width="150px">';
				echo '<td width="150px"><strong >Order no:</strong> ' . $row_array_o ['ordernumber'] . '</td>
					  <td width="150px"><strong >Username:</strong> ' . $row_array_o ['username'] . '</td>
					  <td width="150px"><strong >Date:</strong> ' . $row_array_o ['orderdate'] . '</td>
					  <td width="150px"><strong >Total:</strong> ' . $row_array_o ['ordertotal'] . '</td>
					  <td width="150px"><strong >Status:</strong> ' . $row_array_o ['orderstatus'] . '</td>
				      <td>';
				echo '<form action="" method="post">';
				if ($row_array_o ['orderstatus']=='o'){$a='c';$b='d';$a_val="Canceled";$b_val="Delivered";}
					else if ($row_array_o ['orderstatus']=='d'){$a='o';$b='c';$a_val="Open";$b_val="Canceled";}
					else if($row_array_o ['orderstatus']=='c'){$a='o';$b='d';$a_val="Open";$b_val="Delivered";}
				echo'<input id='.$row_array_o['ordernumber'].' type="button" value='.$a_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o['ordernumber'].'\',\''.$a.'\')";>';
				 echo'<input id='.$row_array_o['username'].' type="button" value='.$b_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o['ordernumber'].'\',\''.$b.'\')";>';
				echo '</form></td>';
				echo '</tr>';
				$query_t='SELECT * FROM items WHERE ordernumber='.$row_array_o ['ordernumber'].'';			
				$resuilt_t=mysqli_query($con,$query_t);
				printSqlErr($resuilt_t,$con);			
				$num_rows_t=mysqli_num_rows($resuilt_t);
				if ($num_rows_t>0){
					echo'	
						<tr align="left">
						<th width="150px"></th>
						<th width="150px">Item no.</th>
						<th width="150px">ISBN</th>
						<th width="150px">Quantity</th>
						<th width="150px">Price</th>
						
					</tr>
					
					';
					while($row_array_t=mysqli_fetch_array($resuilt_t)){
						echo '<tr width="150px">';
						echo '<td width="150px"></td>
						  <td width="150px">' . $row_array_t ['itemno'] . '</td>
						  <td width="150px">' . $row_array_t ['itemisbn'] . '</td>
						  <td width="150px">' . $row_array_t ['itemqty'] . '</td>
						  <td width="150px">' . $row_array_t ['itemprice'] . '</td>
					      </br>';
					
						
						echo '</tr>';	
					}
					//print "</table>";
				}	
			}
			echo'<tr></tr>';	
		}
		else{
			print "There were no such rows in the table <br/>";
			}
		print "</table>";
	}
	//change passowrd
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['Search_d'] )&&isset ( $_POST ['search_cd'] )){
		
		$fromdate=$_POST ['fromdate'];
		$todate=$_POST ['todate'];
		
		if(!empty($fromdate)&&!empty($todate)){
			
			$query="SELECT `ordernumber`, `username`, `orderdate`, `ordsecnum`, `orderstatus`, `ordertotal`
					FROM `orders` WHERE orderdate between '$fromdate' AND '$todate'";
			$resuilt=mysqli_query($con,$query);
			printSqlErr($resuilt,$con);
			
			$num_rows_o=mysqli_num_rows($resuilt);
			
			if ($num_rows_o>0){
			echo'	<h3>List search resuilts for orders and items:</h3>
					<table align="center">					
					';
			while($row_array_o=mysqli_fetch_array($resuilt)){
				echo '<tr width="150px">';
				echo '<td width="150px"><strong >Order no:</strong> ' . $row_array_o ['ordernumber'] . '</td>
					  <td width="150px"><strong >Username:</strong> ' . $row_array_o ['username'] . '</td>
					  <td width="150px"><strong >Date:</strong> ' . $row_array_o ['orderdate'] . '</td>
					  <td width="150px"><strong >Total:</strong> ' . $row_array_o ['ordertotal'] . '</td>
					  <td width="150px"><strong >Status:</strong> ' . $row_array_o ['orderstatus'] . '</td>
				      ';
				echo '<td>';
				echo '<form action="" method="post">';
				if ($row_array_o ['orderstatus']=='o'){$a='c';$b='d';$a_val="Canceled";$b_val="Delivered";}
					else if ($row_array_o ['orderstatus']=='d'){$a='o';$b='c';$a_val="Open";$b_val="Canceled";}
					else if($row_array_o ['orderstatus']=='c'){$a='o';$b='d';$a_val="Open";$b_val="Delivered";}
				echo'<input id='.$row_array_o['ordernumber'].' type="button" value='.$a_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o['ordernumber'].'\',\''.$a.'\')";>';
				 echo'<input id='.$row_array_o['username'].' type="button" value='.$b_val.' 
					 onclick="ordstChange(this.id,\''.$row_array_o['ordernumber'].'\',\''.$b.'\')";>';
				echo '</form></td>';		
				echo '</tr>';
				$query_t='SELECT * FROM items WHERE ordernumber='.$row_array_o ['ordernumber'].'';			
				$resuilt_t=mysqli_query($con,$query_t);
				printSqlErr($resuilt_t,$con);			
				$num_rows_t=mysqli_num_rows($resuilt_t);
				if ($num_rows_t>0){
					echo'	
					
						<tr align="left">
						<th width="150px"></th>
						<th width="150px">Item no.</th>
						<th width="150px">ISBN</th>
						<th width="150px">Quantity</th>
						<th width="150px">Price</th>
						
					</tr>
					
					';
					while($row_array_t=mysqli_fetch_array($resuilt_t)){
						echo '<tr width="150px">';
						echo '<td width="150px"></td>
						  <td width="150px">' . $row_array_t ['itemno'] . '</td>
						  <td width="150px">' . $row_array_t ['itemisbn'] . '</td>
						  <td width="150px">' . $row_array_t ['itemqty'] . '</td>
						  <td width="150px">' . $row_array_t ['itemprice'] . '</td>
					      </br>';
					
						echo '<td>';
						echo '</td></tr>';	
					}
					//print "</tobody></table>";
				}
				echo'<tr></tr>';	
			}		
		}
		else{
			print "There were no such rows in the table <br/>";
			}
		print "</table>";
	 }
	}
	
	//----------------------------------------------------------
	else if(isset ( $_POST ['Search_d'] )){
		
		$fromdate=$_POST ['fromdate'];
		$todate=$_POST ['todate'];
		
		if(!empty($fromdate)&&!empty($todate)){
			
			$query="SELECT `ordernumber`, `username`, `orderdate`, `ordsecnum`, `orderstatus`, `ordertotal`
					FROM `orders` WHERE orderdate between '$fromdate' AND '$todate'";
			$resuilt=mysqli_query($con,$query);
			printSqlErr($resuilt,$con);
			
			$num_rows=mysqli_num_rows($resuilt);
			
			//print header of table
			if ($num_rows>0){
				echo'	<h3>List search resuilts for orders:</h3>';				
				echo'
					<table align="center">
					
					
					<tr align="left">
						<th width="150px">Order no.</th>
						<th width="150px">Username</th>
						<th width="150px">Date</th>
						<th width="150px">Total</th>
						<th width="150px">Status</th>
					</tr>
					
					<tobody>';
					
				while($row_array=mysqli_fetch_array($resuilt)){
					//echo '<col width="64px">';
					echo '<tr width="150px"></td>';
					echo '<td width="150px">' . $row_array ['ordernumber'] . '</td>
						  <td width="150px">' . $row_array ['username'] . '</td>
						  <td width="150px">' . $row_array ['orderdate'] . '</td>
						  <td width="150px">' . $row_array ['ordertotal'] . '</td>
						  <td width="150px">' . $row_array ['orderstatus'] . '</td>
					      ';
					
					echo '<td>';
					echo '<form action="" method="post">';
					if ($row_array ['orderstatus']=='o'){$a='c';$b='d';$a_val="Canceled";$b_val="Delivered";}
					else if ($row_array ['orderstatus']=='d'){$a='o';$b='c';$a_val="Open";$b_val="Canceled";}
					else if($row_array ['orderstatus']=='c'){$a='o';$b='d';$a_val="Open";$b_val="Delivered";}
					echo'<input id='.$row_array['ordernumber'].' type="button" value='.$a_val.' 
					 onclick="ordstChange(this.id,\''.$row_array['ordernumber'].'\',\''.$a.'\')";>';
					 echo'<input id='.$row_array['username'].' type="button" value='.$b_val.' 
					 onclick="ordstChange(this.id,\''.$row_array['ordernumber'].'\',\''.$b.'\')";>';
					 echo '</form>';
					echo '</td></tr>';
					
				}				
				echo'</tbody>';				
				echo' </table>';
				//echo '<form action="" method="post"><button name="editbook" type="submit">Edit last book</button></form>';
            }
			else {
				print "There were no such rows in the table <br/>";
			}
			print "</table>";
			
		}else{
			echo "<script type='text/javascript'>alert('Please Select field to Search and Enter Text to search');</script>";
		}
	}
	
	//----------------------------------------------------------
	//print error for sql
	function printSqlErr($reslt,$con){
		if (!$reslt) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
	}
	
	
	//----------------------------------------------------------------------------------------------------------
	
	
?>	
	</div>
	
	
</body>
</html>
