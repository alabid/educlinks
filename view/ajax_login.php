<?php
session_start();

include_once "educlinks_fns.php";

$username = $_POST["username"];
$password = $_POST["password"];

if ($username && $password) {
    try {
	   $usertype = login($username, $password);
	   
	   $_SESSION['username'] = $username;
	   $_SESSION['usertype'] = $usertype;
	   
	   echo "yes";
	   
    }catch (Exception $e){
         echo $e->getMessage();	
    }
}
else echo "Pls. enter a username and password";
?>