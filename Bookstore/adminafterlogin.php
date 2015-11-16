<?php
include 'dbconnect.php';
session_start ();
if ($_SESSION ['admin'] == "") {
	header ( "Location:admin.php" );
}
$r_user=$r_address=$r_ccexpdate=$r_ccnumber=$r_cctype=$r_city=$r_email=$r_fname=$r_lname=$r_pass=$r_phone=$r_rpass=$r_state=$r_zip='';
?>
<html>
<head>
	<title>Tim Bookstore</title>
	<link rel="stylesheet" type="text/css"	href="css/bookstore.css">
	
	<script type="text/javascript">
		function editBook(element){
			
			<?php 
				echo'Tim code';
			?>
		}					
								
							
	</script>
</head>
<body>
	
	<div class="" id="head">
		<div class="">
			<h3>Tim Bookstore</h3>
		
		<div id="logout">
			<form class="" action="" method="post" id="login">
				<label>Admin! <?php $username=$_SESSION['admin'];echo $username; ?></label></br>
				<button type="submit" class="" name="logout">Logout</button>
				<button type="submit" class="" name="update_p">Update profile</button>
				<button type="submit" class="" name="list_o">List orders</button>
				<button type="submit" class="" name="update_u">Update users</button>
				<button type="submit" class="" name="add_book">Add Book</button>
				<button type="submit" class="" name="update_o">Update order</button>
				<button type="submit" class="" name="add_admin">Add admin</button>
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
	$con = mysqli_connect('localhost','root','',"bookstore");
		if(mysqli_connect_errno()){
            print"Connect faild: " . mysqli_connect_error();
            exit();
        }
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
					echo '<tr width="150px"><td><img width="64px" height="128px" src="/bookstore/img/' . $row_array['imageurl'] . '"/></td>';
					echo '<td width="150px">' . $row_array ['title'] . '</td>
						  <td width="150px">' . $row_array ['author'] . '</td>
						  <td width="150px">' . $row_array ['isbn'] . '</td>
						  <td width="150px">' . $row_array ['supplier'] . '</td>
						  <td width="150px">' . $row_array ['price'] . '</td>
					      </tr>';
					
					echo '<td><button name="addcart" align="right" type="button" class="addtocart"
						id='.$id_counter.' onclick="editBook(this.id);">Edit</button></td>';
						
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
	//
	//----------------------------------------------------------------------------------------------------------	
	
	//if regiter press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['register'] )){
		registerForm();
	
	}
	//if complete regigter form
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['register_complete'] )){
		$r_user=$_POST['register_user'];$r_lname=$_POST['register_lname'];$r_fname=$_POST['register_fname'];
		$r_address=$_POST['register_address'];$r_city=$_POST['register_city'];$r_state=$_POST['register_state'];
		$r_zip=$_POST['register_zip'];$r_phone=$_POST['register_phone'];$r_email=$_POST['register_email'];
		$r_pass=$_POST['register_pass'];$r_cctype=$_POST['register_cctype'];$r_ccnumber=$_POST['register_ccnumber'];
		$r_ccexpdate=$_POST['register_ccexpdate'];$r_rpass=$_POST['register_rpass'];
		
		if(!empty($r_user)&&!empty($r_lname)&&!empty($r_fname)&&!empty($r_address)&&!empty($r_city)&&!empty($r_state)&&
			!empty($r_zip)&&!empty($r_phone)&&!empty($r_pass)&&!empty($r_cctype)&&!empty($r_ccnumber)&&!empty($r_ccexpdate)&&
			!empty($r_rpass)){	
			if ($_POST['register_pass']== $_POST['register_rpass']){
			
			
				$new_user="INSERT INTO `users`(`username`, `lastname`, `firstname`, `address`, `city`,
				`state`, `zip`, `telephone`, `email`, `passwdhash`, `cctype`, `ccnumber`, `ccexpdate`, `isenabled`)
				VALUES ('$r_user','$r_lname','$r_fname','$r_address','$r_city','$r_state','$r_zip','$r_phone','$r_email',
				'$r_pass','$r_cctype',$r_ccnumber,$r_ccexpdate,'y')";
			
				$insert_new_user = mysqli_query ($con, $new_user);
				printSqlErr($insert_new_user,$con);
			}
			else{
				echo "<script type='text/javascript'>alert('Password not matched');</script>";
			}
		}
		else{
			echo "<script type='text/javascript'>alert('Please enter all data');</script>";
		}
	}
	
	//if logout press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['logout'] )){
		$_SESSION['admin']='';
		header ( "Location:admin.php" );
		
	}
	//list of order
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['list_o'] )){
		echo'Tim code';
	}
	//update user
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['update_u'] )){
		echo'Tim code';
	}
	//add book
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['add_book'] )){
		echo'Tim code';
	}
	//update order
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['update_o'] )){
		echo'Tim code';
	}
	//add admin
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['add_admin'] )){
		echo'Tim code';
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
