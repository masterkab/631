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
	<script type="text/javascript" src="js/updatecart.js"></script>
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
		
<?php
	//--------------------------------------------------------------------------------------------------
	if(!(isset($_GET['doCheck'])|| (isset($_GET['doFinalize'])))) {
		echo "<b>Your shopping cart contains the fillowing items:</b><br>";
		$sqlStmt="SELECT carts.itemqty,carts.itemno,books.* FROM carts INNER JOIN books ON carts.itemisbn=books.isbn WHERE username='".$_SESSION['usern']."' ORDER BY title";
		$result=mysqli_query($con,$sqlStmt);
		if($result->num_rows==0) { // empty cart
			echo "<b>Your shopping cart is empty.</b><br>";
			echo '<a href="userafterlogin.php">Return to search</a>';
		} else { // the cart is not empty
			$foundItemInCart=false; // it could be filled with 0 qty items
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

			while($row_array=mysqli_fetch_array($result)) {
				if($row_array['itemqty']>0) {
					$foundItemInCart=true;
					echo '<td width="150px"><img src="img/'.$row_array['imageurl']. '"></td>';
					echo '<td width="150px">'.$row_array['title'].'</td>';
					echo '<td width="150px">'.$row_array['author'].'</td>';
					echo '<td width="150px">'.$row_array['isbn'].'</td>';
					echo '<td width="150px">'.$row_array['pubyear'].'</td>';
					echo '<td width="150px">'.$row_array['price'].'</td>';
					echo '<td width="150px"><input type="text" id="item'.$row_array['itemno'].'" name="qty" onchange="updateCart('.$row_array['isbn'].','.$row_array['itemno'].',this.id)" value='.$row_array['itemqty'].'></td></tr>';
				}
			}
			if(!$foundItemInCart) { // Things were found, but qty=0
				echo "<b>Your shopping cart is empty.</b><br>";
				echo '<a href="userafterlogin.php">Return to search</a>';
				$sqlStr="DELETE FROM carts WHERE username='".$_SESSION['usern']."'";
				$sqlStmt=$con->prepare($sqlStr);
				$retVal=mysqli_stmt_execute($sqlStmt);
			} else {
				echo '</table><a href="checkout.php?doCheck=next" class="button">Check out</a>';
				echo '<a href="userafterlogin.php" class="button">Cancel check out</a>';
			}
		}
	} else if(isset($_GET['doCheck'])) { // Do final check of CC data
		$sqlStmt="SELECT carts.itemqty,carts.itemno,books.* FROM carts INNER JOIN books ON carts.itemisbn=books.isbn WHERE username='".$_SESSION['usern']."' ORDER BY title";
		$result=mysqli_query($con,$sqlStmt);
		if($result->num_rows==0) { // empty cart
			echo "<b>Your shopping cart is empty.</b><br>";
			echo '<a href="userafterlogin.php">Return to search</a>';
		} else {
			$orderTotal=0.00;
			$foundItemInCart=false;
			$orderName="order_".$_SESSION['usern'];
			$orderArray=array();
			$items=array();
			$itemArray=array();
			$itemCount=0;
			while($row_array=mysqli_fetch_array($result)) {
				if($row_array['itemqty']>0) {
					$itemCount++;
					$foundItemInCart=true;
					$orderTotal+=$row_array['itemqty'] * $row_array['price'];
					$itemno=$row_array['itemno'];
					$itemArray['itemno']=$row_array['itemno'];
					$itemArray['itemisbn']=$row_array['isbn'];
					$itemArray['itemqty']=$row_array['itemqty'];
					$itemArray['itemprice']=$row_array['price'];
					$items[$itemno]=$itemArray;
				}
			}
			if(!$foundItemInCart) {
				echo "<b>Your shopping cart is empty.</b><br>";
				echo '<a href="userafterlogin.php">Return to search</a>';
				$sqlStr="DELETE FROM carts WHERE username='".$_SESSION['usern']."'";
				$sqlStmt=$con->prepare($sqlStr);
				$retVal=mysqli_stmt_execute($sqlStmt);
			} else {
				$sqlStmt="SELECT * FROM users WHERE username='".$_SESSION['usern']."'";
				$orderArray['ordertotal']=$orderTotal;
				$orderArray['orderitems']=$itemCount;
				$orderArray['itemarray']=$items;
				$_SESSION[$orderName]=$orderArray;
				echo "<b>Total order is $".$orderTotal."</b><br>";
				echo "<b>Please verify the following information:</b><br>";
				$result=mysqli_query($con,$sqlStmt);
				if($result->num_rows!=1) {
					echo "Can't find username in database.";
				} else {
					$mySel=$result->fetch_assoc();
					echo "<br><b>Customer name: </b>".$mySel['lastname'].", ".$mySel['firstname']."<br>";
					echo "<b>Address: </b>".$mySel['address']."<br>";
					echo "<b>City: </b>".$mySel['city']." <b>State: </b>".$mySel['state']." <b>Zip: </b>".$mySel['zip']."<br>";
					$tel=$mySel['telephone'];
					$tel1=substr($tel,0,3);
					$tel2=substr($tel,3,3);
					$tel3=substr($tel,6,4);
					echo "<b>Telephone: </b>(".$tel1.") ".$tel2."-".$tel3."</br>";
					echo "<b>Email: </b>".$mySel['email']."</br>";
					echo "<b>Credit card: </b>";
					switch ($mySel['cctype']) {
					case 'v':
					case 'V':
						echo "Visa<br>";
						break;
					case 'm':
					case 'M':
						echo "Mastercard<br>";
						break;
					case 'a':
					case 'A':
						echo "American Express<br>";
						break;
					default:
						echo "Unknown</br>";
					}
					echo "<b>Card number:</b> **** **** **** ".substr($mySel['ccnumber'],-4)."<br>";
					$ccexp=$mySel['ccexpdate'];
					$ccexp1=substr($ccexp,0,2);
					$ccexp2=substr($ccexp,-4);
					echo "<b>Expiration date: </b>".$ccexp1."/".$ccexp2."<br>";
					echo '<br><a href="checkout.php?doFinalize=next" class="button">Finalize checkout</a> <a href="userafterlogin.php" class="button">Cancel checkout</a>';
				}
			}
		}
	} else if(isset($_GET['doFinalize'])) {
		$myUser='order_'.$_SESSION['usern'];
		if($_SESSION[$myUser]) {
			$orderArray=$_SESSION[$myUser];
			$items=$orderArray['itemarray'];
			$sqlStmt="SELECT Count(*) AS thecount FROM orders";
			$result=mysqli_query($con,$sqlStmt);
			$mySel=$result->fetch_assoc();
			$num_rows=$mySel['thecount'];
			if($num_rows==0) { // the first order
				$curOrderNum=1;
			} else {
				$curOrderNum=$num_rows+1;
			}
			$orderDate=date('Y-m-d');
			$sqlStmt="INSERT INTO orders (ordernumber,username,orderdate,orderstatus,orderitems,ordertotal) VALUES('".
				$curOrderNum."','".$_SESSION['usern']."','".
				$orderDate."','C','".$orderArray['orderitems'].
				"','".$orderArray['ordertotal']."')";
				$sqlCmd=$con->prepare($sqlStmt);
				if($result=mysqli_stmt_execute($sqlCmd)) {
					foreach ($items as &$item) {
						$sqlStmt="INSERT INTO items (ordernumber,itemno,itemisbn,itemqty,itemprice) VALUES('".
						$curOrderNum."','".$item['itemno'].
						"','".$item['itemisbn']."','".
						$item['itemqty']."','".
						$item['itemprice']."')";
						$sqlCmd=$con->prepare($sqlStmt);
						if(!($result=mysqli_stmt_execute($sqlCmd))) {
							echo "Error on insert item";
						} else {
							removeBookFromInventory($con,$item['itemisbn'],$item['itemqty']);
						}
					}
					$sqlStr="DELETE FROM carts WHERE username='".$_SESSION['usern']."'";
					$sqlStmt=$con->prepare($sqlStr);
					$retVal=mysqli_stmt_execute($sqlStmt);
					echo "<b>Thank you for your order</b><br>";
					echo "Your order will be shipped on the next business day.";
					echo '<br><a href="userafterlogin.php" class="button">Return to main page</a>';
					unset($_SESSION[$myUser]);
				} else {
					echo "Unable to insert new order";
				}
		} else {
		header("userafterlogin.php");
		}
	}

?>	
	</div>
	
	
</body>
</html>
