<?php
/* 
 * Database class
 *
 * @db_connection : Database connection to our MySQL server
 * @status : Boolean. False if unable to connect, true otherwise
 * @error : Error object
 */
class Database{
	const DB_HOST = 'localhost';
	const DB_USER = 'root';
	const DB_PASS = '123';
	const DB_NAME = 'test_db';
	
	private $db_connection;
	private $status;
	private $error;

	public function __construct(){
		include('Error.php');
		$this->error = new Error();

		// Establishes database connection
		$this->db_connection = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
		if(mysqli_connect_error()){
			$this->error->write(mysqli_connect_error(), "database");
			$status = false;
		}else
			$status = true;
	}

	public function __destruct(){
		if($status)
			mysqli_close($db_connection);
	}
	
	/*
	 * Creates a new user within member table
	 *
	 * Returns true if user was created successfully
	 * Returns false if user was created unsuccessfully
	 */
	public function create_user($username, $password, $email, $current_time, $role = 'u', $status = 1, $avatarpath = ''){
		$db_query = "INSERT into member(username, password, role, status, email, joindate, lastlogin, avatarpath)
				values('$username', '$password', '$role', $status, '$email', '$current_time',
				'$current_time', '$avatarpath');"; 

		if(!mysqli_query($this->db_connection, $db_query)){
			$this->error->write(mysqli_error($this->db_connection), "database");
			return false;
		}
		return true;
	}

	/*
	 * Verify user has correct login credentials
	 * 
	 * Returns true if correct
	 * Returns false if incorrect
	 */
	public function verify_user($username, $password){
		include('lib/password_compat/lib/password.php');
		
		$user_information = $this->find_user($username, "username");

		return password_verify($password, $user_information['password']);
	}

	/*
	 * Find user with member table
	 * 
	 * @identifier : Either the value of a email or username
	 * @type : Specifies whether email or username
	 * 
	 * Returns an associative array of the user's characateristics OR
	 * Returns null if user is not found
	 */
	public function find_user($identifier, $type = "username"){
		if($type == "username")
			$identifier = "username = '$identifier';";
		else
			$identifier = "email = '$identifier';";

		$db_query = 	"SELECT memberid, username, password, role, status, email, 
				joindate, lastlogin, avatarpath from member where $identifier";
		
		$result = mysqli_query($this->db_connection, $db_query);

		// No user found with given information
		if(mysqli_num_rows($result) == 0)
			return null;
		return mysqli_fetch_assoc($result);
	}
	
	/*
         * Finds a User
         * 
         * @needle : String to be searched
         * @type : Either 'username' or 'email'
         * 
         * Returns true if user is found
         * Return flase if user is not found
         */
        function is_in_use($needle, $type){
                if($type != "username")
                        $type = "email";

                $db_query = "SELECT * FROM member WHERE " . $type . "='" . $needle . "';";

                $db_result = mysqli_query($this->db_connection, $db_query);

                if(mysqli_fetch_array($db_result) == NULL)
                        return false;

                return true;
        }
}
?>
