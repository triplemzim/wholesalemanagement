<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="home2.css">
	<title>Add Item</title>
</head>
<body>
<section>
<div id="one">
<a href="http://localhost/wholesale/home.php">Back to HOME</a><br/>
<form action="removeitem.php" method="POST"><br/>
<b>You can search for any Item...</b><br/>
	<label>  Item Name</label>
	<input type="text" name="item_name"/> 
	<button type="submit" name="search"> Search </button><br/><br/>
</form>



<?php 
	if( isset($_POST['search']) ){


		$name=$_POST['item_name'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){
			$qry = "SELECT * FROM Item WHERE name LIKE '%$name%'" ;
			

			$result = mysql_query($qry,$rs);
			//$rs = mysql_fetch_assoc($resault);
			
			$num_rows = mysql_num_rows($result);
		  	if( $num_rows > 0){

		  	    $table_string = "<table border=\"1\"><thead><tr><th>ItemID</th><th>Name</th><th>Price Per Unit</th><th>Available Quantity</th></tr></thead>";
		  	    $table_string .="<tbody>";
				while($row=mysql_fetch_assoc($result)){
	                $table_string.="<tr><td>".$row['itemid']."</td><td>".$row['name']."</td>"."<td>".$row['price']."</td><td>".$row['quantity']."</td></tr>";
					
				}

				$table_string.= "</tbody></table>";

				echo $table_string;
		  	}else{
		  	    echo "No data found";
		  	}
			

		}
		mysql_close();
	}
 ?>	


</div>
<div id="two">

<form action="removeitem.php" method="POST"><br/>


<b> Must fill up starred boxe(s) </b><br/>


<label>Item ID (*): </label><input type="text" name="itemid" /><br/>


<button type="submit", name="IDsubmit">Remove Item</button>
</form>

<?php 
	if(isset($_POST['IDsubmit'])){
		$itemid=$_POST['itemid'];
		

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){

			if(is_numeric($itemid)){

				$qry="SELECT * FROM Item WHERE itemid='$itemid'";
				$result=mysql_query($qry);
				$num_rows=mysql_num_rows($result);
				if($num_rows==0){
					echo"Item does not exist!!";
					die();
				}
			
				$qry="DELETE FROM Item WHERE itemid='$itemid'";
				
				
				mysql_query($qry);
				echo "Deletion Successful! ";


			}
			else{
				echo "Invalid input! Delete operation failed!";
			}

			
		}
		mysql_close();

	}







 ?>

</div>
</section>
</body>
</html>
