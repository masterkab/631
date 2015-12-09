<?php
include 'dbconnect.php';
include 'common.php';
session_start ();
ob_start();
if ($_SESSION ['usern'] == "") {
	header ( "Location:index.php" );
}
$r_user=$r_address=$r_ccexpdate=$r_ccnumber=$r_cctype=$r_city=$r_email=$r_fname=$r_lname=$r_pass=$r_phone=$r_rpass=$r_state=$r_zip='';
?>
<html>
<head>
	<title>Tim Bookstore</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/tim_style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="css/coda-slider.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="css/table.css" type="text/css" />

<script src="js/jquery-1.2.6.js" type="text/javascript"></script>
<script src="js/jquery.scrollTo-1.3.3.js" type="text/javascript"></script>
<script src="js/jquery.localscroll-1.2.5.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.serialScroll-1.2.1.js" type="text/javascript" charset="utf-8"></script>
<!--<script src="js/coda-slider.js" type="text/javascript" charset="utf-8"></script>-->
<script src="js/jquery.easing.1.3.js" type="text/javascript" charset="utf-8"></script>
	<!-- Added 11/21/15 by Tim -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script> <!-- import Jquery for AJAX -->
	<script type="text/javascript" src="updatecart.js"></script>
</head>
<body>
	<div class="" id="head">
		<div id="slider">
	<div id="tim_wrapper">
        <div id="tim_sidebar"> 
			<div id="header">
                <h1><a href="#"><img src="images/Logo1.png" width="200px" height="100px" margin-left:"10px"; title="Tim Book Store" alt="#" /></a></h1>
            </div> 

            <div id="menu">
                <ul class="navigation">
				  <form	action="userafterlogin.php" method="post">
                   
					<li><a class="menu_02"><button type="submit" class="menu_02" id="updateProfileButton" name="update_p">Update profile</button></a></li>
					<li><a class="menu_03"><button type="submit" class="menu_03" id="pastOrdersButton" name="past_o">Past orders</button></a></li>
                                       
				   </form>	
                </ul>
            </div>
            <div class="search">
		<h3>Search Book</h3>
		<form action="userafterlogin.php" method="post">
				<div  class="searchbook">
					<input type="text" class="" id="search_id" name="tosearch" placeholder="search book">
				</div>				
					<p><label><input type="radio" name="search_r" value="author">Author</label>								
					<label><input type="radio" name="search_r" value="title">Title</label>								
					<label><input type="radio" name="search_r" value="isbn">ISBN</label></p>				
								
				<div class="submitsearch">
					<button type="submit" class="" id="searchButton" name="search_b">Search</button>
				</div>
		</form>
	</div>

            		</div>
            		
            		<div id="content">
          <div class="scroll">
            <div class="scrollContainer">
              <div class="panel" id="home">
                <div class="content_section">
                  <h2>Welcome to Tim Book Store</h2>
                  <img src="images/bookImage.png" alt="Image 01" width="150px" height="100px" class="image_wrapper image_fl" />
                   <div class="content_section last_section">
                	<div id="basket">
			<form class="" action="checkout.php" method="post" id="basket_form">
				<label>Cart=</label> 
				<output type="text" id="cart" name="cartn" ><?=getCountOfItemsInBasket($con)?> </output></br>
				<button type="submit" class="" id="checkoutButton" name="checkout">Checkout</button>
			</form>
		
		</div>
		<div id="logout">
			<form class="" action="userafterlogin.php" method="post" id="login">
				<label>Welcome! <?php $username=$_SESSION['usern'];echo $username; ?></label></br>
				<button type="submit" class="" id="logOutButton" name="logout">Logout</button>
				<button type="submit" class="" id="updateProfileButton" name="update_p">Update profile</button>
				<button type="submit" class="" id="pastOrdersButton" name="past_o">Past orders</button>
			</form>
		</div>
		
                </div>
				
	<!-- <div class="" id="head">
		<div class="" id="title">
			<h3>Tim Bookstore</h3>
		</div>
		<div id="basket">
			<form class="" action="" method="post" id="basket_form">
				<label>Cart=</label> 
				<output type="text" id="cart" name="cartn" ><?=getCountOfItemsInBasket($con)?> </output></br>
				<button type="submit" class="" id="checkoutButton" name="checkout">Checkout</button>
			</form>
		
		</div>
		<div id="logout">
			<form class="" action="" method="post" id="login">
				<label>Welcome! <?php $username=$_SESSION['usern'];echo $username; ?></label></br>
				<button type="submit" class="" id="logOutButton" name="logout">Logout</button>
				<button type="submit" class="" id="updateProfileButton" name="update_p">Update profile</button>
				<button type="submit" class="" id="pastOrdersButton" name="past_o">Past orders</button>
			</form>
		</div>
		
			
	</div>
	
	<div id="search">
		<h3>Search Book</h3>
		<form action="userafterlogin.php" method="post">
				<div  class="">
					<input id="search_input" type="text" class="" name="tosearch" placeholder="search book">
				</div>				
					<label><input type="radio" name="search_r" value="author">Author</label>								
					<label><input type="radio" name="search_r" value="title">Title</label>								
					<label><input type="radio" name="search_r" value="isbn">ISBN</label>				
								
				<div class="">
					<button type="submit" class="" id="searchButton" name="search_b">Search</button>
				</div>
		</form>
	</div> -->
	<div id="res_op">
		
	<b>Thank you for your business!</b><br>
	Your order history:<br><br>
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
						$orderCanBeCancelled=true;
						break;
				case "c":
				case "C":	echo "Cancelled\n";
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
