<?php
session_start();
//including the database connection file
include_once("../config.php");

//adding the user class
include '../classes/resources.php';

//css
define('CSS_PATH', '../css/'); //define bootstrap css path
$main_css = 'main.css'; // main css filename
$flex_css = 'flex.css'; // flex css filename

//define all file paths
define('INSERT_RESOURCE', 'insert_resource.php');
define('REGISTER_LIBRARIAN', 'register_librarian.php');
define('EDIT_USER', 'edit.php'); 
define('DELETE_USER', 'delete.php'); 
?>

<!-- data prep -->
<?php

$result = array();
$query = '';

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
    //5. generate the query
    $query = mysqli_query($mysqli,$sql_statement);

    /* uncomment to verify the sql statement */
    //echo $sql_statement;
}
else {
    //fetching data in descending order (lastest entry first)
    $query = mysqli_query($mysqli, "SELECT * FROM resources ORDER BY bookid DESC");

}

while($res = mysqli_fetch_array($query)){
      //while there is still data to query, continue query until no more result
      array_push($result, Resources::init($res));
}



?>



<html>
<head>  
  <title>Resourse List</title>
  <!-- main CSS-->
  <link rel="stylesheet" href='<?php echo (CSS_PATH . "$main_css"); ?>' type="text/css">
  <link rel="stylesheet" href='<?php echo (CSS_PATH . "$flex_css"); ?>' type="text/css">
</head>

<body>
  <h2>Resource List</h2>

  <div style='margin-bottom: 1em;'>
    <a href='../index.php'>Home</a>
    <a style='padding-left: 1em;' href='javascript:self.history.back();'>Go Back</a>
  </div>

  <section id='userlist-section' style="<?php echo(($_SESSION['type']) === 'LIBRARIAN' ? '' : 'display: none;') ?>">
    <a href="<?php echo (INSERT_RESOURCE) ?>"><button>Insert a new resource</button></a>
    <a href="<?php echo (REGISTER_LIBRARIAN) ?>"><button>Register a new Librarian</button></a>
    <br/><br/>

    
    <div id='searchrow' style='margin-bottom: 1em;'>
      <form action="#" method="get" name='search_form' class='removeCSS'>
        <span>Search By: </span>
        <input placeholder='isbn' name='isbn' value="<?php echo ($_GET['isbn']) ?>" >
        <input placeholder='title' name='title' value="<?php echo ($_GET['title']) ?>" >
        <input placeholder='author' name='author' value="<?php echo ($_GET['author']) ?>" >
        <input placeholder='status' name='status' value="<?php echo ($_GET['status']) ?>" >
        <button type='submit' name='search_query' value='search' >Search</button>
        <!-- type='submit' name='search_query' value='clear' -->
        
      </form>
      <span>
        <a href='resourcelist.php'><button  >Clear</button></a>
      </span>
    </div>

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
