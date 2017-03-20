<!DOCTYPE html>
<html>
<head>
	<title>Make Transaction</title>
</head>
<body>

<a href="http://localhost/wholesale/home.php">Back to HOME</a><br/>
<form action="maketransaction.php" method="POST"><br/>
<b>Please enter customer name and Item name to view details...</b><br/>
	<label>  Customer Name</label>
	<input type="text" name="customer_name"/> <br/>
	
	<label>  Item Name</label>
	<input type="text" name="item_name"/> 
	<button type="submit" name="searchC"> Search </button><br/><br/>
</form>



<?php 
	if( isset($_POST['searchC']) ){




		$name=$_POST['customer_name'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){
			$qry = "SELECT * FROM Customer c JOIN Location l ON c.locationid=l.locationid WHERE c.name LIKE '%$name%'" ;
			

			$result = mysql_query($qry,$rs);
			//$rs = mysql_fetch_assoc($resault);
			
			$num_rows = mysql_num_rows($result);
		  	if( $num_rows > 0){

		  	    $table_string = "<b>Customer Details:</b> <br/><table border=\"1\"><thead><tr><th>CustomerID</th><th>Name</th><th>Registration Date</th><th>Contact No.</th><th>City</th><th>Street Name</th><th>Postal Code</th></tr></thead>";
		  	    $table_string .="<tbody>";
				while($row=mysql_fetch_assoc($result)){
	                $table_string.="<tr><td>".$row['customerid']."</td><td>".$row['name']."</td>"."<td>".$row['registrationdate']."</td><td>".$row['contactno']."</td><td>".$row['city']."</td><td>".$row['streetname']."</td><td>".$row['postalcode']."</td></tr>";
					
				}

				$table_string.= "</tbody></table>";

				echo $table_string;
		  	}else{
		  	    echo "No data found";
		  	}
			

		}
		mysql_close();


		$name=$_POST['item_name'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){
			$qry = "SELECT * FROM Item WHERE name LIKE '%$name%'" ;
			

			$result = mysql_query($qry,$rs);
			//$rs = mysql_fetch_assoc($resault);
			
			$num_rows = mysql_num_rows($result);
		  	if( $num_rows > 0){

		  	    $table_string = "<br/><br/><b>Item Details:</b><br/><table border=\"1\"><thead><tr><th>ItemID</th><th>Name</th><th>Price Per Unit</th><th>Available Quantity</th></tr></thead>";
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

<form action="maketransaction.php" method="POST"><br/>
<b>Please enter customer ID, Item ID and quantity to make transaction...</b><br/>
	<label>  Customer ID:</label>
	<input type="text" name="customer_id"/> <br/>
	
	<label>  Item ID:</label>
	<input type="text" name="item_id"/> <br/>
	<label>Quantity</label>
	<input type="text" name="quantity"/><br/><br/>
	<button type="submit" name="mktransaction"><b> Make Transaction</b> </button><br/><br/>
</form>

<?php 
	if(isset($_POST['mktransaction'])){
		$cid=$_POST['customer_id'];
		$iid=$_POST['item_id'];
		$quantity=$_POST['quantity'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){
			$qry="SELECT quantity FROM Item WHERE itemid='$iid'";
			$result=mysql_query($qry);
			$temp=mysql_fetch_assoc($result);
			$q=$temp['quantity'];

			$qry="SELECT name FROM Customer WHERE customerid='$cid'";
			$result=mysql_query($qry);
			$temp=mysql_fetch_assoc($result);
			$c=$temp['name'];
			
			if($c==""){
				echo"\n\n Invalid Customer ID. Please check again!";
				die();
			}

			if($q<$quantity){
				echo"\n\nInsufficient Item supply. Please check again! ";
				die();
			}
			else{
				$qry="SELECT price FROM Item WHERE itemid='$iid'";
				$result=mysql_query($qry);
				$temp=mysql_fetch_assoc($result);
				$p=$temp['price'];
				$total_price=$p*$quantity;

				echo"<br/>Transaction Successful.<br/>Total Price: ".$total_price." $";
				$qry="INSERT INTO Transaction(`date`,customerid,itemid,quantity,totalprice) VALUES(curdate(),'$cid','$iid','$quantity','$total_price')";
				//echo $qry;
				mysql_query($qry);
			}

		}

	}



 ?>


</body>
</html>