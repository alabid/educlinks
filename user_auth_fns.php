<?php
function register($username, $password, $name, $email, $gender, $usertype, $school="") {
 	
	$conn = db_connect();
	
	$result = $conn->query("select * from user where username='$username'");
	

	if ($result->num_rows > 0)
	   throw new Exception("That username is already taken. Pls. pick a new one.");
	   
	 $query = "insert into user values ('$username', sha1('$password'), '$name', '$email', '$gender', '$usertype')";
	  
    
	$result = $conn->query($query);
	
	if (!$result)
	   throw new Exception("there seems to be a problem. Try again later.");
	
	if ($school){
	  $another_query = "insert into user_school values ('$username', '$school')";   
	 
	  $an_result = $conn->query($another_query);
	  
	  if (!$an_result)
	     throw new Exception("there seems to be a problem. Try again later.");
	}
	
   return true;
}

/**
this is a function to log in the user. Will return the user type or throw an exception to indicate a failed login.
*/
function login($username, $password) {
    	
	$conn = db_connect();
	
	$result = $conn->query("select * from user where username='$username' and passwd=sha1('$password')");
	
	if (!$result)
	  throw new Exception("You entered an incorrect username/password. Pls. verify that caps lock is turned off and try again.");
	  
	if ($result->num_rows > 0)
	{
	  $row = $result->fetch_object();
	  return $row->usertype;
	}
	else throw new Exception("You entered an incorrect username/password. Pls. verify that caps lock is turned off and try again.");
}

function change_password($username, $old_password, $new_password) {
	$usertype = login($username, $old_password);
	
	$conn = db_connect();
	$result = $conn->query("update user set passwd = sha1('$new_password') where username = '$username'");
	
	if (!$result)
	   throw new Exception("Password could not be changed.");
	else
	  return true; 
}

function reset_password($username) {
  	
	$new_password = get_random_word(6, 13);
	
	if (!$new_password)
	  throw new Exception("Could not generate new password");
	 
	srand((double) microtime() * 1000000);
	$rand_no = rand(0, 999);
	$new_password .= $rand_no;
	
	$conn = db_connect();
	$result = $conn->query("update user set passwd = sha1('$new_password') where username = '$username'");
	
	if (!$result)
	   throw new Exception("Could not change password.");
	else return $new_password; //if reached, then the password has been changed successfully
	
}

function get_random_word($min, $max) {
	$rand_word = "";
	
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	
	$dict = "$DOC_ROOT/../english.2";
	
	$fp = @fopen($dict, "rb");
	
	if (!$fp)
	   return false;
	$size = filesize($dict);
	
	//go to a random location in the dictionary
	srand(microtime() *1000000);
	$rand_location = rand(0, $size);
	fseek($fp, $rand_location);
	
	//get the next whole word of the right length in the file
	while (strlen($rand_word) < $min || strlen($rand_word) > $max || strstr($rand_word, "'")) {
	  if (feof($fp))
	    fseek($fp, 0);
	  $rand_word = fgets($fp, 80);
	  $rand_word = fgets($fp, 80); // the potential password	
	}
	
	$rand_word = trim($rand_word);
	return $rand_word;
}

function notify_password($username, $password) {
   $conn = db_connect();
   $result = $conn->query("select email from user where username = '$username'");
   
   if (!$result)
      throw new Exception("Could not find email address.");
	else if ($result->num_rows==0)
	  throw new Exception("Could not find email address");
	else {
		//here fetch and email the password to the email of the user
		$row = $result->fetch_object();
		$email = $row->email;
		$from = "From: support@educlinks.com \r\n";
		
		$message = "You requested a reset password operation \r\n";
		$message.= "Your password has been changed to $password \r\n";
		$message .= "Pls. when next you log into educlinks.com use the above password. \r\n";
		
		/**   mail($email, "educlinks login information", $message, $from);   
		  This should be what you would send when you have an SMTP server to use.
		**/
		
		$sent = true; // replace true with the mail function
		
		if ($sent)
		  return $message;//you should replace $message with true here.
		else 
		  throw new Exception("Could not send email to you.");
	}
		
	
}
?>