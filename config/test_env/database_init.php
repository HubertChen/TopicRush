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
$database_tables = fopen(DB_TABLES, "r");
$query = "";
while($file_line = fgets($database_tables)){
	if($file_line === "\n" || $file_line === "\r\n"){
		if(mysqli_query($connection, $query))
			echo "Table created successfully\n";
		else{
			echo "Table created unsucessfully, now exiting\n" . mysqli_error($connection);
			exit();	
		}
		$query = "";
	}else
		$query .= $file_line;
}
fclose($database_tables);

// Populates database with entries from database_populate.txt
$database_populate = fopen(DB_POPULATE, "r");
while($file_line = fgets($database_populate)){
	if($file_line === "\n" || $file_line === "\r\n")
		continue;
	else{
		if(mysqli_query($connection, $file_line))
			echo "Entry successful.\n";
		else{
			echo $file_line . "\n";
			echo "Entry unsuccessful, now exiting.\n" . mysqli_error($connection);
			exit();
		}
	}
}
fclose($database_populate);

mysqli_close($connection)
?>
