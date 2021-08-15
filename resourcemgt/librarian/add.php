<?php
session_start();
//including the database connection file
include_once("../../config.php");

//adding the resource class
include '../../classes/resources.php';

//specify signup type
define('STATUS', 'AVAILABLE'); //available by default

//USER ACCESS
define('USER_ACCESS', 'LIBRARIAN');

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
	<title>Insert a new resource</title>
</head>

<body>
	<h2>Insert a new resource</h2>

	<?php
	if(isset($_POST['Submit'])) {
			function test_input($data) {
			  $data = trim($data);
			  $data = stripslashes($data);
			  $data = htmlspecialchars($data);
			  return $data;
			}

			$bookno = mysqli_real_escape_string($mysqli, $_POST['bookno']);
			$isbn = mysqli_real_escape_string($mysqli, $_POST['isbn']);
			$title = mysqli_real_escape_string($mysqli, $_POST['title']);
			$author = mysqli_real_escape_string($mysqli, $_POST['author']);
			$publisher = mysqli_real_escape_string($mysqli, $_POST['publisher']);
			$type = mysqli_real_escape_string($mysqli, $_POST['type']);
			$status = STATUS;
			$rcost = mysqli_real_escape_string($mysqli, $_POST['rcost']);
			$ecost = mysqli_real_escape_string($mysqli, $_POST['ecost']);

			$booknoErr = "";
			$isbnErr = "";
			$titleErr = "";
			$authorErr = "";
			$publisherErr = "";
			$typeErr = "";
			$rcostErr = "";
			$ecostErr = "";
				
			//check for errors

			/* Book No  error */
			if (empty($bookno)) {
			    $booknoErr = "Book No is required";
			}
			else {
			    $bookno = test_input($bookno);
			    // check if bookno is well-formed
			    if (!filter_var($bookno, FILTER_VALIDATE_INT)) {
			      $booknoErr = "Book No is not a whole number";
			    }
			}

			/* isbn error */
			if (empty($isbn)) {
			    $isbnErr= "ISBN is required";
			} 
			else {
			    $isbn = test_input($isbn);
			    //remove dashes - store digit only
			    $isbn = str_replace("-", "", $isbn);
			    // check if username have spaces
			    if (!filter_var($isbn, FILTER_VALIDATE_INT)) {
			        $isbnErr = "ISBN format is incorrect. Only accept digits and dashes.";
			    }
			}

			/* title error */
			if (empty($title)) {
			    $titleErr = "Title is required";
			} 
			else {
			    $title = test_input($title);
			    // check if title only contains letters and whitespace
			    if (!preg_match("/^[a-zA-Z-' ]*$/",$title)) {
			      $titleErr = "Only letters and white space allowed";
			    }
			}

			/* author error */
			if (empty($author)) {
			    $authorErr = "Author is required";
			} 
			else {
			    $author = test_input($author);
			    // check if author only contains letters and whitespace
			    if (!preg_match("/^[a-zA-Z-' ]*$/",$author)) {
			      $authorErr = "Only letters and white space allowed";
			    }
			}

			/* publisher error */
			if (empty($publisher)) {
			    $publisherErr = "Publisher is required";
			}
			else {
			    $publisher = test_input($publisher);
			    if (!preg_match("/^[a-zA-Z-' ]*$/",$publisher)) {
			      $publisherErr = "Only letters and white space allowed";
			    }
			}

			/* type error */
			if (empty($type)) {
			    $typeErr = "Type is required";
			}


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
			    $ecostErr= "Cost is required";
			} 
			else {
			    $ecost = test_input($ecost);
			    // check if not numeric, throw error
			    if (!is_numeric($ecost)) {
			        $ecostErr = "Number is not in a numeric format.";
			    }
			    //if numeric - do further checking
			    else {
			    	$ecost = floatval($ecost);
			    	$ecost = number_format($ecost,2);
			    	//if higher than max cost, then throw error
			    	if($ecost > floatval(MAX_COST)) {
			    		$ecostErr = "cost set too high";
			    	}
			    	else if($ecost < $rcost) {
			    		$ecostErr = "cost set too low";
			    	}
			    	//otherwise throw no error
			    }
			}
			            

			//if there are no errors can proceed to insert
			if(empty($booknoErr) &&
			   empty($isbnErr) &&
			   empty($titleErr) &&
			   empty($authorErr) &&
			   empty($publisherErr) &&
			   empty($typeErr) &&
			   empty($rcostErr) &&
			   empty($ecostErr)
			) {
				$query = mysqli_query($mysqli, "SELECT * FROM resources WHERE isbn = '$isbn' AND bookno = '$bookno' ");
				$checkExistingResource = mysqli_fetch_array($query);
				if(!empty($checkExistingResource)) {
					//display error message
					echo "<font color='red'>There is an existing isbn with the same book no, increment either the book no or set a different isbn.</font><br/>";
				}
				else {
					//insert data to database	
					$result = mysqli_query(
						$mysqli,
						"INSERT INTO resources(bookno,isbn,title,author,publisher,type,status,rcost,ecost)
						 VALUES('$bookno','$isbn','$title','$author','$publisher','$type','$status' ,'$rcost' ,'$ecost')"
					);
					//display success message
					echo "<font color='green'>Resource added successfully.</font><br/>";

					//clear all save information
					$bookno = "";
					$isbn = "";
					$title = "";
					$author = "";
					$publisher = "";
					$type = "";
					$status = "";
					$rcost = "";
					$ecost = "";
				}

				
			}
		}
	?>

	<a href="resourcelist.php">Back to Resource list</a>
	<a style='padding-left: 1em;' href='javascript:self.history.back();'>Go Back</a>
	<br/><br/>

 	<section id='insertresource-section' style="<?php echo(($_SESSION['type']) === USER_ACCESS ? '' : 'display: none;') ?>">
		<form action="#" method="post" name="form1">
			<table width="25%" border="0">
				<tr> 
					<td>Book No</td>
					<td>
						<input class='input_length' type="text" name="bookno" value="<?php echo $bookno;?>">
						<span class="error">* <?php echo $booknoErr;?></span>
					</td>
				</tr>
				<tr> 
					<td>ISBN</td>
					<td>
						<input class='input_length' type="text" name="isbn" value="<?php echo $isbn;?>">
						<span class="error">* <?php echo $isbnErr;?></span>
					</td>
				</tr>
				<tr> 
					<td>Title</td>
					<td>
						<input class='input_length' type="text" name="title" value="<?php echo $title;?>">
						<span class="error">* <?php echo $titleErr;?></span>
					</td>
				</tr>
				<tr> 
					<td>Author</td>
					<td>
						<input class='input_length' type="text" name="author" value="<?php echo $author;?>">
						<span class="error">* <?php echo $authorErr;?></span>
					</td>
				</tr>
				<tr> 
					<td>Publisher</td>
					<td>
						<input class='input_length' type="text" name="publisher" value="<?php echo $publisher;?>">
						<span class="error">* <?php echo $publisherErr;?></span>
					</td>
				</tr>
				<tr> 
					<td>Type</td>
					<td>
						<select class='input_length' name="type" id="type">
						  <option value=""></option>
						  <option value="BOOK" <?php echo ($_POST['type'] == 'BOOK' ? ' selected' : '') ?>>BOOK</option>
 						  <option value="TEXTBOOK" <?php echo ($_POST['type'] == 'TEXTBOOK' ? ' selected' : '') ?>>TEXTBOOK</option>
 						  <option value="WORKBOOK" <?php echo ($_POST['type'] == 'WORKBOOK' ? ' selected' : '') ?>>WORKBOOK</option>
						</select>
						<span class="error">* <?php echo $typeErr;?></span>
					</td>
				</tr>
				<tr> 
					<td>Regular Cost</td>
					<td>
						<input class='input_length' type="text" name="rcost" value="<?php echo $rcost;?>">
						<span class="error">* <?php echo $rcostErr;?></span>
					</td>
				</tr>
				<tr> 
					<td>Extended Cost</td>
					<td>
						<input class='input_length' type="text" name="ecost" value="<?php echo $ecost;?>">
						<span class="error">* <?php echo $ecostErr;?></span>
					</td>
				</tr>
				<tr> 
					<td></td>
					<td><input type="submit" name="Submit" value="add"></td>
				</tr>
			</table>
		</form>

		<p><b>INFO: </b></p>
		<ul>
			<li>ISBN number is stored in digits only without dashes. You may put dashes, app will store digits only.</li>
			<li>Max Amount for Regular Cost or Extended Cost is <?php echo(number_format(MAX_COST,2)) ?> .</li>
			<li>Extended Cost have to be set higher than Regular cost . Regular cost can be the same as Extended cost.</li>
		</ul>
		
	</section>

	<section id="noaccess-section" style="<?php echo(($_SESSION['type']) === USER_ACCESS ? 'display: none;' : '') ?>">
    	<p>you have no access to this section of the page.</p>
  	</section>

</body>
</html>
