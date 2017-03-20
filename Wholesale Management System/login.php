<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
</head>
<body>
<b>
<div>
<br/><br/><br/><br/><br/><br/><br/><br/>
	<form action="login.php" method="POST">
	    <center><label>  User ID    :</label>
		<input type="text" id="userid" name="userid"/> <br/><br/>
		</center>
		<center>
		<label>Password: </label> 
		<input type="password" id="password" name="password" /><br/><br/>
		</center>
		<center>
        <button name="login" id="submit" type="submit"> <b>Submit</b></button> 
        </center>
	</form>
</div>
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


</body>
</html>