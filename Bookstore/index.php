<?php
include 'dbconnect.php';
session_start ();
ob_start();
$_SESSION['usern']='';
$r_user=$r_address=$r_ccexpdate=$r_ccnumber=$r_cctype=$r_city=$r_email=$r_fname=$r_lname=$r_pass=$r_phone=$r_rpass=$r_state=$r_zip='';
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>The Tim Book Store</title>
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
                   
					<li><a class="menu_02"><button type="submit" class="menu_02" id="" name="register">Register</button></a></li>
					<li><a class="menu_03"><button type="submit" class="menu_03" id="" name="admin">Admin</button></a></li>
                                       
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
                  <img src="images/bookImage.png" alt="Image 01" width="150px" height="80px" class="image_wrapper image_fl" />
                   <div class="content_section last_section">
                	<div class="loginform">
                		<p><h2>Login Here</h2></p>
                	<form class = "" action="" method="post"  id="login">
                		<p><label>Username:</label> <input type="text" id="login_id" name="login_user" placeholder="Username or Email"></p>
        <p>
        	<label>Password:</label> <input type="password" name="login_pass" id="login_pwd" placeholder="Password"></p>
        
               <p><button type="submit" class="" id="buttonOne" name="login">Login</button>
				<button type="submit" class="" id="buttonTwo" name="register">Register</button>
				<button type="submit" class="" id="buttonThree" name="admin">Admin</button></p>
        
      </form>
      </div>
                </div>
				
                
		
	
	<div id="res_op">
		
<?php
	
	//connect to DB
	//----------------------------------------------------------------------------------------------------------
	/*$con = mysqli_connect('localhost','root','',"bookstore");
		if(mysqli_connect_errno()){
            print"Connect faild: " . mysqli_connect_error();
            exit();
        }*/
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
					
					
					<tr align="left">
						<th width="150px">Image</th>
						<th width="150px">Title</th>
						<th width="150px">Author</th>
						<th width="150px">ISBN</th>
						<th width="150px">Publisher</th>
						<th width="150px">Price</th>
					</tr>
					
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
			$check_user_already_register="SELECT `username`, `email` FROM `users` WHERE username='$r_user' OR email='$r_email'";
			$resuilt_already=mysqli_query($con,$check_user_already_register);
			printSqlErr($resuilt_already,$con);			
			$num_rows_c=mysqli_num_rows($resuilt_already);
			
			if ($num_rows_c<1){
				
				if ($_POST['register_pass']== $_POST['register_rpass']){
			
					$new_user="INSERT INTO `users`(`username`, `lastname`, `firstname`, `address`, `city`,
					`state`, `zip`, `telephone`, `email`, `passwdhash`, `cctype`, `ccnumber`, `ccexpdate`, `isenabled`)
					VALUES ('$r_user','$r_lname','$r_fname','$r_address','$r_city','$r_state','$r_zip','$r_phone','$r_email',
					'".crypt($r_pass)."','$r_cctype',$r_ccnumber,$r_ccexpdate,'y')";
			
					$insert_new_user = mysqli_query ($con, $new_user);
					printSqlErr($insert_new_user,$con);
				}
				else{
					echo "<script type='text/javascript'>alert('Password not matched');</script>";
				}
			}else{
				echo "<script type='text/javascript'>alert('User or email already registred');</script>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Please enter all data');</script>";
		}
	echo $r_ccexpdate;	
	}
	//if login press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['login'] )){
		if(!empty ($_POST['login_user'])&&!empty ($_POST['login_pass'])){
			$username_check=$_POST['login_user'];
			
			$query_u="SELECT `username`, `passwdhash`,`isenabled`  FROM `users` WHERE username='$username_check'";			
			$resuilt_u=mysqli_query($con,$query_u);
			printSqlErr($resuilt_u,$con);			
			$num_rows_u=mysqli_num_rows($resuilt_u);
			
			//print header of tabel
			if ($num_rows_u>0){
				while($row_array_u=mysqli_fetch_array($resuilt_u)){
					$pass_check=crypt($_POST['login_pass'],$row_array_u['passwdhash']);
					if ($pass_check==$row_array_u['passwdhash']){
						if($row_array_u['isenabled']=='y'||$row_array_u['isenabled']=='Y'){
							$_SESSION['usern']=$row_array_u['username'];
							header ( "Location:userafterlogin.php" );
						}else{
							echo"<script type='text/javascript'>alert('User Disabled');</script>";
						}	
					}else{
						echo"<script type='text/javascript'>alert('Incorect password');</script>";
					}
				}
			}else{
				echo "<script type='text/javascript'>alert('User not found');</script>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Please enter your username and password');</script>";
		}
		
	}
	//if admin press
	//----------------------------------------------------------------------------------------------------------	
	else if(isset ( $_POST ['admin'] )){
		header ( "Location:admin.php" );
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
	//register form
	function registerForm(){
		echo' <form class="formdesign" action="" method="post">
			  <h4>Register new user	:</h4>
			  <label>First name		:</label> 
			  <input type="text" id="" placeholder="Enter first name" name="register_fname"> </br>
			  <label>Family name	:</label> 
			  <input type="text" id="" placeholder="Enter family name" name="register_lname"> </br>
			  <label>Username		:</label> 
			  <input type="text" id="" placeholder="Enter username" name="register_user"> </br>
			  <label>Email:</label> 
			  <input type="text" id="" placeholder="email@booksore.com" name="register_email"> </br>
			  <label>Password:</label> 
			  <input type="password" id="" placeholder="8 character and numeric" name="register_pass"> </br>
			  <label>Re-enter Password:</label> 
			  <input type="password" id="" placeholder="re-enter password" name="register_rpass"> </br>
			  <label>Address:</label> 
			  <input type="text" id="" placeholder="ex:2332 twin ford street" name="register_address"> </br>
			  <label>City:</label> 
			  <input type="text" id="" placeholder="Ypslanti" name="register_city"> </br>
			  <label>Zip:</label> 
			  <input type="text" id="" placeholder="48197" name="register_zip"> </br>
			  <label>State:</label> 
			  <input type="text" id="" placeholder="MI" name="register_state"> </br>
			  <label>Card Type:</label> 
			  <select name="register_cctype">
				<option value="v">Visa</option>
				<option value="m">Master Card</option>  
			  </select></br>
			  <label>Telphone:</label> 
			  <input type="text" id="" placeholder="10 digits" name="register_phone"> </br>
			  <label>Card number:</label> 
			  <input type="text" id="" placeholder="16 digits" name="register_ccnumber"> </br>
			  <label>Expiration date:</label> 
			  <input type="text" id="" placeholder="MM-Year" name="register_ccexpdate"> </br>
			  <button type="submit" class="" name="register_complete" onclick="insertUser">Register</button>
			  <button type="submit" class="" name="cancel" onclick="">Cancel</button>
			</form> 
			
		';
	}
	//--------------------------------------------------------------------------------------------------
	
?>	
	</div>
	</div>
               
                </div>
                </div>
               </div>
              </div>
	
</body>
</html>
