<?php
/*
 * Configuration
 * 
 * A collection of configuration values
 */

final ROOT_DIR  = "../";
final SRC_DIR	= "../src/";
final CON_DIR	= "../config/";

/*
 * Database configuration 
 *
 * Credentials to access database
 */

final DB_HOST = "localhost";
final DB_USER = "root";
final DB_PASS = "123";
final DB_NAME = "test_db";

/*
 * Test environment configuration
 * 
 * File names of different files
 */

final CON_TEST_DIR	= CON_DIR . "test_env/";
final DB_TABLES 	= CON_TEST_DIR . "database_tables.txt";
final DB_POPULATE 	= CON_TEST_DIR . "database_populate.txt";
final USER_PASSWORDS	= CON_TEST_DIR . "user_passwords.txt";
?>
