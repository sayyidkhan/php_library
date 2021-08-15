<?php
session_start();
//including the database connection file
include_once("../../config.php");

//adding the resource class
include '../../classes/resources.php';

//css
define('CSS_PATH', '../../css/'); //define bootstrap css path
$main_css = 'main.css'; // main css filename
$flex_css = 'flex.css'; // flex css filename

//define all file paths
define('ADD_RESOURCE', 'add.php');
define('REGISTER_LIBRARIAN', 'register_librarian.php');
define('EDIT_USER', 'edit.php'); 
define('DELETE_USER', 'delete.php');

//USER ACCESS
define('USER_ACCESS', 'LIBRARIAN');

//define current filename
define('CURRENT_FILENAME', 'resourcelist.php'); //filename of this file
?>

<!-- manage global variables -->
<?php

  function setCurrentSection() {
      //if current page is not set, update current_section to default_resource for page init
      if(!isset($_GET['current_section'])) {
          $default_resource = 'ALL';
          header("Location: " . CURRENT_FILENAME . "?current_section=$default_resource");
      }
      else {
          //set the current session into the global variable
          $GLOBALS['current_section'] = $_GET['current_section'];
      }

  }

  //set the current section
  setCurrentSection();
  $current_section = $GLOBALS['current_section'];

?>

<!-- load resourses data -->
<?php



$result = array();
$query = '';

function getCurrentSection($type_of_query) {
  $current_section = $GLOBALS['current_section'];
  $additional_query = '';
  //for multiple filters
  if($type_of_query === 'MULTIPLE_FILTER') {
      $additional_query = ' AND status = ';
  }
  //for single filter only
  else if($type_of_query === 'SINGLE_FILTER') {
      $additional_query = ' WHERE status = ';
  }

  
  if($current_section === 'ALL') {
      $additional_query = '';
  }
  else if($current_section === 'AVAILABLE') {
      $additional_query .= "'AVAILABLE'";
  }
  else if($current_section === 'BORROWED') {
      $additional_query .= "'BORROWED'";
  }
  else if($current_section === 'EXTENDED') {
      $additional_query .= "'EXTENDED'";
  }
  return $additional_query;     
}

// logic for search query
if(!empty($_GET['isbn']) || !empty($_GET['title']) || !empty($_GET['author']) || !empty($_GET['status'])) {
    $sql_statement = "SELECT * FROM resources WHERE ";

    //1. put all the getters in the array
    $filter_array = array(
        'isbn' => $_GET['isbn'],
        'title' => $_GET['title'],
        'author' => $_GET['author'],
        'status' => $_GET['status'],
    );
    //2. init a query array
    $query_array = array();
    //3. loop through the array, if value is not null, add it to the query array
    foreach ($filter_array as $key => $value) {
        if ($value != '') {
          //match using like clause
          $query_array[] = $key .' LIKE ' . "'" . "%" . $value . "%" . "'";
        }
    }
    //4. join all the statement with the AND statement
    $sql_statement = 'SELECT * FROM resources WHERE ' . implode(' AND ', $query_array);
    //5. depending on the current_section, it will filter based on the availability of the books
    $sql_statement .= getCurrentSection('MULTIPLE_FILTER');
    //6. add sort by desc
    $sql_statement .= " ORDER BY bookid DESC";
    //7. generate the query
    $query = mysqli_query($mysqli,$sql_statement);

}
else {
    //1. fetching data in descending order (lastest entry first)
    $sql_statement = "SELECT * FROM resources ";
    //2. depending on the current_section, it will filter based on the availability of the books
    $sql_statement .= getCurrentSection('SINGLE_FILTER');
    //3. add sort by desc
    $sql_statement .= " ORDER BY bookid DESC";
    $query = mysqli_query($mysqli, $sql_statement);

}

/* uncomment to verify the sql statement */
echo $sql_statement;

while($res = mysqli_fetch_array($query)){
      //while there is still data to query, continue query until no more result
      array_push($result, Resources::init($res));
}



?>



<html>
<head>  
  <title>View All Resourse List</title>
  <!-- main CSS-->
  <link rel="stylesheet" href='<?php echo (CSS_PATH . "$main_css"); ?>' type="text/css">
  <link rel="stylesheet" href='<?php echo (CSS_PATH . "$flex_css"); ?>' type="text/css">
</head>

<body>
  <h2>View All Resource List</h2>

  <div style='margin-bottom: 1em;'>
    <a href='../../index.php'>Home</a>
    <a style='padding-left: 1em;' href='javascript:self.history.back();'>Go Back</a>
  </div>

  <section id='userlist-section' style="<?php echo(($_SESSION['type']) === USER_ACCESS ? '' : 'display: none;') ?>">
    
    <div style="margin-bottom: 1em;">
      <span>Page Navigation:&nbsp;&nbsp;&nbsp;</span>
      <a href="<?php echo (ADD_RESOURCE) ?>"><button>Add a new resource</button></a>
    </div>
    
    <div id='searchrow' style='margin-bottom: 1em;'>
      <form action="#" method="get" name='search_form' class='removeCSS'>
        <span>List By:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <button
        <?php echo ($GLOBALS['current_section'] == 'ALL') ? 'disabled="true" style="background-color: lightblue;pointer-events: none;color: grey;" ' : ''; ?> 
        name='current_section' value='ALL' type='submit' >View All Resources</button>
        <button
        <?php echo ($GLOBALS['current_section'] == 'AVAILABLE') ? 'disabled="true" style="background-color: lightblue;pointer-events: none;color: grey;" ' : ''; ?> 
        name='current_section' value='AVAILABLE' type='submit' >View Available Resources</button>
        <button 
        <?php echo ($GLOBALS['current_section'] == 'BORROWED') ? 'disabled="true" style="background-color: lightblue;pointer-events: none;color: grey;" ' : ''; ?> 
        name='current_section' value='BORROWED' type='submit' >View Borrowed Resources</button>
        <button 
        <?php echo ($GLOBALS['current_section'] == 'EXTENDED') ? 'disabled="true" style="background-color: lightblue;pointer-events: none;color: grey;" ' : ''; ?> 
        name='current_section' value='EXTENDED' type='submit' >View Extended Resources</button>
        <br><br>
        <span>Search By: </span>
        <input placeholder='isbn' name='isbn' value="<?php echo ($_GET['isbn']) ?>" >
        <input placeholder='title' name='title' value="<?php echo ($_GET['title']) ?>" >
        <input placeholder='author' name='author' value="<?php echo ($_GET['author']) ?>" >
        <input placeholder='status' name='status' value="<?php echo ($_GET['status']) ?>" >
        <button type='submit' name='current_section' value="<?php echo ($_GET['current_section']) ?>" >Search</button>
      </form>
      <span>
        <a href='resourcelist.php'><button>Clear</button></a>
      </span>
    </div>

    <table width='80%' border=0>

    <tr bgcolor='#CCCCCC'>
      <td>No</td>
      <td>Book ID</td>
      <td>Book No</td>
      <td>ISBN</td>
      <td>Title</td>
      <td>Author</td>
      <td>Publisher</td>
      <td>Type</td>
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
      echo "<td>".$bookID."</td>";
      echo "<td>".$resource->bookno."</td>";
      echo "<td>".$resource->isbn."</td>";
      echo "<td>".$resource->title."</td>";
      echo "<td>".$resource->author."</td>";
      echo "<td>".$resource->publisher."</td>";
      echo "<td>".$resource->type."</td>";
      echo "<td>".$resource->status."</td>";
      echo "<td>".$resource->rcost."</td>";
      echo "<td>".$resource->ecost."</td>";    
      echo "<td>
              <a href=\"$edit_url?bookid=$bookID\">Update Status</a> |
              <a href=\"$delete_url?bookid=$bookID\" onClick=\"return confirm('Are you sure you want to delete book ID: $bookID ?')\">Delete</a>
            </td>
           ";   
      $counter += 1;
    }
    ?>
    </table>
  </section>

  <section id="noaccess-section" style="<?php echo(($_SESSION['type']) === USER_ACCESS ? 'display: none;' : '') ?>">
    <p>you have no access to this section of the page.</p>
  </section>

</body>
</html>
