<?php
//including the database connection file
include_once("config.php");

//adding the user class
include 'classes/user.php';
?>

<!-- data prep -->
<?php

//fetching data in descending order (lastest entry first)
$query = mysqli_query($mysqli, "SELECT * FROM users ORDER BY id DESC");
$result = array();
while($res = mysqli_fetch_array($query)){
	//while there is still data to query, continue query until no more result
	array_push($result, User::init($res));
}

?>

<html>
<head>	
	<title>User List</title>
</head>

<body>
	<h2>User List</h2>

	<a href="add.php">Add New Data</a><br/><br/>

	<table width='80%' border=0>

	<tr bgcolor='#CCCCCC'>
		<td>No</td>
		<td>Username</td>
		<td>Name</td>
		<td>Surname</td>
		<td>Phone</td>
		<td>Email</td>
		<td>Type</td>
		<td>Options</td>
	</tr>
	<?php
	$counter = 1;
	foreach($result as $user) {
		$userID = $user->id;

		echo "<tr>";
		echo "<td>".$counter."</td>";
		echo "<td>".$user->username."</td>";
		echo "<td>".$user->name."</td>";
		echo "<td>".$user->surname."</td>";
		echo "<td>".$user->phone."</td>";
		echo "<td>".$user->email."</td>";
		echo "<td>".$user->type."</td>";	
		echo "<td>
				<a href=\"edit.php?id=$userID\">Edit</a> |
				<a href=\"delete.php?id=$userID\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a>
			 </td>";		
		$counter += 1;
	}
	?>
	</table>
</body>
</html>
