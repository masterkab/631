<?php
include 'dbconnect.php';
session_start ();
//$_SESSION['admin']='';
if (!empty($_SESSION ['admin'])) {
	header ( "Location:adminafterlogin.php" );
}
$r_user=$r_address=$r_ccexpdate=$r_ccnumber=$r_cctype=$r_city=$r_email=$r_fname=$r_lname=$r_pass=$r_phone=$r_rpass=$r_state=$r_zip='';
?>
<html>
<head>
	<title>Tim Bookstore</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css"	href="css/bookstore.css">
	
	<script type="text/javascript">
				
	</script>
</head>
<body>
	
	<div class="" id="head" >
		<div class="" id="title">
			<h3>Tim Bookstore</h3>
		</div>
		
		<div id="login">
			<form class="" action="" method="post" id="login">
				<label>Admin Username:</label> 
				<input type="text" id="login_id" placeholder="Enter username" name="login_user"> </br>
				<label>Admin Password:</label> 
				<input type="password" name="login_pass" id="login_pwd" placeholder="Enter password"></br>
				<button type="submit" class="" id="buttonOne" name="login">Login</button>
				<button type="submit" class="" id = "mainButton" name="main">Main</button>
				
			</form>
		</div>
		
			
	</div>
	
	<div id="search">
		<h3>Search Book</h3>
		<form action="" method="post">
				<div  class="">
					<input type="text" class="" id="search_id" name="tosearch" placeholder="search book">
				</div>				
					<label><input type="radio" name="search_r" value="author">Author</label>								
					<label><input type="radio" name="search_r" value="title">Title</label>								
					<label><input type="radio" name="search_r" value="isbn">ISBN</label>				
								
				<div class="">
					<button type="submit" class="" id="buttonFive" name="search_b">Search</button>
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
	
	
	//if login press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['login'] )){
		if(!empty ($_POST['login_user'])&&!empty ($_POST['login_pass'])){
			$username_check=$_POST['login_user'];
			$pass_check=$_POST['login_pass'];
			
			$query_u="SELECT `username`, `passwdhash` FROM `admins` WHERE username='$username_check'";			
			$resuilt_u=mysqli_query($con,$query_u);
			printSqlErr($resuilt_u,$con);			
			$num_rows_u=mysqli_num_rows($resuilt_u);
			
			//print header of tabel
			if ($num_rows_u>0){
				while($row_array_u=mysqli_fetch_array($resuilt_u)){
					if ($pass_check==$row_array_u['passwdhash']){
						$_SESSION['admin']=$row_array_u['username'];
						header ( "Location:adminafterlogin.php" );
						
					}else{
						echo"<script type='text/javascript'>alert('Incorect password');</script>";
					}
				}
			}else{
				echo "<script type='text/javascript'>alert('Admin not found');</script>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Please enter your Admin and password');</script>";
		}
		
	}
	//if admin press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['main'] )){
		header ( "Location:index.php" );
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
