<?php
session_start();
//including the database connection file
include("../../config.php");

//getting id of the data from url
$bookid = $_GET['bookid'];

//get the current username
$username = $_SESSION['login'];

//get today's date

//update the row from table
$result = mysqli_query($mysqli, 
			"UPDATE resources SET status='EXTENDED', username='$username'
			 WHERE bookid=$bookid");

//redirecting
header("Location: availableresourcelist.php");
?>

