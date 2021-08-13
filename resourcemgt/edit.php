<?php
session_start();
//including the database connection file
include_once("../config.php");

//adding the user class
include '../classes/resources.php';

//USER ACCESS
define('USER_ACCESS', 'LIBRARIAN');

?>

<?php

 if(isset($_POST['update'])) {
 	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}	

	$bookid = mysqli_real_escape_string($mysqli, $_POST['bookid']);
	$status = mysqli_real_escape_string($mysqli, $_POST['status']);
	$rcost = mysqli_real_escape_string($mysqli, $_POST['rcost']);
	$ecost = mysqli_real_escape_string($mysqli, $_POST['ecost']);	
	
	$rcostErr = "";
	$ecostErr = "";

	/* rcost error */
	if (empty($rcost)) {
		$rcostErr= "Cost is required";
	} 
	else {
	    $rcost = test_input($rcost);
		// check if not numeric, throw error
		if (!is_numeric($rcost)) {
			$rcostErr = "Number is not in a numeric format.";
		}
		//if numeric - do further checking
		else {
			$rcost = floatval($rcost);
			$rcost = number_format($rcost,2);
			//if higher than max cost, then throw error
			if($rcost > floatval(MAX_COST)) {
			   $rcostErr = "cost set too high";
			}
			//otherwise throw no error
		}
	}

	/* ecost error */
	if (empty($ecost)) {
		$rcostErr= "Cost is required";
	} 
	else {
	    $ecost = test_input($ecost);
		// check if not numeric, throw error
		if (!is_numeric($ecost)) {
			$rcostErr = "Number is not in a numeric format.";
		}
		//if numeric - do further checking
		else {
			$ecost = floatval($ecost);
			$ecost = number_format($ecost,2);
			//if higher than max cost, then throw error
			if($ecost > floatval(MAX_COST)) {
			   $rcostErr = "cost set too high";
			}
			else if($ecost < $rcost) {
			   $ecostErr = "cost set too low";
			}
			//otherwise throw no error
		}
	}

	//if there are no errors can proceed to insert
	if(!empty($bookid) && !empty($status) && empty($rcostErr) &&  empty($ecostErr)) {
		//selecting data associated with this particular id
		$query = mysqli_query($mysqli, "SELECT * FROM resources WHERE bookid=$bookid ");
		$res = mysqli_fetch_array($query);
		$resources = Resources::init($res);
		$resources->status = $status;
		$resources->rcost = $rcost;
		$resources->ecost = $ecost;

		//updating the table
		$result = mysqli_query($mysqli, 
			"UPDATE resources SET status='$resources->status',rcost='$resources->rcost', ecost='$resources->ecost'
			 WHERE bookid=$resources->bookid");
		
		//display success message
		echo "<font color='green'>Resource updated successfully.</font><br/>";
		//redirectig to the display page. In our case, it is index.php
		header("refresh:3;url=resourcelist.php");
	}

}

?>

<?php
//getting id from url
$bookid = $_GET['bookid'];

//selecting data associated with this particular id
$query = mysqli_query($mysqli, "SELECT * FROM resources WHERE bookid=$bookid ");
$res = mysqli_fetch_array($query);
$resources = Resources::init($res);

?>

<html>

<style>
.error {
	color: red;
}

.input_length {
	width: 15em;
}

</style>

<head>	
	<title>Edit Resource List</title>
</head>

<body>
	<div style='margin-bottom: 1em;margin-top: 1em;'>
		<a style='padding-left: 1em;' href="../index.php">Home</a>
	    <a style='padding-left: 1em;' href='resourcelist.php'>Back to Resource List</a>
	    <a style='padding-left: 1em;' href='javascript:self.history.back();'>Go Back</a>
  	</div>

  	<section id='insertresource-section' style="<?php echo(($_SESSION['type']) === USER_ACCESS ? '' : 'display: none;') ?>">
		<form name="form1" method="post" action="#">
			<table border="0">
				<tr> 
					<td>Book ID</td>
					<td>
						<input name="bookid" value="<?php echo $resources->bookid;?>" hidden>
						<input class='input_length' type="text" value="<?php echo $resources->bookid;?>" disabled>
					</td>
				</tr>
				<tr> 
					<td>Book No</td>
					<td>
						<input class='input_length' type="text" value="<?php echo $resources->bookno;?>" disabled>
					</td>
				</tr>
				<tr> 
					<td>ISBN</td>
					<td>
						<input class='input_length' type="text" value="<?php echo $resources->isbn;?>" disabled>
					</td>
				</tr>
				<tr> 
					<td>Title</td>
					<td>
						<input class='input_length' type="text" value="<?php echo $resources->title;?>" disabled>
					</td>
				</tr>
				<tr> 
					<td>Author</td>
					<td>
						<input class='input_length' type="text" value="<?php echo $resources->author;?>" disabled>
					</td>
				</tr>
				<tr> 
					<td>Publisher</td>
					<td>
						<input class='input_length' type="text" value="<?php echo $resources->publisher;?>" disabled>
					</td>
				</tr>
				<tr> 
					<td>Type</td>
					<td>
						<input class='input_length' type="text" value="<?php echo $resources->type;?>" disabled>
					</td>
				</tr>
				<tr> 
					<td>Status</td>
					<td>
						<select class='input_length' name="status">
							<option value="AVAILABLE" <?php echo ($resources->status == 'AVAILABLE' ? ' selected' : '') ?>>AVAILABLE</option>
	 						<option value="BORROWED" <?php echo ($resources->status == 'BORROWED' ? ' selected' : '') ?>>BORROWED</option>
	 						<option value="EXTENDED" <?php echo ($resources->status == 'EXTENDED' ? ' selected' : '') ?>>EXTENDED</option>
						</select>
						<span class="error">*</span>
					</td>
				</tr>
				<tr> 
					<td>Regular Cost&nbsp;&nbsp;</td>
					<td>
						<input class='input_length' type="text" name="rcost" value="<?php echo $resources->rcost;?>">
						<span class="error">* <?php echo $rcostErr;?></span>
					</td>
				</tr>
				<tr> 
					<td>Extended Cost&nbsp;&nbsp;</td>
					<td>
						<input class='input_length' type="text" name="ecost" value="<?php echo $resources->ecost;?>">
						<span class="error">* <?php echo $ecostErr;?></span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="update" value="Update"></td>
				</tr>
			</table>
		</form>

		<p><b>INFO: </b></p>
		<ul>
			<li>Max Amount for Regular Cost or Extended Cost is <?php echo(number_format(MAX_COST,2)) ?> .</li>
			<li>Extended Cost have to be set higher than Regular cost . Regular cost can be the same as Extended cost.</li>
		</ul>
	</section>

	<section id="noaccess-section" style="<?php echo(($_SESSION['type']) === USER_ACCESS ? 'display: none;' : '') ?>">
    	<p>you have no access to this section of the page.</p>
  	</section>
</body>
</html>
