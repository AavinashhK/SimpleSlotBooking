<?php


include("config.php");
// post = status.php?status=0  status.php?status=1
if($_GET['status']) {
	
	$status = mysql_real_escape_string($_GET['status']);
	$timeslot=mysql_real_escape_string($_GET['timeslot']);
	$date=mysql_real_escape_string($_GET['date']);
	 $user=mysql_real_escape_string($_GET['username']);
	 $email=mysql_real_escape_string($_GET['email']);
	//echo $date." ".$timeslot." ".$user; 
	$sql1 = "SELECT `adminEmail` FROM `settings` WHERE 1";
	$adminEmail = "15030141072";
	$mailHeaderClient = "From: " . strip_tags($adminEmail) . "\r\n";
	$mailHeaderClient.= "Reply-To: ". strip_tags($adminEmail) . "\r\n";
	//$mailHeaderClient.= "CC: ".$adminEmail['adminEmail']."\r\n";
	$mailHeaderClient.= "MIME-Version: 1.0\r\n";
	$mailHeaderClient.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$smsClientYes = "Your Slot has been approved.".$date." ".$timeslot.".Thank You.";
	$smsClientNo = "Your Slot has not been approved.".$date." ".$timeslot.".Thank You.";
	
	$mailMessageClient= "<h3>Hello ".$user."!</h3><br><br>";
	if($status=="true"){
		$sql="UPDATE customer_booking SET status='".$status."' WHERE (name='".$user."' and email='".$email."' and timeslot='".$timeslot."' and added_date='".$date."')";
		if (!mysql_query($sql,$conn))
		{
			die('Error: ' . mysql_error());
		}
		else
		{
			echo "Record inserted Successfully...";
			
			$mailMessageClient .="<p>Thank You for showing interest and booking a slot.</p><p>Your Request has been approved.</p><p>Your Time slot is <b>".$date." </b> at <b>".$timeslot."</b></p>";
			$mailMessageClient .="<br> Thank You! ";
			if(@mail($email, "Booking Confirmed", $mailMessageClient, $mailHeaderClient))
			{
					
				echo "Message Send Successfully";
			}else{
					echo "Error in delivering mail";
			}
			
		}
		}
		if($status=="false"){
			$mailMessageClient1 .="<p>Thank You for showing interest and booking a slot.</p><p>Your Request has been not been approved.</p><p>Please try again with another slot</p>";
			$mailMessageClient1 .="<br> Thank You! ";
			if(@mail($email, "Booking Cancelled", $mailMessageClient1, $mailHeaderClient))
			{
				echo "Message Send Successfully";
			}else{
					echo "Error in delivering mail";
			}
			
		}
	
}
?>
