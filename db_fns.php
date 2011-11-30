<?php
function db_connect () {
//be sure to change all of these when you really want to use it
$query = new mysqli("educlinks.db.7237366.hostedresource.com", "educlinks", "", "");

if (!$query)
  throw new Exception("Could not connect right now. Pls. try again later.");
 else return $query;
}
?>
