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
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css"	href="css/bookstore.css">
	<link rel="stylesheet" href="css/table.css" type="text/css" />
	<!-- import Jquery for AJAX -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script> 
	<script type="text/javascript">
		function userChange (element){
			document.getElementById(element).disabled=true;
			$.post('updateuser.php',{postuser:element},function(data){});
			
			
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
				<button type="submit" class="" name="logout" id="logOutButton">Logout</button>
				<button type="submit" class="" name="main" id="adminButton">Admin</button>
				<button type="submit" class="" name="luser" id="listUsersButton">List users</button>
			</form>
		</div>
		
			
	</div>
	
	<div id="search">
		<h3>Search customer :</h3>
		<form action="" method="post">
				<div  class="">
					<input id="search_input" type="text" class=""  name="tosearch" placeholder="search customer">
				</div>				
					<label><input type="radio" name="search_r" id="usernameId"value="username">Username</label>								
					<label><input type="radio" name="search_r" id="firstnameId"value="firstname">First Name</label>								
					<label><input type="radio" name="search_r" id="familynameId" value="lastname">Family Name</label>				
					<label><input type="radio" name="search_r" id="phoneId" value="phone">Phone</label>			
				<div class="">
					<button type="submit" class="" id="searchButton" name="search_u">Search</button>
				</div>
		</form>
	</div>
	<div id="res_op">
		
<?php
	
	
	//if search engin press
	//----------------------------------------------------------------------------------------------------------
	if (isset ( $_POST ['search_u'] )) {
		$tosearch=$_POST ['tosearch'];
		if(isset ( $_POST ['search_r'] ))$typesearch=$_POST['search_r'];
		
		if(!empty($tosearch)&&!empty($typesearch)){
						
			$query="SELECT `username`, `lastname`, `firstname`, `address`, `city`, `state`, `zip`,
					`telephone`, `email`,`isenabled` FROM `users` WHERE $typesearch Like '%$tosearch%'";
			
			$resuilt=mysqli_query($con,$query);
			printSqlErr($resuilt,$con);
			
			$num_rows=mysqli_num_rows($resuilt);
			
			//$_SESSION['endisuser']=array();
			//print header of tabel
			if ($num_rows>0){
								
				echo'
					<table align="center">
					
					<tr align="left">
						<th width="150px">Frist Name</th>
						<th width="150px">Last Name</th>
						<th width="150px">Username</th>
						<th width="150px">Adress</th>
						<th width="150px">City</th>
						<th width="150px">State</th>
						<th width="150px">Zip</th>
						<th width="150px">Telephone</th>
						<th width="150px">Enabel</th>
						<th width="150px">Email</th>
						
					</tr>
					
					<tobody>';
				$id_counter=1;	
				while($row_array=mysqli_fetch_array($resuilt)){
					$_SESSION['endisuser']=$row_array ['username'];
					//echo '<col width="64px">';
					echo '<tr width="150px">';
					echo '<td width="150px">' . $row_array ['firstname'] .'</td>
						  <td> '. $row_array ['lastname'] . '</td>
						  <td width="150px">' . $row_array ['username'] . '</td>
						  <td width="150px">' . $row_array ['address'] . '</td>
						  <td width="150px">' . $row_array ['city'] . '</td>
						  <td width="150px">' . $row_array ['state'] . '</td>
						  <td width="150px">' . $row_array ['zip'] . '</td>
						   <td width="150px">' . $row_array ['telephone'] . '</td>
						   <td width="150px">' . $row_array ['isenabled'] . '</td>
						    <td width="150px">' . $row_array ['email'] . '</td>
							 
					      </br><td><form action="" method="post">';
					if($row_array ['isenabled']=='y'||$row_array ['isenabled']=='Y'){
						echo '
							 <input type="button" name="disenableuser" class="deuser" value="Disabel"
							 id='. $row_array ['username'] .' onclick="userChange(this.id);">
							 ';
					}else{
						echo '
							 <input type="button" name="disenableuser" class="deuser" value="Enabel"
							 id='. $row_array ['username'] .' onclick="userChange(this.id);">
							 ';
					}
					echo'</form></td></tr>';
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
	//if admin press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['main'] )){
		header ( "Location:adminafterlogin.php" );
	}
	//if logout press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['logout'] )){
		$_SESSION['admin']='';
		header ( "Location:admin.php" );
		
	}
	//
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['luser'] )){
		$query="SELECT `username`, `lastname`, `firstname`, `address`, `city`, `state`, `zip`,
					`telephone`, `email`,`isenabled` FROM `users`";
			
			$resuilt=mysqli_query($con,$query);
			printSqlErr($resuilt,$con);
			
			$num_rows=mysqli_num_rows($resuilt);
			
			//$_SESSION['endisuser']=array();
			//print header of tabel
			if ($num_rows>0){
								
				echo'<h4> List all users :</h4>
					<table align="center">					
					
					<tr align="left">
						<th width="150px">Frist Name</th>
						<th width="150px">Last Name</th>
						<th width="150px">Username</th>
						<th width="150px">Adress</th>
						<th width="150px">City</th>
						<th width="150px">State</th>
						<th width="150px">Zip</th>
						<th width="150px">Telephone</th>
						<th width="150px">Enabel</th>
						<th width="150px">Email</th>
						
					</tr>
					
					<tobody>';
				$id_counter=1;	
				while($row_array=mysqli_fetch_array($resuilt)){
					$_SESSION['endisuser']=$row_array ['username'];
					//echo '<col width="64px">';
					echo '<tr width="150px">';
					echo '<td width="150px">' . $row_array ['firstname'] .'</td>
						  <td> '. $row_array ['lastname'] . '</td>
						  <td width="150px">' . $row_array ['username'] . '</td>
						  <td width="150px">' . $row_array ['address'] . '</td>
						  <td width="150px">' . $row_array ['city'] . '</td>
						  <td width="150px">' . $row_array ['state'] . '</td>
						  <td width="150px">' . $row_array ['zip'] . '</td>
						   <td width="150px">' . $row_array ['telephone'] . '</td>
						   <td width="150px">' . $row_array ['isenabled'] . '</td>
						    <td width="150px">' . $row_array ['email'] . '</td>
							 
					      </br><td><form action="" method="post">';
					if($row_array ['isenabled']=='y'||$row_array ['isenabled']=='Y'){
						echo '
							 <input type="button" name="disenableuser" class="deuser" value="Disabel"
							 id='. $row_array ['username'] .' onclick="userChange(this.id);">
							 ';
					}else{
						echo '
							 <input type="button" name="disenableuser" class="deuser" value="Enabel"
							 id='. $row_array ['username'] .' onclick="userChange(this.id);">
							 ';
					}
					echo'</form></td></tr>';
					$id_counter+=1;
				}
				echo'</tbody> </table>';
				
            }
			else {
				print "There were no such rows in the tabel <br/>";
			}
			print "</table>";
		
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
