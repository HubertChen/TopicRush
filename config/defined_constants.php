<?php
/*
 * Configuration
 * 
 * A collection of configuration values
 */

define('ROOT_DIR', 	"/vagrant/");
define('SRC_DIR', 	ROOT_DIR . "src/");
define('MODEL_DIR',	SRC_DIR . "models/");
define('CON_DIR',	ROOT_DIR . "config/");
define('CON_TEST_DIR',	CON_DIR . "test_env/");
define('LOG_DIR',	ROOT_DIR . "logs/");
define('SRC_LIB_DIR',	SRC_DIR . "lib/");

/*
 * Database configuration 
 *
 * Credentials to access database
 */

define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASS', "123");
define('DB_NAME', "test_db");

/*
 * Model classes/files
 */
define('MODEL_ERROR', 	MODEL_DIR . "Error.php");
define('MODEL_DB',	MODEL_DIR . "Database.php");
define('MODEL_USER', 	MODEL_DIR . "User.php");


/*
 * Test environment configuration
 * 
 * File names of different files
 */

define('DB_TABLES', 		CON_TEST_DIR . "database_tables.txt");
define('DB_POPULATE', 		CON_TEST_DIR . "database_populate.txt");
define('USER_PASSWORDS',	CON_TEST_DIR . "user_passwords.txt");

/*
 * Logs Directory
 *
 * File names of different files
 */
define('LOG_ERRORS',		LOG_DIR . "errors.txt");
define('LOG_DATABASE',		LOG_DIR . "database.txt");
define('LOG_USER_LOGIN', 	LOG_DIR . "user_login.txt");
define('LOG_USER_LOGOUT',	LOG_DIR . "user_logout.txt");
define('LOG_USER_REGISTRATION', LOG_DIR . "user_registration.txt");

/* 
 * External Libraries
 * 
 * Absolute paths for the different libraries
 */
define('SRC_LIB_PASSWORD', SRC_LIB_DIR . "password_compat/lib/password.php");
?>
