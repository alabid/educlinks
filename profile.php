<?php

include_once "class_home.php";
include_once "db_fns.php";

/**
This page will display the profile of a user. The image etc. 

There are two sections:
1. View section: to view the user profile.
2. Edit section: to edit the user profile.
3. My reputation: this part is coming soon. Tell your users that it is still coming soon(very soon).
**/


/**get_details should return an associative array that can be accessed using keys eg.
$details['firstname'], $details['lastname'], $details['email'], $details['gender'], $details['usertype']
$details['school'], $details['profile_pic']
**/
function get_details() {
	
    $conn = db_connect() or die("there seems to be a problem with the database");
	
	$username = $_SESSION['username'];
	
	$result = $conn->query("select * from user where username='$username'");
	$another_result = $conn->query("select * from user_school where username='$username'");
	
	if ($result && $result->num_rows==1) {
	   $row = $result->fetch_object();
	   
	   $name = explode(" ", $row->name);
	 
	   $details = array();
	   $details['firstname'] = $name[0];
	   $details['lastname'] = $name[1];
	   $details['email'] = $row->email;
	   $details['gender'] = $row->gender;
	   
	   $usertype = $row->usertype;
	   if ($usertype=="prospie")
	       $details['usertype'] = "Prospective Student";
	   else if ($usertype=="student")
	       $details['usertype'] = "College Student";
	   else $details['usertype'] = $usertype;
	   
	   $details['school'] = "";
	   
	   if ($another_result) {
	      $another_row = $another_result->fetch_object();
		  $details['school'] = $another_row->school;
	   }
	   
	 
	}
   return $details;
}

function get_image() {
	if ($image)
        return $image;
	else return "avatar.jpg";	
}


function get_profile_message() {
	
/**    View Section     **/
	if (isset($_GET['view'])) {
		
		$details = get_details();
		
		$user_image = get_image();
		
$profile_message = <<<SOME
	<p class="good-mes">View your profile here!!</p>
	
     <table id="view_profile">
		<tr>
        	<td><label for="firstname">Firstname: </label></td>
			<td><span>${details['firstname']}</span></td>
			<td><a href="/profile.php?edit#firstname">Edit</a></td>
        </tr>
	
		<tr>
			<td><label for="lastname">Lastname: </label></td>
			<td><span>${details['lastname']}</span></td>
			<td><a href="/profile.php?edit#lastname">Edit</a></td>
		</tr>

		<tr>
			<td><label for="email">Email: </label></td>
			<td><span>${details['email']}</span></td>
			<td><a href="/profile.php?edit#email">Edit</a></td>
		</tr>
        
        <tr>
           <td><label for ="gender">Gender: </label></td>
           <td>
		    <span>${details['gender']}</span>
           </td>
          <td><a href="/profile.php?edit#gender">Edit</a></td>
        </tr>
        <tr>
          <td><label for ="usertype">Usertype: </label></td>
          <td> 
		    <span>${details['usertype']}</span>  
          </td>
		  <td><a href="/profile.php?edit#usertype">Edit</a></td>
        </tr>
        <tr id="school">
          <td><label for="school">School: </label></td>
          <td><span>${details['school']}</span></td>
		  <td><a href="/profile.php?edit#school">Edit</a></td>
        </tr>
		
		<tr>
		  <td><label for="profile_pic">Porfile Picture: </label></td>
		  <td><img src="show_image.php?name={$_SESSION['username']}" width="100" height="100" alt="this is some avatar here" />
		  </td>
		  <td><a href="/profile.php?edit#userfile">Change</a></td>
		</tr>
		
        </table>
        		
	
SOME;

return $profile_message;
	}
	
	/**   Edit Section      **/
	else if (isset($_GET['edit'])) {
		//get_details should return an associative array that can be accessed using keys eg.
		//$details['firstname'], $details['lastname'], $details['email'], $details['gender'], $details['usertype']
		//$details['school'], $details['profile_pic']
		$details = get_details();
		
$profile_message = <<<SOME
	<p class="good-mes">Edit your profile here!!</p>
	
	<form name="profileinfo_form" method="post" action="profile_process.php" >
     <table id="edit_profile">
		<tr>
        	<td><label for="firstname">*Firstname: </label></td>
			<td><input name="firstname" type="text" id="firstname" value="${details['firstname']}" /></td>
        </tr>
	
		<tr>
			<td><label for="lastname">*Lastname: </label></td>
			<td><input name="lastname" type="text" id="lastname" value="${details['lastname']}"/></td>
		</tr>
		
        <tr>
			<td><label for="email">*Email: </label></td>
			<td><input id="email" name="email"  type="text" value="${details['email']}"/></td>
		</tr>
        
        
        <tr>
           <td><label for ="gender">*Gender: </label></td>
          <td> <select name="gender" id="gender">
             <option value="none">--Select--</option>
             <option value="female">Female</option>
             <option value="male">Male</option>
           </select>
           </td>    
        </tr>
        <tr>
          <td><label for ="usertype">*Usertype: </label></td>
          <td> <select name="usertype" id="usertype">
             <option value="none">--Select--</option>
             <option value="prospie">Prospective Student</option>
             <option value="student">College Student</option>
             <option value="alumni">Alumni</option>
             <option value="advisor">Advisor</option>
           </select>
           </td>
		   		   
        </tr>
        <tr id="school">
          <td><label for="school">School: </label></td>
          <td><input name="school"  type="text" value="${details['school']}"/></td>
        </tr>
		<input name="from_prof_info" type="hidden" value="true"/>
		</table>
		
		<p>
			<input class="button" type="submit" value="Update Profile Info"/>
		</p>
    
	  </form>
<br/><br/>
		<div>
		   <form enctype="multipart/form-data" name="profile_form" method="post" action="profile_process.php" >
		   <label for="profile_pic">Profile Picture: </label></td>
		   <img src="show_image.php?name={$_SESSION['username']}" alt="this is some avatar here" />
               <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
               <input name="userfile" type="file" />
			   <p>
			   <input class="button" type="submit" value="Update Picture"/>
			   </p>
		   </form>
		</div>
		<br/><br/>
	
SOME;

return $profile_message;	
	}
	
	/**  My reputation part  **/
	else if (isset($_GET['reputation'])) {
		
	$profile_message = <<<SOME
    <p class='good-mes'>Find out about your reputation here!!</p>
    		
	<p class='good-mes'>This feature is coming very very soon!! So watch out!</p>
    
	<div class="welcome-mes">
	<p>Your reputation will be based on several factors. Some of which are: </p>
	<ul>
		<li>Your contribution to the educlinks network</li>
		<li>The number of recommendations you have made</li>
		<li>Your degree of participation in groups and how many groups you belong to and participate actively in. However, note that being in so many groups without substantial participation would not increase your reputation.</li>
		<li>How much you help other people within and outside your groups. Preferably, this should span the entire educational hierarchy.</i>
	</ul>
	</div>
SOME;
	
	return $profile_message;
	
	}
	
	//this is for the user that does not go to any reasonable place in the profile environment.
    else {
	  $profile_message = <<<SOME
	 
	 <p class='good-mes'>Do something about your profile: view or edit it. Or see your reputation.</p> 
	 
	<a href='/profile.php?view'>View Profile</a><br/><br/>
	<a href='/profile.php?edit'>Edit Profile</a><br/><br/>
	<a href='/profile.php?reputation'>View Your Reputation</a><br/><br/>

	  
SOME;

return $profile_message;	
    }
}
$page = new Inpage();

$page->content = get_profile_message();
$page->display("Your Profile");


?>