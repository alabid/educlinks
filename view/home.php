<?php


if (isset($_GET['logout']))
{
	session_start();
  session_destroy();
  header("Location: /login.php");
 
}

include "class_home.php";

function get_user_message() {

  //this is gonna be the message for the newbie
$new_user_message = <<<SOME
    <p class="good-mes">You Are Welcome to Edulinks.com. Thanks for signing up!!</p>
	
	<div class="welcome-mes">
	  <p>Why Should You participate?</p>
	  <ul>
	    <li>To help yourself and others build relationships</li>
		<li>To form useful groups</li>
		<li>Share experiences with your mates and other people in different age groups</li>
		<li>Get recommendations about useful resources based on the responses of other people in the network</li>
		<li>Form strong bonds with your family and friends through this network</li>
	  </ul>
	</div><!-- close of this welcome-mes -->
	
	<div class="welcome-mes">
	  <p>How can I participate?</p>
	  <ul>
	    <li>Make and join Groups</li>
		<li>Recommend useful resources/websites/links to people</li>
		<li>Talk to all types of people in the educational hierarchy</li>
	  </ul>
	</div><!-- close of this welcome-mes -->
	
	<div class="welcome-mes">
	  <p>Do You have to pay?</p>
	  <ul>
	    <li>No, it is absolutely free!! </li>
		<li>No ads</li>
		<li>No tricks</li>
	  </ul>
	</div><!-- close of this welcome-mes-->
SOME;

$old_user_message = <<<SOME
   <p class="good-mes">Welcome to Educlinks.com!!</p>
   
   <div class="welcome-mes">
      <p>Wandering what you want to do today?</p>
	  <ul>
	    <li>You could make a new group</li>
		<li>You could also store some of your bookmarks under your recommend section</li>
		<li>Try talking to your friends in the groups are already belong to.</li>
		<li>If you do not belong to a group, join one or more.</li>
		<li>If you are already in a group and hope to join more, just go for it. It is easy and free.</li>
		<li>Puzzled about something? You could ask your group members about anything at all.</li>
		<li>Since any message you send will be directed towards all your group members, you could pick the best answer from the responses of your group members.</li>
	  </ul>
   </div>
SOME;


   if(!isset($_SERVER['HTTP_REFERER']))
      return $old_user_message;
   else {
	  $refered_by =  $_SERVER['HTTP_REFERER'];
	  
	  $parsed_url = parse_url($refered_by);
	  if (strcmp($parsed_url['path'], "/real_register.php"))
	    return $new_user_message;
	  else
	     return $old_user_message;
   }
}
$page = new Inpage();

$page->content = get_user_message();
$page->display("Welcome to Edulinks.com");
?>