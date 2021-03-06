<?php

/**
*change configuration information here only
**/
$databaseHost = 'localhost';
$databaseName = 'takoko_library';
$databaseUsername = 'root';
$databasePassword = 'root';
/**
*change configuration information here only
**/

// 1. Connect to MySQL
$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// 2. If database is not exist create one
if (!mysqli_select_db($mysqli,$databaseName)){
    $sql = "CREATE DATABASE ".$databaseName;
    if ($mysqli->query($sql) === TRUE) {
        echo "Database initialised successfully";
    }
    else {
        echo "Error creating database: " . $mysqli->error;
    }
}

// 3. create tables if they don't exist
function initTableIfNotExist($conn,$table_name,$sql_filename) {
    if ( $conn->query("select 1 from $table_name limit 1;") ) {
        // my_table exists, no action required'
    }
    else {
        //table not exist, create tables
        $query = file_get_contents($sql_filename);
        $conn->multi_query($query);
    }

}


/**
*load all table name below
**/
//parameters to pass: ($conn,$table_name,$sql_filename)
initTableIfNotExist($mysqli,"users","database/users.sql");
initTableIfNotExist($mysqli,"resources","database/resources.sql");


?>

<!-- global settings -->
<?php
//define max cost
define("MAX_COST",1.00);


?>
