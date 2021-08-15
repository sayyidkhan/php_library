<?php
//including the database connection file
include("../../config.php");

//getting id of the data from url
$bookid = $_GET['bookid'];

//update the row from table
$result = mysqli_query($mysqli, 
			"UPDATE resources SET status='AVAILABLE'
			 WHERE bookid=$bookid");

//redirecting
header("Location: availableresourcelist.php");
?>

