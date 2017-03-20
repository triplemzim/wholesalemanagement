<!DOCTYPE html>
<html>
<head>
	<title>Add Item</title>
</head>
<body>
<a href="http://localhost/wholesale/home.php">Back to HOME</a><br/>

<form action="additem.php" method="POST"><br/>
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


<br/><br/>

<form action="additem.php" method="POST"><br/>

<b> Please fill up all boxes below... </b><br/>
<b> Must fill up starred boxe(s) </b><br/>


<label>Name: </label><input type="text" name="name" /><br/>
<label>Price per unit: </label><input type="text" name="price"/><br/>
<label>Quantity: </label><input type="text" name="quantity"/><br/>

<button type="submit", name="IDsubmit">Submit</button>
</form>

<?php 
	if(isset($_POST['IDsubmit'])){
		$name=$_POST['name'];
		
		$price=$_POST['price'];
		$quantity=$_POST['quantity'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){

			if($name!="" && is_numeric($price) &&  is_numeric($quantity)){

				$qry="SELECT * FROM Item WHERE name='$name'";
				$result=mysql_query($qry);
				$num_rows=mysql_num_rows($result);
				if($num_rows>0){
					echo"Item exists!! Please Update that item...!";
					die();
				}
			
				$qry="INSERT INTO Item(name,price,quantity) VALUES('$name','$price','$quantity')";
				
				
				mysql_query($qry);
				echo"Item added !";


			}
			else{
				echo "Invalid input! No data inserted";
			}

			
		}
		mysql_close();

	}







 ?>



</body>
</html>
