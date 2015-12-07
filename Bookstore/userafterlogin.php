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
<link href="tim_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css"	href="css/bookstore.css">
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
	<script type="text/javascript" src="js/addtocart.js"> </script>
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
				  <form	action="" method="post">
                   
					<li><a class="menu_02"><button type="submit" class="" id="updateProfileButton" name="update_p">Update profile</button></a></li>
					<li><a class="menu_03"><button type="submit" class="" id="pastOrdersButton" name="past_o">Past orders</button></a></li>
                                       
				   </form>	
                </ul>
            </div>
            <div class="search">
		<h3>Search Book</h3>
		<form action="" method="post">
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
                  <img src="images/bookImage.png" alt="Image 01" width="150px" height="60px" class="image_wrapper image_fl" />
                   <div class="content_section last_section">
                	<div id="basket">
			<form class="" action="checkout.php" method="post" id="basket_form">
				<label>Cart=</label> 
				<output type="text" id="cart" name="cartn" > <?=getCountOfItemsInBasket($con)?> </output></br>
				<button type="submit" class="" id="checkOutButton" name="checkout">Checkout</button>
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
				
	<!-- <div class="" id="head">
		<div class="" id="title">
			<h3>Tim Bookstore</h3>
		</div>
		<div id="basket">
			<form class="" action="checkout.php" method="post" id="basket_form">
				<label>Cart=</label> 
				<output type="text" id="cart" name="cartn" > <?=getCountOfItemsInBasket($con)?> </output></br>
				<button type="submit" class="" id="checkOutButton" name="checkout">Checkout</button>
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
		<form action="" method="post">
				<div  class="">
					<input id="search_input" type="text" class=""  name="tosearch" placeholder="search book">
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
	else if(isset($_POST['register_complete'])) { 
		// check for changes
		$origData=$_SESSION['updateData'];
		$r_lname=$_POST['register_lname'];
		$r_fname=$_POST['register_fname'];
       	        $r_address=$_POST['register_address'];
		$r_city=$_POST['register_city'];
		$r_state=$_POST['register_state'];
               	$r_zip=$_POST['register_zip'];
		$r_phone=$_POST['register_phone'];
		$r_email=$_POST['register_email'];
               	$r_pass=$_POST['register_pass'];
		$r_cctype=$_POST['register_cctype'];
		$r_ccnumber=$_POST['register_ccnumber'];
               	$r_ccexpdate=$_POST['register_ccexpdate'];
		$r_rpass=$_POST['register_rpass'];
               	if(!empty($r_lname)&&!empty($r_fname)&&!empty($r_address)&&!empty($r_city)&&!empty($r_state)&&
                       !empty($r_zip)&&!empty($r_phone)){ 
			$onChange=false;
			$sqlStmt="UPDATE users ";
			if(!($origData['lastname']==$r_lname)) {
				$sqlStmt=$sqlStmt."SET lastname='".$r_lname."'"; 
				$onChange=true;
			}
			if(!($origData['firstname']==$r_fname)) {
				if($onChange) {
					$sqlStmt=$sqlStmt.", firstname='".$r_fname."'";
				} else {
					$sqlStmt=$sqlStmt."SET firstname='".$r_fname."'";
					$onChange=true;
				}
			}
			if(!($origData['address']==$r_address)) {
				if($onChange) {
					$sqlStmt=$sqlStmt.", address='".$r_address."'";
				} else {
					$sqlStmt=$sqlStmt."SET address='".$r_address."'";
					$onChange=true;
				}
			}
			if(!($origData['city']==$r_city)) {
				if($onChange) {
					$sqlStmt=$sqlStmt.", city='".$r_city."'";
				} else {
					$sqlStmt=$sqlStmt."SET city='".$r_city."'";
					$onChange=true;
				}
			}
			if(!($origData['state']==$r_state)) {
				if($onChange) {
					$sqlStmt=$sqlStmt.", state='".$r_state."'";
				} else {
					$sqlStmt=$sqlStmt."SET state='".$r_state."'";
					$onChange=true;
				}
			}
			if(!($origData['zip']==$r_zip)) {
				if($onChange) {
					$sqlStmt=$sqlStmt.", zip='".$r_zip."'";
				} else {
					$sqlStmt=$sqlStmt."SET zip='".$r_zip."'";
					$onChange=true;
				}
			}
			if(!($origData['telephone']==$r_phone)) {
				if($onChange) {
					$sqlStmt=$sqlStmt.", telephone='".$r_phone."'";
				} else {
					$sqlStmt=$sqlStmt."SET telephone='".$r_phone."'";
					$onChange=true;
				}
			}
			if(!($origData['email']==$r_email)) {
				if($onChange) {
					$sqlStmt=$sqlStmt.", email='".$r_email."'";
				} else {
					$sqlStmt=$sqlStmt."SET email='".$r_email."'";
					$onChange=true;
				}
			}
			if(!($origData['cctype']==$r_cctype)) {
				if($onChange) {
					$sqlStmt=$sqlStmt.", cctype='".$r_cctype."'";
				} else {
					$sqlStmt=$sqlStmt."SET cctype='".$r_cctype."'";
					$onChange=true;
				}
			}
			if(!empty($r_pass)) {
				if($r_pass==$r_rpass) {
					$passwdHash=crypt($r_pass);
					if($onChange) {
						$sqlStmt=$sqlStmt.", passwdhash='".$passwdHash."'";
					} else {
						$sqlStmt=$sqlStmt." SET passwdhash='".$passwdHash."'";
						$onChange=true;
					}
				} else {
					echo '<b>Passwords do not match</b><br>';
					unset($_SESSION['updateData']);
					registerForm($con);
				}
			}
			if($onChange) {
				$sqlStmt=$sqlStmt." WHERE username='".$_SESSION['usern']."'";
				error_log($sqlStmt);
				$sqlCmd=$con->prepare($sqlStmt);
				if($result=mysqli_stmt_execute($sqlCmd)==1) { // success
					echo "<b>User data has been updated</b><br>";
					echo '<a href="userafterlogin.php">Return to search</a>';
					unset($_SESSION['updateData']);
				} else {
					echo "$sqlStmt failed";
					unset($_SESSION['updateData']);
				}
			} else {
				echo "<b>User data unchanged</b><br>";
				echo '<a href="userafterlogin.php">Return to search</a>';
				unset($_SESSION['updateData']);
			} 
		} else { 
			echo "<b>Please fill in all required fields</b><br>";
			unset($_SESSION['updateData']);
			registerForm($con);
		}
	}
	else if(isset ( $_POST ['update_p'] )){ //  1
//		echo'Tim code';
			registerForm($con);
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
	
        function registerForm($con){
		$sqlStmt="SELECT * FROM users WHERE username='".$_SESSION['usern']."'";
		$result=mysqli_query($con,$sqlStmt);
		if($result->num_rows==0) {
			echo "Failed";
		} else {
			$mySel=$result->fetch_assoc();
			$origData=array();
			$origData['lastname']=$mySel['lastname'];
			$origData['firstname']=$mySel['firstname'];
			$origData['address']=$mySel['address'];
			$origData['city']=$mySel['city'];
			$origData['state']=$mySel['state'];
			$origData['zip']=$mySel['zip'];
			$origData['telephone']=$mySel['telephone'];
			$origData['email']=$mySel['email'];
			$origData['passwdhash']=$mySel['passwdhash'];
			$origData['cctype']=$mySel['cctype'];
			$origData['ccnumber']=$mySel['ccnumber'];
			$origData['ccexpdate']=$mySel['ccexpdate'];
			$_SESSION['updateData']=$origData;
			$isVisa='';
			$isMasterCard='';
			switch($mySel['cctype']) {
				case 'v':
				case 'V':	$isVisa='selected';
						break;
				case 'm':
				case 'M':	$isMasterCard='selected';
						break;
			}
	                echo' <form class="formdesign" action="" method="post">
        	                  <h4>Update user :</h4><br>
                	          <label>First name             :</label>
                        	  <input type="text" id="" placeholder="Enter first name" name="register_fname" value="'.$mySel['firstname'].'"> </br>
            	                  <label>Family name    :</label>
                	          <input type="text" id="" placeholder="Enter family name" name="register_lname" value="'.$mySel['lastname'].'"></br>
                        	  <label>Username               :</label>
	                          <input type="text" id="" placeholder="Enter username" name="register_user" value="'.$_SESSION['usern'].'" disabled> </br>
        	                  <label>Email:</label>
	                          <input type="text" id="" placeholder="email@booksore.com" name="register_email" value="'.$mySel['email'].'"> </br>
        	                  <label>Password:</label>
                	          <input type="password" id="" placeholder="8 character and numeric" name="register_pass"> </br>
	                          <label>Reenter Password:</label>
        	                  <input type="password" id="" placeholder="renenter password" name="register_rpass"> </br>
	                          <label>Address:</label>
        	                  <input type="text" id="" placeholder="ex:2332 twin ford street" name="register_address" value="'.$mySel['address'].'"> </br>
	                          <label>City:</label>
	                          <input type="text" id="" placeholder="Ypslanti" name="register_city" value="'.$mySel['city'].'"> </br>
	                          <label>Zip:</label>
	                          <input type="text" id="" placeholder="48197" name="register_zip" value="'.$mySel['zip'].'"> </br>
	                          <label>State:</label>
        	                  <input type="text" id="" placeholder="MI" name="register_state" value="'.$mySel['state'].'"> </br>
                	          <label>Card Type:</label>
                        	  <select name="register_cctype">
	                                <option value="v"'.$isVisa.'>Visa</option>
        	                        <option value="m"'.$isMasterCard.'>Master Card</option>
	                          </select></br>
        	                  <label>Telphone:</label>
	                          <input type="text" id="" placeholder="10 digits" name="register_phone" value="'.$mySel['telephone'].'"> </br>
        	                  <label>Card number:</label>
                	          <input type="text" id="" placeholder="16 digits" name="register_ccnumber" value="'.$mySel['ccnumber'].'"> </br>
                        	  <label>Expiration date:</label>
	                          <input type="text" id="" placeholder="MM-Year" name="register_ccexpdate" value="'.$mySel['ccexpdate'].'"> </br>
        	                  <button type="submit" class="" name="register_complete" >Update</button>
	                          <button type="submit" class="" name="cancel" onclick="">Cancel</button>
        	                </form>

                	';
		}
        }
?>	
	</div>
	
	
</body>
</html>
