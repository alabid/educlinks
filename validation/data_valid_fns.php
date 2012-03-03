<?php

function is_email_valid($email) {
 $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/i";

 if (preg_match($regexp, $email)) 
    return true;
else return false;
}


function filled_out($array) {
  foreach ($array as $key => $value) {
	  if (!isset($key) || $value == "")
	     return false;
  }
  return true;
}
?>