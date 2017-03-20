<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="login.css">
	<title>LOGIN</title>
</head>
<body>


<br/><br/>
<div><br/><b>
	<form action="index.php" method="POST">
	    <center><label>  User ID    :</label>
		<input type="text" id="userid" name="userid"/> <br/>
		</center>
		<center>
		<label>Password: </label> 
		<input type="password" id="password" name="password" /><br/>
		</center>
		<center>
        <button name="login" type="submit"> <b>LogIn</b></button> 
        </center>
	</form>

</b>



<?php 



if(isset($_POST['login']) ){

	$userid = $_POST['userid'];
	$password = $_POST['password'];






	$rs = mysql_connect('localhost','root','1234') ;//or die ("Host not connecting.".mysql_error());
	
	
	
	mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());






	if($rs){
		$qry = "select * from users where userid='$userid' AND password='$password'";
		
		$result = mysql_query($qry,$rs);
		//$rs = mysql_fetch_assoc($resault);
		$row_count = mysql_num_rows($result);
		
	
		if( $row_count > 0 ){
			echo"Welcome $userid";
			header("Location: http://localhost/wholesale/home.php");

		}else{
			echo "<br/><center>User name and password did not match</center>";
		}
	}else{
		die("Error:".mysql_error());
	}
    
	mysql_close($rs);
   
	
}





?>
</div>

</body>
</html>