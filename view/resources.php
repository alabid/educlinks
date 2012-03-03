<?php

include_once "class_home.php";
include_once "db_fns.php";
include_once "data_valid_fns.php";
include_once "user_auth_fns.php";

function add_resource($url) {
	$username = $_SESSION['username'];
	
	$conn = db_connect();
	$result = $conn->query("insert into resources values ('$username', '$url')");
	if (!$result)
	  throw new Exception("Your new bookmark/resource could not be added.");
	
	return true;
}

function del_resource($username, $url) {
   $conn = db_connect();
   $result = $conn->query("delete from resources where username = '$username' and resource = '$url'");	
	
   if (!$result)
     return false;
   else return true;
}

function get_user_urls($username) {
   $conn = db_connect();
   $result = $conn->query("select resource from resources where username = '$username'");
   if (!$result)
     return false;
	 
	//this is an array of this user's urls	
	$url_array = array();
	for ($i = 0; $i < $result->num_rows; $i++) {
	   $row = $result->fetch_row();
	   $url_array[$i] = $row[0];	
	}
	return $url_array;
}

function display_user_urls($url_array) {
	$count = 0; //counter for sleek CSS display
	$scriptname = $_SERVER['SCRIPT_NAME'];
	//starting to populate $display which should return the html that will be displayed on screen
	$display = "<form method='post' action='$scriptname'>\n";
    $display .= "<table>\n";
    $display .= "<tr>\n";
    $display .= "<th>Resource</th>\n";
    $display .= "<th>Delete?</th>\n";
    $display .= "</tr>\n";
	
	foreach ($url_array as $url) {
	    $display .= "<tr class='s".($count%2)."'>";
		$display .= "<td><a target='_blank' href='$url'>$url</a></td>";
		$display .= "<td><input type='checkbox' name='del_me[]' value='$url'/></td>";
		
		//close of <tr/>
		$display .= "<tr/>";
		$count++;	
	}
	
	$display .= "</table>\n";
    $display .= "<input type='submit' class='button' value='Delete'/>";
    $display .= "</form>";//closing of display
	
	return $display;
}

function get_add_resource() {


/** This sub-section is for adding new urls **/
$new_url = $_POST['new_url'];

$new_url = trim($new_url);

//instantiate variables that will hold the message that this main block will spit out
$error = "";
$good_mes = "";
$message = "";

if (!$new_url)
  $good_mes = "";

try {
  
  //check that the user entered the url correctly	  
  if (!strstr($new_url, "http://"))
     $new_url = "http://".$new_url;	

  //check that the url is valid
  if (!(@fopen($new_url, "r")))
     throw new Exception("The URL, $new_url is not valid.");
	 
   //now try to add the url
   add_resource($new_url);
   
   $good_mes .= "Success! Bookmark added";
  
}
catch (Exception $e){
	$error .= "An error occured: ".$e->getMessage();
}

if (strcmp($new_url, "http://") == 0 || !new_url)
  $error = "";
  $good_mes = "";
  /** end of sub-section for adding bookmarks **/

   
 /** This sub-section is for deleting urls **/
 
$del_me = $_POST['del_me'];
$username = $_SESSION['username'];



if (!$del_me)
   $error .= "";
else if (count($del_me) > 0){
  foreach($del_me as $url) {
	 $deleted = del_resource($username, $url);
	 if ($deleted)
	   $good_mes .= "Deleted ".htmlspecialchars($url)."<br/>";
	 else
	   $error .= "Could not delete ".htmlspecialchars($url)."<br/>";   
  }
} 
 
 /** end of sub-section for deleting urls  **/

  
  
/**     This section is to return the form for adding bookmarks(and the urls to display): BASICALLY FOR DISPLAY OF GOOD MESSAGES
* OR ERRORS
**/ 
if ($error || $good_mes)
   $message = ($error ? "<p class='mild-bad-mes'>".$error."</p>" : "<p class='good-mes'>".$good_mes."</p>");
else $message = "";

/** Beginning of subsection for display of urls. Now it's time to give the users what they have been waiting for: graphics and action and interesting stuff  **/

$scriptname = $_SERVER['SCRIPT_NAME'];

//this is to display the urls of the present user
$user = $_SESSION["username"];
$url_array = get_user_urls($user);
if  ($url_array)
   $url_display = display_user_urls($url_array);
else
   $url_display = "<p class='good-mes'>You have no bookmarks/resources saved here.</p>";
   
/** end of subsection for display of urls **/



$add_resource = <<<SOME
 <p class="good-mes">Store and Recommend your bookmarks/Resources here</p>
 
 <div id="user_urls">
    {$url_display}
	<br/>
	<br/>
	<br/>
 </div>	
 
 <div>{$message}</div>
   <div id="add_resource_form">
   <form method="post" action="{$scriptname}">
    <table>
      <tr>
       <td>New Bookmark/Resource: </td>
       <td><input type="text" name="new_url" value="http://"></td>
      </tr> 
    </table>
    <input type="submit" class="button" value="Add Resource/Bookmark"/>
   </form>
   <br/>
   <br/>
 </div>
SOME;
	
	return $add_resource."<br/>";
}

$add_resource = new Inpage();
$add_resource->content = get_add_resource(); 
$add_resource->display("Add resources and bookmarks here");

?>