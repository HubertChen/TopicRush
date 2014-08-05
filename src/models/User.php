<?php
/* 
 * User class
 *
 * @role : 'u' for standard user; 'a' for admin
 * @status : 0 for inactive; 1 for active
 *
 */
class User{
	private $id;
	private $username;
	private $password;
	private $role;
	private $email;
	private $join_date;

	private $database;

	function __construct(){
		include('Database.php');

		$this->database = new Database();
	}
	
	/*
	 * Creates a new user 
	 *
	 * @username 	: Username chosen by user
	 * @password1 	: Login password
	 * @password2 	: Confirmation passowrd
	 * @email 	: User's e-mail address
	 *
 	 * Return	: String indicating whether user has been successfully created
	 * 	+ Returns a String of possible errors to make it easy to display to login screen
	 * 	+ Login.php searches for a '!' to indicate success. Do NOT use '!' on any error messages
	 */
	public static function create($username, $password1, $password2, $email){
		include('/vagrant/src/lib/password.php');
		include('Database.php');

		$database = new Database();

		// Removes potential dangerouse user input
		$username	= self::format_input($username);
		$password1 	= self::format_input($password1);
		$password2 	= self::format_input($password2);
		$email 		= self::format_input($email);
                $adult          = self::format_input($adult);

		// Validates the user values inputted in form
		$error = "";
        	$error .= self::validate_user($username, $database);
        	$error .= self::validate_password($password1, $password2);
        	$error .= self::validate_email($email, $database);

		if($error != "")
			return $error;

                date_default_timezone_set("America/New_York");
                $current_time = date('Y-m-d h:i:s', time());
		echo "!";
                $password = password_hash($password1, PASSWORD_BCRYPT);
		echo "@";
		
		$create_user_query = 
			"INSERT into member(username, password, email, role, joindate) values
			('$username', '$password', '$email', 'u', '$current_time');";

		if($database->insert($create_user_query))
			return "User created successfully!";
		else
			return "User not created successfully.";
	}

	/*
	 * Finds user with given $username
	 * 
	 * Returns NULL if user with given $username is not found
	 * Returns instance of object if found
	 */
	public static function with_username($username){
		$instance = new self();

		// Calls function to load instance variables
		if(!$instance->load($username, "username"))
			return null;	

		return $instance;
	}

	/*
	 * Finds user with give $email
	 * 
	 * Returns NULL if user with given $email is not found
	 * Returns instance of object if found
	 */
	public static function with_email($email){
		$instance = new self();
		
		//Calls function to load instance variables
		if(!$instance->load($email, "email"))
			return null;

		return $instance;
	}

	public static function find_id($username){
		include("Database.php");
		$database = new Database();	
			
		$result_array = $database->query("Select memberid from member where username='$username';");
		var_dump($result_array);
		return $result_array[0]['memberid'];
	}

	/* 
	 * Loads instance variables for given user
	 *
	 * @identifier : Contains either a username or email
	 * @type : Two possible values, either "username" or "email"
	 * 
	 * Returns false if user with given $username is not found
	 * Returns true if found
	 */
	private function load($identifier, $type = "username"){
		if($type == "username")
			$user_info = $this->database->find_user($identifier, "username");
		else
			$user_info = $this->database->find_user($identifier, "email");

		if($user_info == false)
			return false;

		$this->id 		= $user_info['memberid'];
		$this->username 	= $user_info['identifier'];
		$this->password 	= $user_info['password'];
		$this->role 		= $user_info['role'];
		$this->email 		= $user_info['email'];
		$this->join_date 	= $user_info['joindate'];
		
		return true;
	}

	/*
	 * Gets the articles that the user is subscribed to
	 * 
	 * Returns an associative array
	 */
	public function get_subscriptions(){
		return($this->database->query(
				"select article.name as articlename, category.name as categoryname,
				article.articleid as articleid
				from article 
				inner join followarticle on followarticle.articleid = article.articleid and followarticle.memberid =" . $this->id ."
				inner join category on category.categoryid = article.categoryid;"));
	}

	/*
	 * Gets the categories of the article the user is subscribed to
	 *
	 * Returns an associative array
	 */
	public function get_categories(){
		return($this->database->query(
				"select category.name as categoryname, category.categoryid as categoryid from article 
                                inner join followarticle on followarticle.articleid = article.articleid and followarticle.memberid =" . $this->id ."
                                inner join category on category.categoryid = article.categoryid group by categoryname order by categoryname;"));
	}

	/* 
	 * Gets the articles that the user is subscribed to
	 * 
	 * Returns an associate array
	 */
	public function get_articles(){
		return($this->database->query(
				"select article.name as articlename, category.name as categoryname, article.articleid as articleid from article 
                                inner join followarticle on followarticle.articleid = article.articleid and followarticle.memberid =" . $this->id ."
                                inner join category on category.categoryid = article.categoryid group by articlename order by articlename;"));
	}

	/*
         * Validates the email that the user inputted from HTML form
         * 
         * Returns a String of errors or "" if there are no errors
         */

        public static function validate_email($email, $database){
                $error = "";

                if(strlen($email) == 0)
                        $error .= "Please enter an email.<br>";
                if($database->is_in_use($email, "email"))
                        $error .= "Email is already in use.<br>";

                return $error;
        }

        /*
         * Validates the username that the user inputted from HTML form
         * 
         * Returns a String of errors or "" if there are no errors
         */

        public static function validate_user($username, $database){
                $error = "";

                if(strlen($username) == 0)
                        $error .= "Please enter a username.<br>";
                if(preg_match("/^[a-zA-Z0-9]+$/", $username) != 1)
                        $error .= "Please only use letters and numbers.<br>";
                if($database->is_in_use($username, "username"))
                        $error .= "Username is already in use.<br>";

                return $error;
        }

	/*
         * Validates the passwords that the user inputted from HTML form
         * 
         * Returns a String of errors or "" if there are no errors
         */

        public static function validate_password($password1, $password2){
                $error = "";

                if(strlen($password1) == 0)
                        $error .= "Please enter a password.<br>";
                if(strlen($password2) == 0)
                        $error .= "Please confirm your password.<br>";
                if($password1 !== $password2)
                        $error .= "Passwords did not match. Please re-enter.<br>";

                return $error;
        }

        /*
         * Removes potentially dangerous input from users
         * 
         * Returns the formmated input
         */
        public static function format_input($input){
                return htmlSpecialChars(stripSlashes(trim($input)));
        }
}
?>
