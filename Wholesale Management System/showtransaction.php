<!DOCTYPE html>
<html>
<head>
	<title>Show Transaction</title>
</head>
<body>

<a href="http://localhost/wholesale/home.php">Back to HOME</a><br/>
<form action="showtransaction.php" method="POST"><br/>
<b>Please fill up necessary boxes to search for any transaction or keep blank to view all transactions...</b><br/>
	<label>  Customer Name</label>
	<input type="text" name="customer_name"/> <br/>
	
	<label>  Item Name</label>
	<input type="text" name="item_name"/> <br/>

	<label>  Customer ID</label>
	<input type="text" name="customerid"/> <br/>

	<label>  Item ID</label>
	<input type="text" name="itemid"/> <br/>

	<button type="submit" name="search"> Search </button><br/><br/>
</form>

<?php 
	if(isset($_POST['search'])) {
		$cname=$_POST['customer_name'];
		$iname=$_POST['item_name'];
		$cid=$_POST['customerid'];
		$iid=$_POST['itemid'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());
		if($rs){
			$qry="SELECT T.transactionid,T.date,T.customerid,T.itemid,T.quantity,T.totalprice FROM Transaction T,Customer C, Item I WHERE (T.itemid='$iid' AND T.customerid='$cid' ) OR (T.customerid=C.customerid AND T.itemid=I.itemid AND C.name LIKE '%$cname%' AND I.name LIKE '%$iname%')";
			//echo $qry;
			$result=mysql_query($qry);
			$num_rows = mysql_num_rows($result);
		  	if( $num_rows > 0){

		  	    $table_string = "<table border=\"1\"><thead><tr><th>TransactionID</th><th>Customer ID</th><th>Customer Name</th><th>Item ID</th><th>Item name</th><th>Date of Trans.</th><th>Quantity</th><th>Price per Unit</th><th>Total Price</th></tr></thead>";
		  	    $table_string .="<tbody>";
				while($row=mysql_fetch_assoc($result)){
					$x=$row['customerid'];
					//echo "h".$x;
					$qry="SELECT name FROM Customer WHERE customerid='$x'";
					$r=mysql_query($qry);
					$temp=mysql_fetch_assoc($r);
					$cn=$temp['name'];
					//echo $cn;

					$x=$row['itemid'];
					$qry="SELECT name,price FROM Item WHERE itemid='$x'";
					$r=mysql_query($qry);
					$temp=mysql_fetch_assoc($r);
					$in=$temp['name'];
					$iprice=$temp['price'];


	                $table_string.="<tr><td>".$row['transactionid']."</td><td>".$row['customerid']."</td>"."<td>".$cn."</td><td>".$row['itemid']."</td><td>".$in."</td><td>".$row['date']."</td><td>".$row['quantity']."</td><td>".$iprice."</td><td>".$row['totalprice']."</td></tr>";
					
				}

				$table_string.= "</tbody></table>";

				echo $table_string;
		  	}else{
		  	    echo "No data found";
		  	}

		}
	}




 ?>

</body>
</html>