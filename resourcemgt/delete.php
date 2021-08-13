<?php
//including the database connection file
include("../config.php");

//getting id of the data from url
$bookid = $_GET['bookid'];

//deleting the row from table
$result = mysqli_query($mysqli, "DELETE FROM resources WHERE bookid=$bookid");

//redirecting to the display page (userlist.php in our case)
header("Location: resourcelist.php");
?>

