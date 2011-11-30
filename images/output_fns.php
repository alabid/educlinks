<?php
/**
Author: Daniel Alabi
name: output_fns.php
*/

//variable to store if the search form has been displayed 
$has_displayed_form = false;

$usertypes = array(
	  "prospie" => "Prospective Student",
	  "student" => "College Student",
	  "alumni" => "Alumni",
	  "advisor" => "Advisor"
	);

function db_conn () {
//be sure to change all of these when you really want to use it
$query = new mysqli("localhost", "user", "user", "educlinks");

if (!$query)
  throw new Exception("Could not connect right now. Pls. try again later.");
 else return $query;
}

function display_topsearchform() {
 ?>
         <form action="search.php" method="get" >
             <label for= "top_search_form">
                     Search   educlinks
             </label>
             <input name= "search" class="searchbox" type="text" size= "25"/>
             <input type="hidden" value=0 name="is_adv"/>
             <button  title= "search" class="search" type="submit"></button>
          </form>
<?php
                            
            global $has_displayed_form;
             $has_displayed_form = true;
}
 ?>  
 
                     
<?php
function get_header($title, $css="screen.css", $jsfile="educlinks.js") {
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta name="description" content="Create Educational Links/Connections" />
    <meta name="keywords" content="Prospective Student, college Student, alumni, Advisors" />
    <meta name="author" content="Daniel Alabi" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" /> 
    <!-- <link type="text/css" href="reset.css" rel="stylesheet"/>-->
    <link type="text/css" href='<?php echo $css;?>' rel="stylesheet"/>
    <title><?php echo $title; ?></title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js">
    </script>
    <script  src='educlinks.js' type="text/javascript">
    </script>
    <script type="application/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
     
    </head>
    
    <body>
       <div id="wrapper">
          <div id="header"><!--begins header-->
             <div id="intro"><!--begins intro slab for img and search form-->
               <a id="logo" title="edulinks home" href="http://www.educlinks.com">
                    <img  src= "/images/educlinks(arial).png" width="300" height= "100" alt="edulinks"/>
                    
                </a>
               <div id="top_search_form">
 
<?php                   
						//change login.php to real_login for it to work
                        $scriptname = $_SERVER["SCRIPT_NAME"];
                        $pages_notallowed = array("login.php", "search.php");
                        
						//change to real domain not localhost
                        if ($_SERVER["HTTP_HOST"] == "localhost") {
                            $filename = substr($scriptname, strrpos($scriptname, "/")+1);
                            
                            if (!in_array($filename, $pages_notallowed) && !$has_displayed_form)
							display_topsearchform();
                                
}
?>
    
                </div><!--close of searchform-->
              </div><!--close of intro-->
              
              <!--[if IE]> 
               <div id="IE"> 
              <![endif]--> 
              <div id = "top_nav_bar">
                <ul>
<?php
             $signedin = is_user_signedin();
                    
              $signedin ? do_loggedinbar() : do_notloggedbar(); 
			    
 ?>
 
 
            </ul><!--close of list-->
           </div> <!-- close of nav_bar-->
           <!--[if IE]> 
           </div> 
           <![endif]--> 
          </div><!-- close of header-->
 
<?php
 
}
function do_loggedinbar() {
?>
               <li><a href="home.php">Home</a></li>
               <li><a  href="discuss.php">Discussions</a></li>
               <li><a  href="about.php">About</a></li>
               <li><a  href="account.php">Account</a></li>
                        
                      
<?php
}
                    
function do_notloggedbar() {
?>
                        
            <li><a href="login.php">Login</a></li>
            <li><a  href="register.php">Register</a></li>
            <li><a  href="about.php">About</a></li>
            <li><a  href="contact.php">Contact Us</a></li>
                   
<?php
                        
}
?>

<?php
function is_user_signedin() {	
	if (isset($_SESSION['username']) && isset($_SESSION['usertype']))
         return true;
}
       
?>                   
  
	
<?php

function spage_styles() {
	$scriptname = $_SERVER['SCRIPT_NAME'];
   	$filename = substr($scriptname, strrpos($scriptname, "/")+1);
	
	if ($filename=="search.php") {
?>
style="top: 3px;"
<?php
	}
}

function get_bot_searchform() {
?>
<div id="bottom_searchform">
   <form action="search.php" method="get" >
   <label for= "bottom_searchform">
    Search for a: &nbsp;&nbsp;&nbsp; 
   </label>
   <div id="select_searchtype">
   Person
   </div>
   <div id="search_types" <?php spage_styles(); //search page styles ?>>
      <ul>
         <li>Person</li>
         <li>Group</li>
         <li>School</li>
      </ul>
   </div>
    &nbsp;&nbsp;&nbsp;
   <input class="searchbox" name="search" type="text" size= "25"/>
   <input id="type" name="type" value="Person" type="hidden"/>
   <input  name="is_adv" value="1" type="hidden"/>
   <button  title= "search" class="search" type="submit"></button>
   </form>
   
</div>
<?php
}
?>

<?php
function get_frontpage_content() {
?>
 
<?php get_init_content(); ?>

<?php
get_message();

get_loginform();

get_bot_searchform();
?>
     
<?php get_close_content(); ?>
   
<?php
}
function get_footer() {
?>  
    <div id="footer">
       <div id="bottom_nav_bar">
         <ul>
            <li><a  href="/discuss.php">Blog</a></li>
            <li><a  href="/about.php">About</a></li>
            <li><a  href="/contact.php">Feedback</a></li>
         </ul>
      </div><!-- close of bottom_nav_bar -->
      <div id="other">
      This is a <a target="_blank" href="http://alabidan.wordpress.com">Daniel Alabi Website Production</a> |    See also: <a href="#">Help improve <span class= "website">educlinks.com</span></a>
   <p><a href="/privacy.php">Privacy</a> | <a href="/terms.php">Terms</a></p> 
      </div><!-- close of other -->
   <div id="copyright">
   <p>Some Rights Reserved</p>
   <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">This website</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.
            </div><!-- close of copyright -->
   
         </div> <!-- here close up footer ie. open and close div tags-->
	  </div><!-- close of wrapper -->
   </body>
     
     </html>
<?php
}

?>



<?php
function get_message() {
?>
 <div id="message">
        <p class="stylishtext">Create Educational Links</p>
        <div id="messagebody">
            <div class="prospie mes">
                <div class="pers"><span><img width="20" height="20" title="Prospies" src="/images/prospie.png"/></span><span>Prospective Student: Learn more about colleges</span></div><!-- end of pers div-->
               <div class="toggle"> <ul>
                    <li>Make Study Groups</li>
                    <li>Discuss with College Students, Alumni, and Advisors</li>
                    <li>Get linked to useful Resources/Information</li>
                </ul>
                </div><!-- end of toggle div-->
            </div><!-- end of prospie mes -->
            <div class="student mes">
                <div class="pers"><span><img width="20" height="20" title="Students" src="/images/student.png"/></span><span>College Student: Enjoy your college Life</span></div><!-- end of pers div-->
                <div class="toggle">
                <ul>
                    <li>Make Study Groups</li>
                    <li>Discuss with Prospective Students, Alumni, and Advisors</li>
                    <li>Get linked to useful Resources/Information</li>
                </ul>
                </div><!-- end of toggle div -->
            </div><!-- end of student mes-->
            <div class="alumni mes">
                <div class="pers"><span><img width="20" height="20" title="Alumni" src="/images/alumni.png"/></span><span>Alumni: Connect with fellow Alumni and impact on your Alma mater</span></div><!-- end of pers -->
                <div class="toggle">
                <ul>
                    <li>Make Groups with fellow Alumni</li>
                    <li>Discuss with fellow Alumni and Students</li>
                    <li>Get linked to useful Resources/Information</li>
                </ul>
                </div><!-- end of toggle -->
            </div><!-- end of alum mes -->
            <div class="advisor mes">
                <div class="pers"><span><img width="20" height="20" title="Advisors" src="/images/advisor.png"/></span><span>Advisors: Your Gateway to Better Organization</span></div><!-- end of pers -->
                <div class="toggle">
                <ul>
                    <li>Organize your advisees into groups and be more efficient</li>
                    <li>Discuss with College Students, Alumni, and prospective students</li>
                    <li>Talk to your advisees more often</li>
                    <li>Quickly refer your advisees to useful resources/links/blogs</li>
                </ul>
                </div><!-- end of toggle -->
            </div><!-- end of advisor mes -->
        </div><!-- end of messagebody -->
    </div><!-- end of message -->
<?php
}
?>

<?php 
function get_loginform() {
?>
<div id="loginform">
    <div id="logintext">
        Login
    </div><!-- end of logintext -->
    <div id="loginbody">
   <div id="signinform">
       <form id="loginform1" method="post">
           <table  border="0">
              <tr>
                <td ><label for="username">Username: </label></td>
                <td><input type="text" name= "username" id="username" title="username" /></td>
              </tr>
              <tr>
                <td><label for="password">Password: </label></td>
                <td><input type="password" name="password" id="password" title="password"/></td>
              </tr>
        </table>

           <input class="button" type="submit" value="Log In"/>
       </form>
   </div><!-- end of signinform -->
   <div id="signupform">
       <span>Not a Member? </span><a href="/register.php">Sign Up</a>
   </div> <!--- end of sigupform -->
   <div id='ajax_loader'><img src='/images/ajax-loader.gif' alt='loading...'/></div>
   <?php get_getpassform(); ?>
   </div><!-- end of loginbody -->
</div><!-- end of loginform-->
<?php
}
?>

<?php
function display_search_results($searchterm) {
	$searchterm = trim($searchterm);

?>
<div id="search-result">
   <div id="result-header">Search Results</div>
<?php
if (!$searchterm) {
    do_good_mes("No search results available");
	return;
}
global $usertypes;

if (!get_magic_quotes_gpc())
   addslashes($searchterm);
   
$array_words = explode(" ", $searchterm);

$conn = db_conn();
$result = $conn->query("select * from user where name like '%".$searchterm."%'");
$count = 0;

if ($result->num_rows < 1){
    do_good_mes("No search results available");
	return;   
}

if ($result->num_rows < 10) {
	
	for($i=0; $i < $result->num_rows; $i++) {
		if ($count < 10) {
			$row = $result->fetch_object();
			echo "<div class='one-search'>";
			echo "<img  src='show_image.php?name={$row->username}' alt='this is an image'/>";
			echo "<div class='personal_info'>";
			echo "<span><strong>Name:</strong> {$row->name}</span>";
			$usertype = $usertypes[$row->usertype];
			echo "<p><strong>Usertype:</strong> $usertype</p>";
			echo  "</div>";
			echo "</div>";
			$count++;
		}
	}	
	foreach ($array_words as $searchtoken) {
		 $another_result = $conn->query("select * from user where name like '%".$searchtoken."%'"); 
		 
		 for($i=0; $i < $another_result->num_rows; $i++) {
			 if ($count < 10) {
				$row = $another_result->fetch_object();
				echo "<div class='one-search'>";
				echo "<img  src='show_image.php?name={$row->username}' alt='this is an image'/>";
				echo "<div class='personal_info'>";
				echo "<span><strong>Name:</strong> {$row->name}</span>";
				$usertype = $usertypes[$row->usertype];
				echo "<p><strong>Usertype:</strong> $usertype</p>";
				echo  "</div>";
				echo "</div>";
				$count++;
			 }
	     }	
	}
} else {
    for($i=0; $i < 10; $i++) {
	   $row = $result->fetch_object();
	    echo "<div class='one-search'>";
        echo "<img  src='show_image.php?name={$row->username}' alt='this is an image'/>";
        echo "<div class='personal_info'>";
        echo "<span><strong>Name:</strong> {$row->name}</span>";
		$usertype = $usertypes[$row->usertype];
        echo "<p><strong>Usertype:</strong> $usertype</p>";
        echo  "</div>";
        echo "</div>";
	}	
}

?>
</div><!-- end of search_result -->
<?php

}
function get_search_results($searchterm, $type = "Person") {
	
get_init_content();

get_bot_searchform();
?>
  <br/><br/><br/><br/><br/>
  
<?php
do_good_mes("You searched for <b> ".$searchterm." </b> and your type of search is<b> ".$type."</b>");

if ($type=="Person")
    display_search_results($searchterm);
else
   do_good_mes("Not available");

get_close_content();
}

function get_init_content() {
	
?>
	 <div id="content">
     <div id="big_error">
                <span><img alt= "stop" title= "AN ERROR OCCURED" src="/images/stop.png"/></span>
                <span id="error-mes">This is a very big error</span>
      </div><!-- end of big_error -->


<?php
}
?>

<?php 
function get_close_content() {
?>
       </div><!-- end of content div -->
<?php
}
function get_getpassform() {
?>
<div id="getpassform">
       <p>Lost Password? Enter your username below: </p>
       <form action="forgot_pass.php" method='post'>
           <input type="text" name= "user_for_pass" title="username"/>
           <input class="button" type="submit" value="Get Password"/>
       </form>
   </div> <!-- end of getpassform -->
<?php
}

function do_good_mes($message) {
   echo '<div class="good-mes">'.$message.'</div>';	
}

function do_bad_mes($message) {
   echo '<div class="bad-mes">'.$message.'</div>';
}

function get_registerform() {
?>
<div id="prelude">
    <div id="welcome-mes">
        <p>Welcome to <span class="website">edulinks.com</span></p>
        <p id="signup">Sign Up Here</p>
        <p id= "marked">All fields marked * are required</p>
    </div>
</div>
<div id="personal_info">
   <p id="personal_infoheader">Personal Information</p>
   <form id="signupForm" name="signupform" method="post" action="verify.php" >
     <table>
		<tr>
        	<td><label for="firstname">*Firstname: </label></td>
			<td><input name="firstname" type="text" id="firstname" /></td>
        </tr>
	
		<tr>
			<td><label for="lastname">*Lastname: </label></td>
			<td><input name="lastname" type="text" id="lastname"/></td>
		</tr>

		<tr>
			<td><label for="username">*Username: </label></td>
			<td><input name="username" id="username" type="text" />
            <div class="required">Must be between 6 to 20 characters long and start by a letter. Only numbers, letters, dashes (-), underscores (_) and periods (.) </div>
            </td>
		</tr>
		<tr>
			<td><label for="password">*Password: </label></td>
			<td><input name="password" type="password" id="password" />
            <div class="required">Must be 8 characters long or above and must contain at least one number and one letter. Only numbers, letters, dashes (-), underscores (_) and periods (.) </div>
            </td>
		</tr>

		<tr>
			<td><label for="confirm_password">*Confirm password: </label></td>
			<td><input name="confirm_password" type="password" /></td>
		</tr>
		<tr>
			<td><label for="email">*Email: </label></td>
			<td><input name="email"  type="text" /></td>
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
          <td><input name="school"  type="text"/></td>
        </tr>
        </table>
        <div id="recaptcha">
            <?php 
			    require_once('recaptchalib.php');
                $publickey = "6Lf0u78SAAAAAPDGvsn-dxiBN_0NCmRWHuH9DJoN"; // you got this from the signup page
                echo recaptcha_get_html($publickey);
			?>
        </div>
		<p>
			<input type="checkbox" class="checkbox" id="agree" name="agree" />
            <label for="agree">I certify that I am over 13 and agree to the edulinks.com Privacy Policy and Terms of Use</label>
			
		</p>
		
		<p>
			<input class="button" type="submit" value="Sign Up"/>
		</p>


</form>
</div>
<?php
}
function display_sidebar($username, $usertype) {
	
?>
<div id="leftsidebar">
  <div class="profile_bar sect">
   <div class="pers"><span><img width="20" height="20" title="Students" src="/images/profile.png"/></span><span>Profile</span></div>
    <div class="toggle">
    <ul>
       <li><a href="/profile.php?view">View Profile</a></li>
       <li><a href="/profile.php?edit">Edit Profile</a></li>
       <li><a href="/profile.php?reputation">Your Reputation</a></li>
       <li><a href="/change_pass_form.php">Change Password</a></li>
    </ul>
    </div>
  </div>
  <div class="sect groups_bar">
     <div class="pers"><span><img width="20" height="20" title="Students" src="/images/groups.png"/></span><span>Groups</span></div>
    <div class="toggle">
    <ul>
      <li><a href="/my_groups.php">My Groups</a></li>
      <li><a href="/coming.php">Messages</a></li>
      <li><a href="/create_group.php">Create a Group</a></li>
      <li><a href="/coming.php">Group tasks</a></li>
    </ul>
    </div>
  </div>
  <div class="sect recommend_bar">
     <div class="pers"><span><img width="20" height="20" title="Students" src="/images/recommend.png"/></span><span>Recommend</span></div>
    <div class="toggle">
    <ul>
      <li><a href="/resources.php">Resources/sites</a></li>
     
    </ul>
    </div>
  </div>
  <div class="sect discuss_bar">
     <div class="pers"><span><img width="20" height="20" title="Students" src="/images/discuss.png"/></span><span>Ask and Discuss With: </span></div>
    <div class="toggle">
    <ul>
     <?php display_links($usertype); 
	 
	 global $usertypes;
	 ?>
    </ul>
    </div>
  </div>
  <div class="get_rec_bar sect">
    <div class="pers"><span><img width="20" height="20" title="Students" src="/images/get_rec.png"/></span><span>Get Recommendations</span></div>
   <div class="toggle">
    <ul>
      <li><a href="/get_rec.php">From Fellow <?php echo $usertypes[$usertype];?></a></li>
    </ul>
    </div>
  </div>
 
</div>
<?php
}

function display_recognition($username, $usertype) {
?>
 
  <div id="recognition">
    You are signed in as: <strong><?php echo $username; ?></strong>
  </div>

<?php
}
function display_links($usertype) {

global $usertypes;

$usertypes = array(
	  "prospie" => "Prospective Students",
	  "student" => "College Students",
	  "alumni" => "Alumni",
	  "advisor" => "Advisors"
	);
	
$not_usertype = array();
$count = 0;

foreach ($usertypes as $type => $value) {
	if (strcmp($type, $usertype) != 0)
	   $not_usertype[$count++] = $value;
} 
?>
      <li><a href="/coming.php"><?php echo $usertypes[$usertype]; ?></a></li>
      <li><a href="/coming.php"><?php echo $not_usertype[0]; ?></a></li>
      <li><a href="/coming.php"><?php echo $not_usertype[1]; ?></a></li>
      <li><a href="/coming.php"><?php echo $not_usertype[2]; ?></a></li>
<?php
}
?>