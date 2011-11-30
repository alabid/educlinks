<?php
include_once "class_home.php";
include_once "data_valid_fns.php";
include_once "user_auth_fns.php";
include_once "db_fns.php";

function get_pass_result() {
	
    $old_passwd = $_POST['old_passwd'];
    $new_passwd = $_POST['new_passwd'];
	$new_passwd2 = $_POST['new_passwd2'];
	
	try {
		if (!filled_out($_POST))
		  throw new Exception ("You have not filled the form correctly or totally. Pls. try again later.");
		  
		if (strcmp($new_passwd, $new_passwd2) != 0)
		  throw new Exception ("Passwords entered in the new password fields are not the same. Password NOT changed.");
	    if (strlen($new_passwd) < 8)
		   throw new Exception("New password must be at least 8 characters long. Try again.");
		  
		$user = $_SESSION["username"];  
		change_password($user, $old_passwd, $new_passwd);
		
		//if successful
		$pass_result = "<p class='good-mes'>Your password has been changed succesfully.</p>";
		$pass_result .= "<p class='good-mes'>Now you can access your account with your new password</p>";
		return $pass_result;
	}
	catch (Exception $e) {
		$pass_result = "<p class='bad-mes'>An error occured: ".$e->getMessage()."</p>";
		$pass_result .= "<a href='/change_pass_form.php'>Change Password</a>";
		return $pass_result;
	}
	
	
	if ($good)
	 $pass_result = "<p class='good-mes'>Your password has been changed succesfully.</p>";
	else 
	 display_the_error_message();
	 
	return $pass_result;
}

$change_pass_form = new Inpage();
$change_pass_form->content = get_pass_result();
$change_pass_form->display("Password Changed");
?>