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
	<script type="text/javascript" src="js/cancelorder.js"></script>
</head>
<body>
	
	<div class="" id="head">
		<div class="">
			<h3>Tim Bookstore</h3>
		</div>
		<div id="basket">
			<form class="" action="checkout.php" method="post" id="basket_form">
				<label>Cart=</label> 
				<output type="text" id="cart" name="cartn" ><?=getCountOfItemsInBasket($con)?> </output></br>
				<button type="submit" class="" name="checkout">Checkout</button>
			</form>
		
		</div>
		<div id="logout">
			<form class="" action="userafterlogin.php" method="post" id="login">
				<label>Welcome! <?php $username=$_SESSION['usern'];echo $username; ?></label></br>
				<button type="submit" class="" name="logout">Logout</button>
				<button type="submit" class="" name="update_p">Update profile</button>
				<button type="submit" class="" name="past_o">Past orders</button>
			</form>
		</div>
		
			
	</div>
	
	<div id="search">
		<h3>Search Book</h3>
		<form action="userafterlogin.php" method="post">
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
		
	<b>Thank you for your business!</b><br>
	Your order history:<br>
<?php
	//--------------------------------------------------------------------------------------------------

	$sqlStmt="SELECT * FROM orders WHERE username='".$_SESSION['usern']. "' ORDER BY orderdate";
	$result=mysqli_query($con,$sqlStmt);
	if ($result->num_rows==0) {
		echo "<b>No orders found.</b>";
	} else {
		while($row_array=mysqli_fetch_array($result)) {
			echo "<b>Order # </b>".$row_array['ordernumber']."<br>\n";
                        echo "<b>Order date: </b>".$row_array['orderdate']."<br>\n";
			echo "<b>Order status: </b>";
			$orderCanBeCancelled=false;

			switch ($row_array['orderstatus']) {
				case "o":
				case "O":	echo "Open<br>\n";
						break;
				case "c":
				case "C":	echo "Completed\n";
						$orderCanBeCancelled=true;
						break;
				case "x":
				case "X":	echo "Cancelled<br>\n";
						break;
				case "d":
				case "D":	echo "Shipped<br>\n";
						break;
				default:	echo "Undefined<br>\n";
			}
			if($orderCanBeCancelled) {
				echo '<input type="button" value="Cancel Order" onclick="cancelOrder('.$row_array['ordernumber'].')"></input><br>';
			}
			echo "<b>Items: </b>".$row_array['orderitems']."<br>\n";
			echo "<b>Total: </b> \$".$row_array['ordertotal']."<br>\n";
                        echo'<table align="center">
                             <thead>
                             <tr align="left">
                             <th width="150px">Image</th>
                             <th width="150px">Title</th>
                             <th width="150px">Author</th>
                             <th width="150px">ISBN</th>
                             <th width="150px">Published</th>
                             <th width="150px">Price</th>
                             <th width="150px">Quantity</th>
                             </tr>
                             </thead>
                             <tobody>';
			echo "\n";
			$sqlStmt="SELECT books.*,items.itemno,items.itemqty,items.itemprice FROM items INNER JOIN books ON items.itemisbn=books.isbn WHERE ordernumber='".$row_array['ordernumber']."' ORDER BY title";
			$result2=mysqli_query($con,$sqlStmt);
                        while($row_array2=mysqli_fetch_array($result2)) {
 	                	echo '<td width="150px"><img src="img/'.$row_array2['imageurl']. '"></td>';
        	        	echo '<td width="150px">'.$row_array2['title'].'</td>';
                		echo '<td width="150px">'.$row_array2['author'].'</td>';
                        	echo '<td width="150px">'.$row_array2['isbn'].'</td>';
                    		echo '<td width="150px">'.$row_array2['pubyear'].'</td>';
                        	echo '<td width="150px">'.$row_array2['price'].'</td>';
                        	echo '<td width="150px">'.$row_array2['itemqty'].'</td></tr>';
				echo "\n";
			}
			echo '</table>';
		}
	}
?>	
	<br>
	</div>
	
	
</body>
</html>
