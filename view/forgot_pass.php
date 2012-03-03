<?php
include_once "educlinks_fns.php";//normal include file at the top

get_header("Welcome to edulinks.com >> Reset Your Password");
get_init_content();
?>

<?php
 $user = $_POST["user_for_pass"];
 try {
 $user = trim($user);

 if (!$user)
      throw new Exception("You did not enter anything into the field required.");
	 
$password = reset_password($user);
 $message = notify_password($user, $password);

echo do_good_mes("A new password has been sent to the email of <b>".$user."</b>.");

echo "This was the message that was sent: ".$message; //remove this message for real ok!!
//don't forget to remove this. This is a very great security risk. So be careful.	 

} catch (Exception $e) {
   get_getpassform();
   do_bad_mes($e->getMessage());	
}
 
?>

<?php
get_close_content();
get_footer();

?>