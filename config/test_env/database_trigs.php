<?php
/* Database automation
 *
 * Purpose: Sets up a test database for use in development enviornments
 */ 
include('../defined_constants.php');

// Establishes a MySQL server connection or dies
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL, now exiting.\n" . mysqli_connect_error();
	exit();
}

// Creates test database
if(mysqli_query($connection, "CREATE DATABASE IF NOT EXISTS " . DB_NAME))
	echo "Database created successfully\n";
else{
	echo "Database created unsuccessfully, now exiting.\n" . mysqli_error($connection);
	exit();
}

// Selects the newly created database
mysqli_select_db($connection, DB_NAME);

// Creates tables for test database by reading database_tables.txt
// config file
$database_triggers = fopen(DB_TRIGGERS, "r");
$query = "";
while($file_line = fgets($database_triggers)){
  mysqli_query($connection,$file_line);
  echo $file_line;
}
fclose($database_triggers);

mysqli_close($connection)
?>
