<?php
/* 
 * Error Class
 * 
 * Used to report errors and save them through logs
 */
class Error{
	const LOG_DATABASE = 'database.txt';
	const LOG_ERRORS = 'errors.txt';

	public function __construct(){
		date_default_timezone_set("America/New_York");
	}

	/*
	 * Records error to our log files
	 *
	 * @message : Error message
	 * @type : Type of error. Either "database" or "general"
	 */
	public function write($message, $type){
		$current_time = date('Y-m-d H:i:s', time());
		$message = "$current_time : \n\t $message\n\n";
	
		switch($type){
			case "database":
				error_log($message, '3', self::LOG_DATABASE);
				break;
			default:
				error_log($message, '3', self::LOG_ERRORS);
				break;
		}
	}
}
