<?php
  session_start();
  
  include "educlinks_fns.php";
  
  require_once('recaptchalib.php');
  $privatekey = "6Lf0u78SAAAAADWP65i3bOIPTJxBvJkYc9z1XpcG";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

   if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("<p class='bad-mes'>The reCAPTCHA wasn't entered correctly. Go back and try it again. It said: ".$resp->error."</p>");
  } else {
    // Your code here to handle a successful verification
	$username = $_POST["username"];
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$password = $_POST["password"];
	$confirm_password = $_POST["confirm_password"];
	$email = $_POST["email"];
	$agree = $_POST["agree"];
	$school = $_POST["school"];
	$usertype = $_POST["usertype"];
	$gender = $_POST["gender"];
	
	$name = $firstname." ".$lastname;
	try {
		
		if (strcmp($agree, "false") == 0) throw new Exception("You haved not agreed to the Privacy Policy and terms of use!!");
		
		
		if (!is_email_valid($email))
		   throw new Exception("The email you just entered is not valid!!");
		   
		 if (!($firstname && $lastname))
		    throw new Exception("You did not enter your name properly!");
			
		if (strcmp($password, $confirm_password)!=0)
		    throw new Exception("The passwords you entered are not the same!");
			
		if (strlen($username) > 20 || strlen($username) < 6)
		   throw new Exception("Pls. enter a username of length between the required range(5-16)");
		 if ($usertype == "none" || $gender == "none")
		    throw new Exception("You did not fill out gender or usertype correctly!!");
			if (strlen($password) < 8 )
			  throw new Exception("Your password is too short. Revise pls.");
			 
			if ($school) 
			    register($username, $password, $name, $email, $gender, $usertype, $school);
			else register($username, $password, $name, $email, $gender, $usertype);
			
			$_SESSION['username'] = $username;
			$_SESSION['usertype'] = $usertype;
			
			$result = "yes";
			echo $result;
			
	}catch (Exception $e) {
		echo "<p class='bad-mes'>You did something(s) wrong: ".$e->getMessage()."</p>";
		
	}
  }
  ?>
