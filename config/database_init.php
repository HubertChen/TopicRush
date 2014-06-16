<?php
/* Database automation
 *
 * Purpose: Sets up a test database for use in development enviornments
 */ 

// Establishes a MySQL server connection or dies
$connection = mysqli_connect("localhost", "root", "123");
if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL, now exiting.\n" . mysqli_connect_error();
	exit();
}

// Creates test database
if(mysqli_query($connection, "CREATE DATABASE IF NOT EXISTS test_db"))
	echo "Database created successfully\n";
else{
	echo "Database created unsuccessfully, now exiting.\n" . mysqli_error($connection);
	exit();
}

// Selects the newly created database
mysqli_select_db($connection, "test_db");

// Creates tables for test database by reading database_tables.txt
// config file
$database_tables = fopen("database_tables.txt", "r");
$query = "";
while($file_line = fgets($database_tables)){
	if($file_line === "\n"){
		if(mysqli_query($connection, $query))
			echo "Table created successfully\n";
		else{
			echo "\n\n\n" . $query . "\n\n\n";
			echo "Table created unsucessfully, now exiting\n" . mysqli_error($connection);
			exit();	
		}
		$query = "";
	}else
		$query .= $file_line;
}

mysqli_close($connection)
?>
