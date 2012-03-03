<?php
include_once "class_home.php";
include_once "db_fns.php";

$usertypes = array(
	  "prospie" => "Prospective Student",
	  "student" => "College Student",
	  "alumni" => "Alumni",
	  "advisor" => "Advisor"
	);


function invite($invitee, $invite_to, $username) {
   if (!($invite_to && $invitee))	
    throw new Exception ("You did not fill the invitation fields correctly.");
   else{
	   $conn = db_connect();
	   $first_of_all = $conn->query("select * from user where name='$invitee'");
	   if ($first_of_all->num_rows == 0)
	     throw new Exception("The user you want to invite does not exist. Make sure that you entered the correct name of the user.");
	   else {
		   $row = $first_of_all->fetch_object();
	     $invitee_username = $row->username;
	  }
	   
	   $result = $conn->query("insert into invitations values ('$username', '$invitee', '$invite_to')");
	   
	   if (!$result)
	     throw new Exception ("There seems to be a problem!! Try again later.");
   }	
}


function make_dropdown_groups($username) {
	$conn = db_connect();
	
	$dropdown = "";
	
	$result = $conn->query("select * from user_and_group where username = '$username'");
	$dropdown .= "<select name='invite_to'>";
for ($i=0; $i < $result->num_rows; $i++) {
	$row = $result->fetch_object();
	
	$groupname = $row->groupname;
	$dropdown .= "<option value='$groupname'>".$groupname."</option>";
}
$dropdown .= "</select>";
return $dropdown;
}



function add_group($username, $group) {
	
	 $conn = db_connect();
   $result = $conn->query("insert into user_and_group values ('$group', '$username')");	
	
   if (!$result)
     return false;
   else return true;

}


function del_group($username, $group) {
   $conn = db_connect();
   $result = $conn->query("delete from user_and_group where username = '$username' and groupname = '$group'");	
	
   if (!$result)
     return false;
   else return true;

}

function trim_function($group_function) {
   if (!(count(explode(" ", $group_function)) > 20))
     	return $group_function;
   else{
      $pieces = explode(" ", $group_function);
	  
	  $words_joined = implode(" ", array_slice($pieces, 0, 20));
	  
	  return $words_joined."..."; 
   }
}


function get_invite_form($username) {
	
  $scriptname = $_SERVER['SCRIPT_NAME'];
	
  $html = "<div id='invite'>";
  $html .= "<form action='$scriptname' method='post'><table>";	
  $html .= "<tr>";
  $html .= "<td><span>To (Group):</span></td>";
  $html .= "<td>";
  $html .= make_dropdown_groups($username);
  $html .= "</td></tr>";
  $html .= "<tr><td><span>User's Name:</span></td>";
  $html .= "<td><input name='invitee' type='text'/></td></tr>";
  $html .= "</table><input type='submit' value='Invite'/>";
  $html .= "</form>";
  
   $html .= "</div>"; 
	
   return $html;
}

function get_recommendations($username) {
   	
	$scriptname = $_SERVER['SCRIPT_NAME'];
	
	global $usertypes;
	
	$html .= "<form method='post' action='$scriptname'>";
	$html .= "<table>";
	$html .= "<tr><th>Group</th><th>Created By</th><th>Function</th><th>Delete?</th></tr>";
     
	$conn = db_connect();


	$result = $conn->query("select * from groups ORDER BY Rand() LIMIT 2");
	if (!$result)
	  throw new Exception("An error occured.");
    if ($result->num_rows == 0)
	  throw new Exception("You have no groups yet.");
	  
	for ($i=0; $i < $result->num_rows; $i++) {
		$row = $result->fetch_object();
		$group_name = $row->groupname;
		
		$another_result = $conn->query("select * from groups where groupname='$group_name'");
		$row_2 = $another_result->fetch_object();
		$group_creator = $row_2->creator;
		$group_function = $row_2->group_function;
		
		$yet_another = $conn->query("select * from user where username='$group_creator'");
		$row_3 = $yet_another->fetch_object();
		$creator_name= $row_3->name;
		$creator_usertype = $usertypes[$row_3->usertype];
		
		$html .= "<tr>";
		
        $html .= "<td>"."<img src='show_image.php?name={$group_name}' alt='this is an image'/><span class='group_name'>".$group_name."</span>"."</td>";
		
		$html .= "<td>"."<img src='show_image.php?name={$group_creator}' alt='this is an image'/><p><strong>Name: </strong>".$creator_name."</p>"."<p>"."<strong>Usertype: </strong>".$creator_usertype."</p>"."</td>";
		
		$html .= "<td>".(trim_function($row_2->group_function))."</td>";
		
		$html .= "<td><input name='add_me[]' type='checkbox' value='$group_name'/></td>";
		
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	$html .= "<input class='button' type='submit' value='Add Group(s)'/>";
  	$html .= "</form>";
	
	if (!($result  && $yet_another))
	  throw new Exception("Something went wrong!!");
	  
	return $html;
}


function table_groups_display($username) {
	$scriptname = $_SERVER['SCRIPT_NAME'];
	
	global $usertypes;
	
	$html .= "<form method='post' action='$scriptname'>";
	$html .= "<table>";
	$html .= "<tr><th>Group</th><th>Created By</th><th>Function</th><th>Delete?</th></tr>";
     
	$conn = db_connect();
	
	$result = $conn->query("select * from user_and_group where username = '$username'");
	if (!$result)
	  throw new Exception("An error occured.");
    if ($result->num_rows == 0)
	  throw new Exception("You have no groups yet.");
	  
	for ($i=0; $i < $result->num_rows; $i++) {
		$row = $result->fetch_object();
		$group_name = $row->groupname;
		
		$another_result = $conn->query("select * from groups where groupname='$group_name'");
		$row_2 = $another_result->fetch_object();
		$group_creator = $row_2->creator;
		$group_function = $row_2->group_function;
		
		$yet_another = $conn->query("select * from user where username='$group_creator'");
		$row_3 = $yet_another->fetch_object();
		$creator_name= $row_3->name;
		$creator_usertype = $usertypes[$row_3->usertype];
		
		$html .= "<tr>";
		
        $html .= "<td>"."<img src='show_image.php?name={$group_name}' alt='this is an image'/><span class='group_name'>".$group_name."</span>"."</td>";
		
		$html .= "<td>"."<img src='show_image.php?name={$group_creator}' alt='this is an image'/><p><strong>Name: </strong>".$creator_name."</p>"."<p>"."<strong>Usertype: </strong>".$creator_usertype."</p>"."</td>";
		
		$html .= "<td>".(trim_function($row_2->group_function))."</td>";
		
		$html .= "<td><input name='del_me[]' type='checkbox' value='$group_name'/></td>";
		
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	$html .= "<input class='button' type='submit' value='Delete Group'/>";
  	$html .= "</form>";
	
	if (!($result && $another_result && $yet_another))
	  throw new Exception("Something went wrong!!");
	  
	return $html;
}


function give_me_groups() {
	
	$error = "";
	$good_mes = "";
	$message = "";
	
	$username = $_SESSION['username'];
	
	/** Accept all the posted data here **/
	
	$del_me = $_POST['del_me'];
	$add_me = $_POST['add_me'];
	$invite_to = $_POST['invite_to'];
	$invitee = $_POST['invitee'];
	
	//this block is for inviting an invitee to a group
	try { 
	  if (!($invite_to && $invitee))
	    $error .= "";
	  else if (($invitee && !$invite_to) || (!$invitee && $invite_to))
	     throw new Exception("Fields not filled correctly!");
	  else {
	     invite($invitee, $invite_to, $username);
	     $good_mes .= "Invited <b>".$invitee."</b> to <b>".$invite_to."</b>";
	  }
	}catch (Exception $e){
	  $error .= $e->getMessage(); 	
	}
	// for adding groups for a user
	if (!$add_me)
   $error .= "";
	else if (count($add_me) > 0){
	  foreach($add_me as $group) {
		 $added = add_group($username, $group);
		 if ($added)
		   $good_mes .= "Added ".htmlspecialchars($group)."<br/>";
		 else
		   $error .= "Could not add ".htmlspecialchars($group)."<br/>";   
	  }
	} 
	
	
	// for deleting groups
	if (!$del_me)
   $error .= "";
	else if (count($del_me) > 0){
	  foreach($del_me as $group) {
		 $deleted = del_group($username, $group);
		 if ($deleted)
		   $good_mes .= "Deleted ".htmlspecialchars($group)."<br/>";
		 else
		   $error .= "Could not delete ".htmlspecialchars($group)."<br/>";   
	  }
	} 
	
	/** end of accepting the posted data here **/
 
 
 $username = $_SESSION['username'];//extract the username of the current user

 try {
 $groups = table_groups_display($username);
 $recommend = get_recommendations($username);
 $invite = get_invite_form($username);
 
 }catch(Exception $e) {
   $error = $e->getMessage();	 
}

    
	/**     This section is to return the form for adding bookmarks(and the urls to display): BASICALLY FOR DISPLAY OF GOOD MESSAGES
* OR ERRORS
**/ 
if ($error || $good_mes)
   $message = ($error ? "<p class='mild-bad-mes'>".$error."</p>" : "<p class='good-mes'>".$good_mes."</p>");
else $message = "";

/** end of error display section **/
 
 
$give_me_groups = <<<SOME
 <p class='good-mes'>Manage Your Groups Here!</p>
 
 <div>
   {$message}
 </div>
 
 <div id="my_groups">
    <p><b>You belong to these groups:</b> </p>
    <p>Very soon clicking on any group will enable you see the its profile.</p>
	<p>You can leave any group/groups by checking the checkoxes at corresponding rows</p>
	<br/>
    {$groups}
	<br/><br/><br/>
	<p><b>RECOMMENDATIONS AND INVITATIONS</b></p>
	<p>You can join any group/groups by checking the checkoxes at corresponding rows. Note: this feature has an impending bug.</p>
	{$recommend}
  </div>
  <br/><br/><br/>
  <p><b>INVITE OTHERS</b></p>
  <p style='color: #121212; font-style:italic;'>To invite a person on the network  to one of your groups, type the name of the person and select the group you want to invite the user to. Then press the invite button.<p>
<div>{$invite}</div>

  <br/><br/><br/>
SOME;
 
 
 return $give_me_groups; 
}

$my_groups = new Inpage();
$my_groups->content = give_me_groups();
$my_groups->display("Check out your groups");

?>