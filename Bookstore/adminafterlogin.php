<?php
include 'dbconnect.php';
session_start ();
//$_SESSION["editisbn"]='';
if ($_SESSION ['admin'] == "") {
	header ( "Location:admin.php" );
}
$r_user=$r_address=$r_ccexpdate=$r_ccnumber=$r_cctype=$r_city=$r_email=$r_fname=$r_lname=$r_pass=$r_phone=$r_rpass=$r_state=$r_zip='';
?>
<html>
<head>
	<title>Tim Bookstore</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css"	href="css/bookstore.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script type="text/javascript">
		
		function editBook(element){
						
			$.post('getisbn.php',{postisbn:element},function(data){});
			
			
		}
		function book_inv()	{
			document.getElementsByClassName('q_b')[0].style.display = "inline";
			document.getElementsByClassName('s_r')[0].style.display = "none";
		}
						
							
	</script>
</head>
<body>
	
	<div class="" id="head">
		<div class="">
			<h3>Tim Bookstore</h3>
		
		<div id="logout">
			<form class="" action="" method="post" >
				<label>Admin! <?php $username=$_SESSION['admin'];echo $username; ?></label></br>
				<button type="submit" class="" name="logout" id="logOutButton">Logout</button>
				<button type="submit" class="" name="enter_pass" id="changePasswordButton">Change password</button>
				<button type="submit" class="" name="add_admin" id="addAdminButton">Add admin</button>				
				<button type="submit" class="" name="update_u" id="usersStatusButton">Users status</button>
				<button type="submit" class="" name="add_book" id="addBookButton">Add Book</button>				
				<button type="submit" class="" name="orders" id="ordersButton">Orders</button>
				<button type="button" class="" onclick="book_inv();" id="bookInventoryButton">Book Inventory</button>
			</form>
				
		</div>
			
	</div>
	
	<div id="search">
		<h3>Search Book</h3>
		<form action="" method="post">
				<div  class="q_b" style="display:none">
					<strong  style="">Quantity From:</strong>
					<input id="quantityFrom_Id" type="text" class=""  name="fromqty" placeholder="">
					<strong  style="">To:</strong>
					<input id="quantityTo_Id" type="text" class=""  name="toqty" placeholder="">
					</br>
					<button type="submit" class="" id="searchButton" name="Search_q">Search</button>
					
				</div >
				<div class="s_r">
					<input id="search_input" type="text" class=""  name="tosearch" placeholder="search book">
					</br>
					<label><input type="radio" name="search_r" value="author">Author</label>								
					<label><input type="radio" name="search_r" value="title">Title</label>								
					<label><input type="radio" name="search_r" value="isbn">ISBN</label>				
					<label><input type="radio" name="search_r" value="quantity">Quantity</label>			
					</br>
					<button type="submit" class="" id="searchButton" name="search_b">Search</button>
				</div>
		</form>
	</div>
	<div id="res_op">
		
<?php
	
	
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
								
				echo'<h3>List Books:</h3>
					<table align="center">
					
					
					<tr align="left">
						<th width="150px">Image</th>
						<th width="150px">Title</th>
						<th width="150px">Author</th>
						<th width="150px">ISBN</th>
						<th width="150px">Publisher</th>
						<th width="150px">Quantity</th>
						<th width="150px">Price</th>
					</tr>
					
					';
				
				while($row_array=mysqli_fetch_array($resuilt)){
					//echo '<col width="64px">';
					echo '<tr width="150px"><td><img width="64px" height="128px" src="/bookstore/img/' . $row_array['imageurl'] . '"/></td>';
					echo '<td width="150px">' . $row_array ['title'] . '</td>
						  <td width="150px">' . $row_array ['author'] . '</td>
						  <td width="150px">' . $row_array ['isbn'] . '</td>
						  <td width="150px">' . $row_array ['supplier'] . '</td>
						  <td width="150px">' . $row_array ['quantity'] . '</td>
						  <td width="150px">' . $row_array ['price'] . '</td>
					      </br>';
					
					echo '<td>';
					//echo '<input name="editbook" type="button" value="Edit Book" id='.$row_array ['isbn'].' onclick="editBook(this.id);">';
					echo '<form action="" method="post"><button name="editbook" type="submit"	id='.$row_array ['isbn'].' onclick="editBook(this.id);">Edit Book</button></form>';
					//echo '<form action="" method="post"><button name="editbook" type="submit">Edit last book</button></form>';
					echo '</td></tr>';
						
					
				}				
				echo'';				
				echo' ';
				//echo '<form action="" method="post"><button name="editbook" type="submit">Edit last book</button></form>';
            }
			else {
				print "There were no such rows in the tabel <br/>";
			}
			print "</table>";
			
		}else{
			echo "<script type='text/javascript'>alert('Please Select field to Search and Enter Text to search');</script>";
		}
	}
	//
	//----------------------------------------------------------------------------------------------------------	
	else if (isset($_POST['Search_q'])){
		$fromqty=$_POST ['fromqty'];
		$tosqty=$_POST ['toqty'];
		//if(isset ( $_POST ['search_r'] ))$typesearch=$_POST['search_r'];
		
		if(!empty($fromqty)&&!empty($tosqty)){
			
			$query="SELECT `isbn`, `title`, `author`, `subject`, `pubyear`, `description`, `imageurl`, `quantity`,
					`supplier`, `price` FROM `books` WHERE quantity >= '$fromqty' AND quantity<='$tosqty'";
			
			$resuilt=mysqli_query($con,$query);
			printSqlErr($resuilt,$con);
			
			$num_rows=mysqli_num_rows($resuilt);
			
			//print header of tabel
			if ($num_rows>0){
								
				echo'<h3>List Books:</h3>
					<table align="center">
					
					
					<tr align="left">
						<th width="150px">Image</th>
						<th width="150px">Title</th>
						<th width="150px">Author</th>
						<th width="150px">ISBN</th>
						<th width="150px">Publisher</th>
						<th width="150px">Quantity</th>
						<th width="150px">Price</th>
					</tr>
					
					';
				
				while($row_array=mysqli_fetch_array($resuilt)){
					//echo '<col width="64px">';
					echo '<tr width="150px"><td><img width="64px" height="128px" src="/bookstore/img/' . $row_array['imageurl'] . '"/></td>';
					echo '<td width="150px">' . $row_array ['title'] . '</td>
						  <td width="150px">' . $row_array ['author'] . '</td>
						  <td width="150px">' . $row_array ['isbn'] . '</td>
						  <td width="150px">' . $row_array ['supplier'] . '</td>
						  <td width="150px">' . $row_array ['quantity'] . '</td>
						  <td width="150px">' . $row_array ['price'] . '</td>
					      </br>';
					
					echo '<td>';
					//echo '<input name="editbook" type="button" value="Edit Book" id='.$row_array ['isbn'].' onclick="editBook(this.id);">';
					echo '<form action="" method="post"><button name="editbook" type="submit"	id='.$row_array ['isbn'].' onclick="editBook(this.id);">Edit Book</button></form>';
					//echo '<form action="" method="post"><button name="editbook" type="submit">Edit last book</button></form>';
					echo '</td></tr>';
						
					
				}				
				echo'';				
				echo' ';
				//echo '<form action="" method="post"><button name="editbook" type="submit">Edit last book</button></form>';
            }
			else {
				print "There were no such rows in the tabel <br/>";
			}
			print "</table>";
			
		}else{
			echo "<script type='text/javascript'>alert('Please Select field to Search and Enter Text to search');</script>";
		}
	}
	//if regiter press
	//----------------------------------------------------------------------------------------------------------	
	//else if(isset ( $_POST['editbook'] )){
	else if(!empty ( $_SESSION['editisbn'] )){	
		
		
		$b_isbn=$_SESSION['editisbn'];
		if (!empty($b_isbn)){
			$query_b="SELECT `isbn`, `title`, `author`, `subject`, `pubyear`, `description`, `imageurl`, `quantity`, 
			`supplier`, `price` FROM `books` WHERE  isbn='$b_isbn'";			
			$resuilt_b=mysqli_query($con,$query_b);
			printSqlErr($resuilt_b,$con);			
			$num_rows_b=mysqli_num_rows($resuilt_b);
			$flag=true;
			if ($num_rows_b>0){
				$row_array_b=mysqli_fetch_array($resuilt_b);
				$b_title=$row_array_b['title'];$b_author=$row_array_b['author'];
				$b_catogery=$row_array_b['subject'];$b_sup=$row_array_b['supplier'];$b_pyear=$row_array_b['pubyear'];
				$b_desc=$row_array_b['description'];$b_img=$row_array_b['imageurl'];$b_qty=$row_array_b['quantity'];
				$b_price=$row_array_b['price'];
				
				echo' <form action="" method="post">';
				echo'<h4>Update book :</h4>';
				echo'<label>ISBN no.:</label>'; 
				echo'<input type="text" id="" readonly name="new_isbn" value="';echo $b_isbn; echo'"></br>';
				echo'<label>Title:</label> ';
				echo'<input type="text" id="" name="new_title" value="';echo $b_title;echo'"> </br>';
				echo'<label>Author:</label> ';
				echo'<input type="text" id="" name="new_author"value="';echo $b_author; echo'"> </br>';
				echo'<label>Catogery:</label> ';
				echo'<input type="text" id="" name="new_catogery"value="';echo $b_catogery; echo'"> </br>';
				echo'<label>Supplier name:</label> ';
				echo'<input type="text" id="" name="new_sup"value="';echo $b_sup; echo'"> </br>';
				echo'<label>Publisher year:</label> ';
				echo'<input type="text" id="" name="new_pyear"value="';echo $b_pyear; echo'"> </br>';
				echo'<label>Description:</label> ';
				echo'<input type="text" id="" name="new_desc"value="';echo $b_desc; echo'"> </br>';
				echo'<label>Image file name:</label> ';
				echo'<input type="text" id="" name="new_img"value="';echo $b_img; echo'"> </br>';
				echo'<label>Quantity:</label> ';
				echo'<input type="text" id="" name="new_qty"value="';echo $b_qty; echo'"> </br>';
				echo'<label>Price:</label> ';
				echo'<input type="text" id="" name="new_price"value="';echo $b_price; echo'"> </br>';				
				echo'<button type="submit" class="" name="up_book_db" onclick="">Update book</button>
					
					<button type="submit" class="" name="cancel" onclick="">Cancel</button>
					 </form>';		

		
			}else{
				echo "<script type='text/javascript'>alert('Book not found');</script>";
				 }
		
		}		
		$_SESSION['editisbn']='';		
	}
	
	
	//if logout press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['logout'] )){
		$_SESSION['admin']='';
		header ( "Location:admin.php" );
		
	}
	//enter password
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['enter_pass'] )){
		echo' <form action="" method="post">
			  <h4>Change your admin password :</h4>
			  <label>Old password:</label> 
			  <input type="password" id="" placeholder="8 character and numeric" name="old_pass"> </br>
			  <label>New password:</label> 
			  <input type="password" id="" placeholder="8 character and numeric" name="new_pass"> </br>
			  <label>Reenter new Password:</label> 
			  <input type="password" id="" placeholder="renenter password" name="new_rpass"> </br>			  
			  <button type="submit" class="" name="change_pass" onclick="insertUser">Change</button>
			  <button type="submit" class="" name="cancel" onclick="">Cancel</button>
			</form> 
			
		';
	}
	//change passowrd
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['change_pass'] )){
		$admin_u=$_SESSION ['admin'];
		if(!empty ($_POST['old_pass'])&&!empty ($_POST['new_pass'])&&!empty ($_POST['new_rpass'])){
			$old_pass=$_POST['old_pass'];
			$new_pass=$_POST['new_pass'];
			
			$query_ad="SELECT `username`, `passwdhash` FROM `admins` WHERE username='$admin_u'";			
			$resuilt_ad=mysqli_query($con,$query_ad);
			printSqlErr($resuilt_ad,$con);			
			$num_rows_ad=mysqli_num_rows($resuilt_ad);
			
			//print header of tabel
			if ($num_rows_ad>0){
				while($row_array_ad=mysqli_fetch_array($resuilt_ad)){
					if ($old_pass==$row_array_ad['passwdhash']){
						if($new_pass==$_POST['new_rpass']){
							$query_up="UPDATE `admins` SET `passwdhash`=$new_pass WHERE username='$admin_u'";
							$resuilt_up=mysqli_query($con,$query_up);
							printSqlErr($resuilt_up,$con);	
							echo"<script type='text/javascript'>alert('passowrd has been changed');</script>";
						}else{
							echo"<script type='text/javascript'>alert('new passowrd is mismatch');</script>";
						}
						
					}else{
						echo"<script type='text/javascript'>alert('Incorect password');</script>";
					}
				}
			}else{
				echo "<script type='text/javascript'>alert('Admin not found');</script>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Please enter all fields');</script>";
		}
	}
	//list of order
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['orders'] )){
		header ( "Location:orders.php" );
	}
	//update user
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['update_u'] )){
		header ( "Location:searchuser.php" );
	}
	//add admin
	//----------------------------------------------------------------------------------------------------------	
	//INSERT INTO `books`(`isbn`, `title`, `author`, `subject`, `pubyear`, `description`, `imageurl`, `quantity`, `supplier`, `price`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10])
	else if(isset ( $_POST ['add_book'] )){
		registerBook();
	}
	//update book
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['up_book_db'] )){
		$b_isbn=$_POST['new_isbn'];$b_title=$_POST['new_title'];$b_author=$_POST['new_author'];
		$b_catogery=$_POST['new_catogery'];$b_sup=$_POST['new_sup'];$b_pyear=$_POST['new_pyear'];
		$b_desc=$_POST['new_desc'];$b_img=$_POST['new_img'];$b_qty=$_POST['new_qty'];
		$b_price=$_POST['new_price'];
		
		if(!empty($b_author)&&!empty($b_catogery)&&!empty($b_desc)&&!empty($b_img)&&!empty($b_isbn)&&!empty($b_price)&&
			!empty($b_pyear)&&!empty($b_qty)&&!empty($b_sup)&&!empty($b_title)){
			$check_book_already_register="SELECT * FROM `books` WHERE isbn='$b_isbn'";
			$resuilt_already=mysqli_query($con,$check_book_already_register);
			printSqlErr($resuilt_already,$con);			
			$num_rows_b=mysqli_num_rows($resuilt_already);
			
			if ($num_rows_b>0){
			
					$up_book="UPDATE books SET isbn='$b_isbn', title='$b_title', author='$b_author', subject='$b_catogery',
					 pubyear=$b_pyear, description='$b_desc', imageurl='$b_img', quantity ='$b_qty',supplier
					 ='$b_sup',price='$b_price' WHERE isbn='$b_isbn'";			
					$up_r_book = mysqli_query ($con, $up_book);
					printSqlErr($up_r_book,$con);
					echo 'Book has been updated sucssfuly';
			}else{
				echo "<script type='text/javascript'>alert('Book not');</script>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Please enter all data');</script>";
		}
	}
	//add book
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['add_book_db'] )){
		$b_isbn=$_POST['new_isbn'];$b_title=$_POST['new_title'];$b_author=$_POST['new_author'];
		$b_catogery=$_POST['new_catogery'];$b_sup=$_POST['new_sup'];$b_pyear=$_POST['new_pyear'];
		$b_desc=$_POST['new_desc'];$b_img=$_POST['new_img'];$b_qty=$_POST['new_qty'];
		$b_price=$_POST['new_price'];$b_date=$_POST['new_date'];
		
		if(!empty($b_author)&&!empty($b_catogery)&&!empty($b_desc)&&!empty($b_img)&&!empty($b_isbn)&&!empty($b_price)&&
			!empty($b_pyear)&&!empty($b_qty)&&!empty($b_sup)&&!empty($b_title)&&!empty($b_date)){
			$check_book_already_register="SELECT `isbn`,`title` FROM `books` WHERE isbn='$b_isbn' OR title='$b_title'";
			$resuilt_already=mysqli_query($con,$check_book_already_register);
			printSqlErr($resuilt_already,$con);			
			$num_rows_b=mysqli_num_rows($resuilt_already);
			
			if ($num_rows_b<1){
			
					$new_book="INSERT INTO `books`(`isbn`, `title`, `author`, `subject`, `pubyear`, 
					`description`, `imageurl`, `quantity`, `supplier`, `price`,buyerdate)
					VALUES ('$b_isbn','$b_title','$b_author','$b_catogery','$b_pyear','$b_desc','$b_img'
					,'$b_qty','$b_sup','$b_price','$b_date')";			
					$insert_new_book = mysqli_query ($con, $new_book);
					printSqlErr($insert_new_book,$con);
					echo "<script type='text/javascript'>alert('Book has been added');</script>";
			}else{
				echo "<script type='text/javascript'>alert('Book already registred');</script>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Please enter all data');</script>";
		}
	}
	//update order
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['users'] )){
		header ( "Location:index.php" );
	}
	//add admin
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['add_admin'] )){
		echo' <form action="" method="post">
			  <h4>Add new admin user :</h4>
			  <label>New Admin:</label> 
			  <input type="text" id="" placeholder="admin user" name="new_admin"> </br>
			  <label>Password:</label> 
			  <input type="password" id="" placeholder="8 character and numeric" name="adm_pass"> </br>
			  <label>Reenter password:</label> 
			  <input type="password" id="" placeholder="renenter password" name="adm_rpass"> </br>			  
			  <button type="submit" class="" name="add_admin_db" onclick="">Add admin</button>
			  <button type="submit" class="" name="cancel" onclick="">Cancel</button>
			</form> 
			
		';
	}
	//Add new admin
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['add_admin_db'] )){
		$admin_ad=$_POST ['new_admin'];
		if(!empty ($_POST['new_admin'])&&!empty ($_POST['adm_pass'])&&!empty ($_POST['adm_rpass'])){
			$adm_pass=$_POST['adm_pass'];
			//$adm_rpass=$_POST['adm_rpass'];
			
			$query_ad="SELECT `username`, `passwdhash` FROM `admins` WHERE username='$admin_ad'";			
			$resuilt_ad=mysqli_query($con,$query_ad);
			printSqlErr($resuilt_ad,$con);			
			$num_rows_ad=mysqli_num_rows($resuilt_ad);
			
			//print header of tabel
			if ($num_rows_ad==0){
				
						if($adm_pass==$_POST['adm_rpass']){
							$query_ins="INSERT INTO `admins`(`username`, `passwdhash`) VALUES ('$admin_ad','$adm_pass')";
							$resuilt_ins=mysqli_query($con,$query_ins);
							printSqlErr($resuilt_ins,$con);	
							echo"<script type='text/javascript'>alert('New admin has been added');</script>";
						}else{
							echo"<script type='text/javascript'>alert('Passowrd is mismatch');</script>";
						}
						
					
			}else{
				echo "<script type='text/javascript'>alert('Admin already register');</script>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Please enter all fields');</script>";
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
	//regiter book
	//---------------------------------------------------------------------
	function registerBook(){
		echo' <form action="" method="post">
			  <h4>Add new book :</h4>
			  <label>ISBN no.:</label> 
			  <input type="text" id="" placeholder="isbn number" name="new_isbn"> </br>
			  <label>Title:</label> 
			  <input type="text" id="" placeholder="title of book" name="new_title"> </br>
			  <label>Author:</label> 
			  <input type="text" id="" placeholder="frist and last name" name="new_author"> </br>
			  <label>Catogery:</label> 
			  <input type="text" id="" placeholder="subject of book" name="new_catogery"> </br>
			  <label>Supplier name:</label> 
			  <input type="text" id="" placeholder="isbn number" name="new_sup"> </br>
			  <label>Publisher year:</label> 
			  <input type="year" id="" placeholder="YYYY" name="new_pyear"> </br>
			  <label>Description:</label> 
			  <input type="text" id="" placeholder="information of book" name="new_desc"> </br>
			  <label>Image file name:</label> 
			  <input type="text" id="" placeholder="english.jpg" name="new_img"> </br>
			  <label>Quantity:</label> 
			  <input type="text" id="" placeholder="numeric" name="new_qty"> </br>
			  <label>Price:</label> 
			  <input type="text" id="" placeholder="20.00" name="new_price"> </br>
			  <label>Date:</label> 
			  <input type="date" id=""  name="new_date"> </br>	  	  
			  <button type="submit" class="" name="add_book_db" onclick="">Add book</button>
			  <button type="submit" class="" name="cancel" onclick="">Cancel</button>
			</form> 
			
		';
	}
	
	//----------------------------------------------------------------------------------------------------------
	
	
?>	
	</div>
	
	
</body>
</html>
