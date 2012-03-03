<?php
include_once "class_home.php";
include_once "db_fns.php";

function create_group($username, $group_name, $group_func) {
   $conn = db_connect();
   $result = $conn->query("select * from groups where groupname = '$group_name'");	
   if (!$result)
     throw new Exception("There seems to be a problem. Try again later.");
   
   if ($result->num_rows > 0)
     throw new Exception("That groupname is already taken! Try another one.");
   else {
	 $another_result = $conn->query("insert into groups values ('$group_name', '$username', '$group_func')"); 
	 $yet_another = $conn->query("insert into user_and_group values ('$group_name', '$username')");  
	 if (!($another_result || $yet_another))
	   throw new Exception("There seems to be something wrong. Try again later.");
	 else
	   return true;
	 
  }

}

function get_create_display() {
	
	$error = "";
    $good_mes = "";
    $message = "";
	
	/**  This will retrieve all the posted information use or put it somewhere  **/
	
	$username = $_SESSION['username'];
	$group_name = $_POST['group_name'];
	$group_func = $_POST['group_func'];
	
	//check $group_name and $group_func
	if (!($group_name || $group_func))
	   $message = "";
	else{ 
	   if (!($group_name && $group_func))
	    $message = "You did not enter a groupname or/and a the group's function";
		
	   else if (strlen($group_name) > 200 || strlen($group_name) < 4 )
	  $error = "Groupname shouldn't be more than 200 characters or less than 4 characters. Try again.";
	}
	
	
	  
	try {
	if ($group_name && $group_func)
	   $create_group = create_group($username, $group_name, $group_func);
	
	if ($create_group)
	  $good_mes .= "The Group <strong>".$group_name."</strong> has been created by You!";
	  
	} catch (Exception $e) {
	  $error .= $e->getMessage();	
	}
	
	
	/** This will end the retrieval of info.  **/
	
	/**     This section is to return the form for adding bookmarks(and the urls to display): BASICALLY FOR DISPLAY OF GOOD MESSAGES
* OR ERRORS
**/ 
if ($error || $good_mes)
   $message = ($error ? "<p class='mild-bad-mes'>".$error."</p>" : "<p class='good-mes'>".$good_mes."</p>");
else $message = "";

/** Now it's time to give the users what they have been waiting for: graphics and action and interesting stuff  **/

$scriptname = $_SERVER['SCRIPT_NAME'];
	
$create_display = <<<SOME
  <div id="create_group">
  <p class="good-mes">Create a Group here!</p>
  <p>To create a group, choose a unique name for the group name. If the group name is already taken, then you  will be alerted to choose another name. Else a success message will be displayed to you and the group will be registered in the database.<p>
  <br/>
  <br/>
  <form method="post" action="{$scriptname}">
    <table>
      <tr>
        <td><label>Groupname:</label> </td>
        <td><input name="group_name" type="text" /></td>
      </tr>
     
      <tr>
        <td><label>Group Function:</label> </td>
        <td><input name="group_func" type="text" /></td>
      </tr>
    </table>
    <input type="submit" class="button" value="Create Group"/>
  </form>
  <br/>
  <br/>
  <div id="message" name="message">
    {$message}
  </div>
</div>
<br/>
  <br/>
  <br/>
SOME;
	
  return $create_display;	
}

$create_group = new Inpage();
$create_group->content = get_create_display();
$create_group->display("Create a new Group");

?>