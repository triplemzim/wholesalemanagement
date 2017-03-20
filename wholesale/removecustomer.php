<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="home2.css">
	<title>Remove Customer</title>
</head>
<body>
<section>
<div id="one">
<a href="http://localhost/wholesale/home.php">Back to HOME</a><br/>
<form action="removecustomer.php" method="POST"><br/>
<b>Please search the name of the customer...</b><br/>
	<label>  Customer Name</label>
	<input type="text" name="customer_name"/> 
	<button type="submit" name="search"> Search </button><br/><br/>
</form>



<?php 
	if( isset($_POST['search']) ){


		$name=$_POST['customer_name'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){
			$qry = "SELECT * FROM Customer c JOIN Location l ON c.locationid=l.locationid WHERE c.name LIKE '%$name%'" ;
			

			$result = mysql_query($qry,$rs);
			//$rs = mysql_fetch_assoc($resault);
			
			$num_rows = mysql_num_rows($result);
		  	if( $num_rows > 0){

		  	    $table_string = "<table border=\"1\"><thead><tr><th>CustomerID</th><th>Name</th><th>Registration Date</th><th>Contact No.</th><th>City</th><th>Street Name</th><th>Postal Code</th></tr></thead>";
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
	}
 ?>	


</div>
<div id="two">

<form action="removecustomer.php" method="POST"><br/>
<b>Please enter customer ID...</b><br/>
	<label>  Customer ID: </label>
	<input type="text" name="CID"/><br/> 
	<button type="submit" name="remove"> Remove </button><br/>
</form>


<?php 
	if(isset($_POST['remove'])){
		
		$cid=$_POST['CID'];
		

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){

			$qry="SELECT locationid from Customer WHERE customerid=$cid";
			$result=mysql_query($qry);
			$temp=mysql_fetch_assoc($result);
			$locationid=$temp['locationid'];
			
			if($cid!="" && $locationid!=""){
				$qry="DELETE FROM Customer WHERE customerid='$cid'";
				mysql_query($qry,$rs);
				
				$qry="DELETE FROM Location WHERE locationid='$locationid'";
				mysql_query($qry,$rs);
				echo"Customer record removed! ";
			}
			else
				echo"Error finding Customer details! ";
		}
		mysql_close();

	}


 ?>



</div>
</section>
</body>
</html>
