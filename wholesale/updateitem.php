<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="home2.css">
	<title>Update Item</title>
</head>
<body>
<section>
<div id="one">
<a href="http://localhost/wholesale/home.php">Back to HOME</a><br/>
<form action="updateitem.php" method="POST"><br/>
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

<form action="updateitem.php" method="POST"><br/>

<b> Please fill up boxes below... </b><br/>
<b> Must fill up starred boxe(s) </b><br/>

<label>Item ID (*): </label><input type="text" name="itemid" /><br/>
<label>Name: </label><input type="text" name="name" /><br/>
<label>Price per unit: </label><input type="text" name="price"/><br/>
<label>Quantity: </label><input type="text" name="quantity"/><br/>

<button type="submit", name="IDsubmit">Submit</button>
</form>

<?php 
	if(isset($_POST['IDsubmit'])){
		$name=$_POST['name'];
		$itemid=$_POST['itemid'];
		$price=$_POST['price'];
		$quantity=$_POST['quantity'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){

			$qry="SELECT * FROM Item WHERE itemid='$itemid'";
			$result=mysql_query($qry);
			$num_rows=mysql_num_rows($result);
			if($num_rows==0){
				echo"Item does not exist!!";
				die();
			}

			if($name!="" ){
				mysql_query("UPDATE Item SET name='$name' WHERE itemid='$itemid'");
			}
			if(is_numeric($price)){
				mysql_query("UPDATE Item SET price='$price' WHERE itemid='$itemid'");
			}
			if(is_numeric($quantity)){
				mysql_query("UPDATE Item SET quantity='$quantity' WHERE itemid='$itemid'");
			}


			echo"Item updated !";


		}
	
		mysql_close();


	}







 ?>


</div>
</section>
</body>
</html>
