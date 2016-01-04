<?php

ob_start();

include("config.php");
if(isset($_POST['name']) && isset($_POST['company']) && isset($_POST['phoneno']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['date1']) && isset($_POST['timeslot'])) {

	$name = $_POST['name'];
	$companyName = $_POST['company'];
	$phoneNumber = $_POST['phoneno'];
	$clientEmail = $_POST['email'];
	$address = $_POST['address'];
	$date = $_POST['date1'];
	$slot = $_POST['timeslot'];
	$active="false";

		$adminEmail = "15030141072@sicsr.ac.in";
	
	
	$mailHeaderAdmin = "From: " . strip_tags($_POST['email']) . "\r\n";
	$mailHeaderAdmin .= "Reply-To: ". strip_tags($_POST['email']) . "\r\n";
	$mailHeaderAdmin .= "CC: ".$adminEmail."\r\n";
	$mailHeaderAdmin .= "MIME-Version: 1.0\r\n";
	$mailHeaderAdmin .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$mailMessageAdmin = "Hello <h2>Admin!</h2> <br><br>";
	$mailMessageAdmin .=$name." has requested a Booking<br>";
	$mailMessageAdmin .="<h2> Details </h2>";
	$mailMessageAdmin .="Company Name:".$companyName." <br>Phone Number: ".$phoneNumber."<br> Email: ".$clientEmail."<br> Address: ".$address."<br>  ";
	$mailMessageAdmin .="<h2> Date: ".$date." Timeslot: ".$slot."</h2><br>";
	$getdate="Select timeslot from customer_booking where added_date='".$date."';";
	echo $getdate;
		//$adminEmail = mysql_fetch_assoc(mysql_query($getdate));


	$mailMessageAdmin .="<br><br><h3>Time slot booked on ".$date." are:</h3><br/>";
		if (!mysql_query($getdate,$conn))
		{
			die('Error: ' . mysql_error());
		}
		else
		{
			$val=mysql_query($getdate,$conn);
			//echo "Record inserted Successfully...";
			while($row = mysql_fetch_array($val)){
				echo "row vaule".$row;
				$mailMessageAdmin .="<b> ".$row['timeslot'].",<b/>";
				
			}		
		}

	$mailMessageAdmin .="<br/><hr/> ";
	
	
	$mailMessageAdmin .="status.php?status=true&username=".$name."&email=".$clientEmail."&timeslot=".$slot."&date=".$date."'> Approve</a> | <a href='demo.aavinashh.com/nidhi/status.php?status=false&username=".$name."&email=".$clientEmail."&timeslot=".$slot."&date=".$date."'>Disapprove</a>";
	$mailMessageAdmin .="<br><br><h3>Thank You!</h3>";
	
	
	$mailHeaderClient = "From: " . strip_tags($adminEmail['adminEmail']) . "\r\n";
	$mailHeaderClient.= "Reply-To: ".$adminEmail. "\r\n";
	//$mailHeaderClient.= "CC: ".$adminEmail['adminEmail']."\r\n";
	$mailHeaderClient.= "MIME-Version: 1.0\r\n";
	$mailHeaderClient.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$mailMessageClient= "<h3>Hello ".$name."!</h3><br><br>";
	$mailMessageClient .="<p>Thank You for showing interest and booking a slot.</p><p>Your Request has been received. Please wait while your slot is confirmed. You will be notified once your booking is confirmed.<p>";
	$mailMessageClient .="<br> Thank You! ";
	if(@mail($adminEmail['adminEmail'], "Booking Request", $mailMessageAdmin, $mailHeaderAdmin)) {
		if(@mail($clientEmail, "Booking Request Received", $mailMessageClient, $mailHeaderClient)) {
			$sql="INSERT INTO customer_booking (name, company_name, email, phone_no,address,added_date,timeslot,status) VALUES ('".$name."','".$companyName."','".$clientEmail."','".$phoneNumber."','".$address."','".$date."','".$slot."','".$active."')";
			$result=mysql_query($sql,$conn);
			if (!$result)
			{
				echo 'Error in mysql: ' . mysql_error();
header('location: index.html');
			}
			else
			{
			header('location: index.html');
			}
			mysql_close($conn);
		} else {
			echo "Failed to sent to Client.. Contact Admin Redirecting in 5 Seconds";
                        header('location: index.html');
			}
		} else {
			echo "Failed to sent to admin.Contact System Admin Redirecting in 5 Seconds";
			header('location: index.html');
				}	
	
		} else {
	// Redirect to error Page
			echo "error! Data not set";header('location: index.html');
			}
?>