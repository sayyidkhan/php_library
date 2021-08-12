<?php
session_start();
//including the database connection file
include_once("../config.php");

//adding the user class
include '../classes/user.php';


//define all file paths
define('REGISTER_BORROWER', 'register_borrower.php');
define('REGISTER_LIBRARIAN', 'register_librarian.php');
define('EDIT_USER', 'edit.php'); 
define('DELETE_USER', 'delete.php'); 
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

  <div style='margin-bottom: 1em;'>
    <a href='../index.php'>Home</a>
    <a style='padding-left: 1em;' href='javascript:self.history.back();'>Go Back</a>
  </div>

  <section id='userlist-section' style="<?php echo(($_SESSION['type']) === 'LIBRARIAN' ? '' : 'display: none;') ?>">
    <a href="<?php echo (REGISTER_BORROWER) ?>"><button>Register a new borrower</button></a>
    <a href="<?php echo (REGISTER_LIBRARIAN) ?>"><button>Register a new Librarian</button></a>
    <br/><br/>

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
    $edit_url = EDIT_USER;
    $delete_url = DELETE_USER;

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
          <a href=\"$edit_url?id=$userID\">Edit</a> |
          <a href=\"$delete_url?id=$userID\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a>
         </td>
         ";   
      $counter += 1;
    }
    ?>
    </table>
  </section>

  <section id="noaccess-section" style="<?php echo(($_SESSION['type']) === 'LIBRARIAN' ? 'display: none;' : '') ?>">
    <p>you have no access to this section of the page.</p>
  </section>

</body>
</html>
