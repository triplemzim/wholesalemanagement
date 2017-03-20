<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="home2.css">
	<title>Update Customer</title>
</head>
<body>
<section>
<div id="one">
<a href="http://localhost/wholesale/home.php">Back to HOME</a><br/>
<form action="updatecustomer.php" method="POST"><br/>
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
<form action="updatecustomer.php" method="POST">
<b> Please enter updated information <br/>to update or leave blank to keep <br/>previous information... </b><br/>
<b> Must fill up starred boxe(s) </b><br/>

<label>Customer ID *: </label><input type="text" name="CID" /><br/>
<label>Name: </label><input type="text" name="name" /><br/>
<label>Contact No: </label><input type="text" name="contactno"/><br/>
<label>City: </label><input type="text" name="city"/><br/>
<label>Street Name: </label><input type="text" name="streetname"/><br/>
<label>Postal Code: </label><input type="text" name="postalcode"/><br/><br/>
<button type="submit", name="IDsubmit">Submit</button>
</form>

<?php 
	if(isset($_POST['IDsubmit'])){
		$name=$_POST['name'];
		$cid=$_POST['CID'];
		$contactno=$_POST['contactno'];
		$city=$_POST['city'];
		$streetname=$_POST['streetname'];
		$postalcode=$_POST['postalcode'];

		$rs  = mysql_connect("localhost","root","1234");
		mysql_select_db("mydb",$rs) or die ("Database does not exist ".mysql_error());

		if($rs){

			$qry="SELECT locationid from Customer WHERE customerid=$cid";
			$result=mysql_query($qry);
			$temp=mysql_fetch_assoc($result);
			$locationid=$temp['locationid'];

			if($name!=""){
				$qry="UPDATE Customer SET name='$name' WHERE customerid='$cid'";
				mysql_query($qry,$rs);
			}
			if($contactno!=""){
				$qry="UPDATE Customer SET contactno='$contactno' WHERE customerid='$cid'";
				mysql_query($qry,$rs);
			}
			if($city!=""){
				$qry="UPDATE Location SET city='$city' WHERE locationid='$locationid'";
				mysql_query($qry,$rs);
			}
			if($streetname!=""){
				$qry="UPDATE Location SET streetname='$streetname' WHERE locationid='$locationid'";
				mysql_query($qry,$rs);
			}
			if($postalcode!=""){
				$qry="UPDATE Location SET postalcode='$postalcode' WHERE locationid='$locationid'";
				mysql_query($qry,$rs);
			}
			echo"Customer Record Updated! ";
		}
		mysql_close();

	}







 ?>
</div>
</section>
</body>


	


</html>