<?php
session_start();
//including the database connection file
include_once("../config.php");

//adding the user class
include '../classes/resources.php';


//define all file paths
define('REGISTER_BORROWER', 'register_borrower.php');
define('REGISTER_LIBRARIAN', 'register_librarian.php');
define('EDIT_USER', 'edit.php'); 
define('DELETE_USER', 'delete.php'); 
?>

<!-- data prep -->
<?php

//fetching data in descending order (lastest entry first)
$query = mysqli_query($mysqli, "SELECT * FROM resources ORDER BY bookid DESC");
$result = array();
while($res = mysqli_fetch_array($query)){
  //while there is still data to query, continue query until no more result
  array_push($result, Resources::init($res));
}

?>

<html>
<head>  
  <title>Resourse List</title>
</head>

<body>
  <h2>Resource List</h2>

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
      <td>Book No</td>
      <td>ISBN</td>
      <td>Title</td>
      <td>Author</td>
      <td>Publisher</td>
      <td>Status</td>
      <td>R - Cost</td>
      <td>E - Cost</td>
      <td>Options</td>
    </tr>
    <?php
    $edit_url = EDIT_USER;
    $delete_url = DELETE_USER;

    $counter = 1;
    foreach($result as $resource) {
      $bookID = $resource->bookid;

      echo "<tr>";
      echo "<td>".$counter."</td>";
      echo "<td>".$resource->bookno."</td>";
      echo "<td>".$resource->isbn."</td>";
      echo "<td>".$resource->title."</td>";
      echo "<td>".$resource->author."</td>";
      echo "<td>".$resource->publisher."</td>";
      echo "<td>".$resource->status."</td>";
      echo "<td>".$resource->rcost."</td>";
      echo "<td>".$resource->ecost."</td>";    
      echo "<td>
              <a href=\"$edit_url?id=$bookID\">Edit</a> |
              <a href=\"$delete_url?id=$bookID\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a>
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
