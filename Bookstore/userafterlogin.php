<?php
include 'dbconnect.php';
include 'common.php';
session_start ();
if ($_SESSION ['usern'] == "") {
	header ( "Location:index.php" );
}
$r_user=$r_address=$r_ccexpdate=$r_ccnumber=$r_cctype=$r_city=$r_email=$r_fname=$r_lname=$r_pass=$r_phone=$r_rpass=$r_state=$r_zip='';
?>
<html>
<head>
	<title>Tim Bookstore</title>
	<link rel="stylesheet" type="text/css"	href="css/bookstore.css">
	<!-- Added 11/21/15 by Tim -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script> <!-- import Jquery for AJAX -->
	<script type="text/javascript" src="js/addtocart.js"> </script>
</head>
<body>
	
	<div class="" id="head">
		<div class="">
			<h3>Tim Bookstore</h3>
		</div>
		<div id="basket">
			<form class="" action="checkout.php" method="post" id="basket_form">
				<label>Cart=</label> 
				<output type="text" id="cart" name="cartn" > <?=getCountOfItemsInBasket($con)?> </output></br>
				<button type="submit" class="" name="checkout">Checkout</button>
			</form>
		
		</div>
		<div id="logout">
			<form class="" action="" method="post" id="login">
				<label>Welcome! <?php $username=$_SESSION['usern'];echo $username; ?></label></br>
				<button type="submit" class="" name="logout">Logout</button>
				<button type="submit" class="" name="update_p">Update profile</button>
				<button type="submit" class="" name="past_o">Past orders</button>
			</form>
		</div>
		
			
	</div>
	
	<div id="search">
		<h3>Search Book</h3>
		<form action="" method="post">
				<div  class="">
					<input id="search_input" type="text" class="" id="" name="tosearch" placeholder="search book">
				</div>				
					<label><input type="radio" name="search_r" value="author">Author</label>								
					<label><input type="radio" name="search_r" value="title">Title</label>								
					<label><input type="radio" name="search_r" value="isbn">ISBN</label>				
								
				<div class="">
					<button type="submit" class="" name="search_b">Search</button>
				</div>
		</form>
	</div>
	<div id="res_op">
		
<?php
	
	//connect to DB
	//----------------------------------------------------------------------------------------------------------
/*	$con = mysqli_connect('localhost','root','N0Fun4U',"bookstore");
		if(mysqli_connect_errno()){
            print"Connect faild: " . mysqli_connect_error();
            exit();
         } */
	//if search engin press
	//----------------------------------------------------------------------------------------------------------
	if (isset ( $_POST ['search_b'] )) {
		$tosearch=$_POST ['tosearch'];
		if(isset ( $_POST ['search_r'] ))$typesearch=$_POST['search_r'];
		
		if(!empty($tosearch)&&!empty($typesearch)){
			
			$query="SELECT `isbn`, `title`, `author`, `subject`, `pubyear`, `description`, `imageurl`, `quantity`,
					`supplier`, `price` FROM `books` WHERE $typesearch Like '%$tosearch%'";
			
			$resuilt=mysqli_query($con,$query);
			printSqlErr($resuilt,$con);
			
			$num_rows=mysqli_num_rows($resuilt);
			
			//print header of tabel
			if ($num_rows>0){
								
				echo'
					<table align="center">
					
					<thead>
					<tr align="left">
						<th width="150px">Image</th>
						<th width="150px">Title</th>
						<th width="150px">Author</th>
						<th width="150px">ISBN</th>
						<th width="150px">Publisher</th>
						<th width="150px">Price</th>
					</tr>
					</thead>
					<tobody>';
				$id_counter=1;	
				while($row_array=mysqli_fetch_array($resuilt)){
					//echo '<col width="64px">';
					echo '<tr width="150px"><td><img width="64px" height="128px" src="img/' . $row_array['imageurl'] . '"/></td>';
					echo '<td width="150px">' . $row_array ['title'] . '</td>
						  <td width="150px">' . $row_array ['author'] . '</td>
						  <td width="150px">' . $row_array ['isbn'] . '</td>
						  <td width="150px">' . $row_array ['supplier'] . '</td>
						  <td width="150px">' . $row_array ['price'] . '</td>
					      </tr>';
					
					if($row_array['quantity'] > 0) {
						echo '<td><button name="addcart" align="right" type="button" class="addtocart" id='.$id_counter.' onclick="addToCart(';
	// Added 11/21/15 by Tim 
						echo $row_array['isbn'];
						echo ',this.id);">Add To Cart</button></td>';
					} else {
						echo "<td><b>Out of stock</b></td>";
					}	
					$id_counter+=1;
				}
				echo'</tbody> </table>';
				
            }
			else {
				print "There were no such rows in the tabel <br/>";
			}
			print "</table>";
			
		}else{
			echo "<script type='text/javascript'>alert('Please Select field to Search and Enter Text to search');</script>";
		}
	}
	
	
	//if logout press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['logout'] )){
		$_SESSION['usern']='';
		header ( "Location:index.php" );
		
	}
	//if past order press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['past_o'] )){
//		echo'Tim code';
		header("Location:show_history.php");
	}
	//if past order press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['update_p'] )){
		echo'Tim code';
	}
	//if past order press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['checkout'] )){
		header("Location:checkout.php");
	}
	//----------------------------------------------------------
	//print error for sql
	function printSqlErr($reslt,$con){
		if (!$reslt) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
	}
	
	
	//--------------------------------------------------------------------------------------------------
	
?>	
	</div>
	
	
</body>
</html>
