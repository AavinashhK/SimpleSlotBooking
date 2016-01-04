<?php



$hostname = "HOSTNAME";
$username= "USERNAME";
$password= "PASSWORD";
$dbname= "DBNAME";
$conn=mysql_connect($hostname,$username,$password);
if(!$conn )
	die("not connected to MySQL".mysql_error());
else {
	mysql_select_db($dbname);
}
?>
