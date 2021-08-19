<?php
session_start();
//including the database connection file
include("../../config.php");

//get today's date
$todays_date = date("y-m-d");

//getting data from url
$bookid = $_GET['bookid'];
$end_date = $_GET['end_date'];

//get the current username
$username = $_SESSION['login'];

//update the row from table
$result = mysqli_query($mysqli, 
			"UPDATE resources SET status='BORROWED', username='$username', startdate=CAST('$todays_date' AS DATE), enddate=CAST('$end_date' AS DATE)
			 WHERE bookid=$bookid");

//redirecting
header("Location: availableresourcelist.php");
?>

