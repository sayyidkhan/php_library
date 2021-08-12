<?php
//including the database connection file
include_once("config.php");

//adding the user class
include 'classes/user.php';

//specify signup type
define('TYPE', 'BORROWER'); //filepath to expinterest.txt
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
	<title>Register - Borrowers</title>
</head>

<body>
	<h2>Register Account</h2>

	<?php
	if(isset($_POST['Submit'])) {
			function test_input($data) {
			  $data = trim($data);
			  $data = stripslashes($data);
			  $data = htmlspecialchars($data);
			  return $data;
			}

			$username = mysqli_real_escape_string($mysqli, $_POST['username']);
			$password = mysqli_real_escape_string($mysqli, $_POST['password']);
			$name = mysqli_real_escape_string($mysqli, $_POST['name']);
			$surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
			$phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
			$email = mysqli_real_escape_string($mysqli, $_POST['email']);
			$type = TYPE;

			$usernameErr = "";
			$passwordErr = "";
			$nameErr = "";
			$surnameErr = "";
			$phoneErr = "";
			$emailErr = "";
				
			//check for errors

			/* username error */
			if (empty($_POST["username"])) {
			    $usernameErr= "username is required";
			} 
			else {
			    $username = test_input($_POST["username"]);
			    // check if username have spaces
			    if (preg_match('/\s/',$username)) {
			      $usernameErr = "username cannot have spaces";
			    }
			}

			/* password error */
			if (empty($_POST["password"])) {
			    $passwordErr= "password is required";
			} 
			else {
			    $password = test_input($_POST["password"]);
			    // check if username have spaces
			    if (strlen($password) < '8') {
			        $passwordErr = "Your Password Must Contain At Least 8 Characters!";
			    }
			}

			/* name error */
			if (empty($_POST["name"])) {
			    $nameErr = "Name is required";
			} 
			else {
			    $name = test_input($_POST["name"]);
			    // check if name only contains letters and whitespace
			    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
			      $nameErr = "Only letters and white space allowed";
			    }
			}

			/* surname error */
			if (empty($_POST["surname"])) {
			    $surnameErr = "Surname is required";
			} 
			else {
			    $surname = test_input($_POST["surname"]);
			    // check if surname only contains letters and whitespace
			    if (!preg_match("/^[a-zA-Z-' ]*$/",$surname)) {
			      $surnameErr = "Only letters and white space allowed";
			    }
			}

			/* phone error */
			if (empty($_POST["phone"])) {
			    $phoneErr = "Phone number is required";
			}
			else {
			    $phone = test_input($_POST["phone"]);
			    if (!preg_match("/^[0-9]*$/",$phone)) {
			      $phoneErr = "Only numbers allowed";
			    }
			}

			/* email error */
			if (empty($_POST["email"])) {
			    $emailErr = "Email is required";
			}
			else {
			    $email = test_input($_POST["email"]);
			    // check if e-mail address is well-formed
			    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			      $emailErr = "Invalid email format";
			    }
			}

			// if there are no errors can proceed to insert
			if(empty($usernameErr) && empty($passwordErr) && empty($nameErr) && empty($surnameErr) && empty($phoneErr) && empty($emailErr)) {
				$query = mysqli_query($mysqli, "SELECT * FROM users WHERE username = '$username'");
				$checkExistingUsername = mysqli_fetch_array($query);
				if(!empty($checkExistingUsername)) {
					//display error message
					echo "<font color='red'>There is an existing username, choose a different username.</font><br/>";
				}
				else {
					//insert data to database	
					$result = mysqli_query(
						$mysqli,
						"INSERT INTO users(username,password,name,surname,phone,email,type)
						 VALUES('$username','$password','$name','$surname','$phone','$email','$type')"
					);
					//display success message
					echo "<font color='green'>Username $username added successfully.</font><br/>";

					//clear all save information
					$username = "";
					$password = "";
					$name = "";
					$surname = "";
					$phone = "";
					$email = "";
				}

				
			}
		}
	?>

	<a href="index.php">Back to Login Page</a>
	<br/><br/>

	<form action="register_borrower.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr> 
				<td>Username</td>
				<td>
					<input class='input_length' type="text" name="username" value="<?php echo $username;?>">
					<span class="error">* <?php echo $usernameErr;?></span>
				</td>
			</tr>
			<tr> 
				<td>Password</td>
				<td>
					<input class='input_length' type="text" name="password" value="<?php echo $password;?>">
					<span class="error">* <?php echo $passwordErr;?></span>
				</td>
			</tr>
			<tr> 
				<td>Name</td>
				<td>
					<input class='input_length' type="text" name="name" value="<?php echo $name;?>">
					<span class="error">* <?php echo $nameErr;?></span>
				</td>
			</tr>
			<tr> 
				<td>Surname</td>
				<td>
					<input class='input_length' type="text" name="surname" value="<?php echo $surname;?>">
					<span class="error">* <?php echo $surnameErr;?></span>
				</td>
			</tr>
			<tr> 
				<td>Phone</td>
				<td>
					<input class='input_length' type="text" name="phone" value="<?php echo $phone;?>">
					<span class="error">* <?php echo $phoneErr;?></span>
				</td>
			</tr>
			<tr> 
				<td>Email</td>
				<td>
					<input class='input_length' type="text" name="email" value="<?php echo $email;?>">
					<span class="error">* <?php echo $emailErr;?></span>
				</td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Submit" value="add"></td>
			</tr>
		</table>
	</form>

</body>
</html>
