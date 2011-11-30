<?php
include "class_home.php";
include "db_fns.php";

$image_array = array("image/jpeg","image/jpg","image/gif","image/bmp","image/pjpeg","image/png");


function upload(){
/*** check if a file was uploaded ***/
if(is_uploaded_file($_FILES['userfile']['tmp_name']) && getimagesize($_FILES['userfile']['tmp_name']) != false)
    {
    /***  get the image info. ***/
    $size = getimagesize($_FILES['userfile']['tmp_name']);
    /*** assign our variables ***/
    $type = $size['mime'];
    $imgfp = fopen($_FILES['userfile']['tmp_name'], 'rb');
    $size = $size[3];
    $name = $_FILES['userfile']['name'];
    $maxsize = 1000000;
     
	 
     global $image_array;
	 
	 if (!in_array($type, $image_array))
	     throw new Exception("Unsupported image type. Upload an image.");
	 
    /***  check the file is less than the maximum file size ***/
    if($_FILES['userfile']['size'] < $maxsize )
        {
        /*** connect to db ***/
        $conn = db_connect();
		
	   $user = $_SESSION['username'];
	   /** and then insert into the database **/
	   $result = $conn->query("INSERT into user_images values ('$user', '$type', '$imgfp', '$size')");
	   
        }
    else
        {
        /*** throw an exception if filesize exceeded the limit ***/
        throw new Exception("File Size exceeded the limit");
        }
    }
else
    {
    // if the file is not less than the maximum allowed, print an error
    throw new Exception("There seems to be a problem. File not uploaded properly");
    }
}


function email_valid($email) {
 $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/i";

 if (preg_match($regexp, $email)) 
    return true;
else return false;
}

function update($name, $email, $gender, $usertype, $school="") {
 	
	$conn = db_connect();
	$username = $_SESSION['username'];   
	$query = "UPDATE user SET email = '$email', name = '$name' , gender = '$gender', usertype = '$usertype' WHERE username = '$username'";
	  
    
	$result = $conn->query($query);
	if (!$result)
	   throw new Exception("there seems to be a problem. Try again later.");
	
	if ($school){
	  $another_query = "UPDATE user_school SET school = '$school' WHERE username='$username'";   
   
    $an_result = $conn->query($another_query);
	 
	
	if (!$an_result)
	     throw new Exception("there seems to be a problem. Try again later.");
	} else if (!$conn->affected_rows) {
	   $another_query = "insert into user_school values ('$username', '$school')";
	   $an_result = $conn->query($another_query);
	  
	   if (!$an_result)
	     throw new Exception ("There seems to be a problem. Try again later.");
	}
	
   return true;
}


/**
after processing the form it should say: file_updated
else it should give some errors and give a link to go back to edit all over again because I don't have time to write ajax stuff now. Will
do it later........
*/


function get_update_prof_mes() {
	
	/** This is for updating the profile information **/
	if (isset($_POST['from_prof_info'])) {
	
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$email = $_POST["email"];
		$school = $_POST["school"];
		$usertype = $_POST["usertype"];
		$gender = $_POST["gender"];
		
		$name = $firstname." ".$lastname;
	
	   try {
			if (!email_valid($email))
			   throw new Exception("The email you just entered is not valid!!");
			   
			 if (!($firstname && $lastname))
				throw new Exception("You did not enter your name properly!");
				
			 if ($usertype == "none" || $gender == "none")
				throw new Exception("You did not fill out gender or usertype correctly!!");
				 
			if ($school) {
				update($name, $email, $gender, $usertype, $school);
			}
			else update($name, $email, $gender, $usertype);
				
			$mes = "<p class='good-mes'>Nice one, you just updated your Profile Information.</p>";
			$mes .= "<p>You can now view your profile now(updated)</p>";
			$mes .= "<a href='/profile.php?view'>View Profile</a>";
			
			return $mes;
				
		}catch (Exception $e) {
			$error = "<p class='bad-mes'>You did something(s) wrong: ".$e->getMessage()."</p>";
			$error .= "<p>You need to go back and correct the error!</p>";
			$error .= "<a href='/profile.php?edit'>Edit Profile</a>";
			
			return $error;		
		}
	}
   /**  This is for updating the profile picture   **/
   
  if(!isset($_FILES['userfile']))
    {
    $error =  "<p class='bad-mes'>Please select a file(imagefile) to upload</p>";
	$error .= "<p>You need to go back and correct the error!</p>";
	$error .= "<a href='/profile.php?edit'>Edit Profile</a>";
	
	return $error;
    }
else
    {
    try    {
        upload();
       
        $mes = "<p class='good-mes'>Thank you for submitting </p>";
		$mes .= "<p>You can now view your profile now(updated) in the backend.</p>";
		$mes .= "<p>For now the image upload is not functioning well but will do in the future.</p>";
		$mes .= "<a href='/profile.php?view'>View Profile</a>";
        
		return $mes;
		}
    catch(Exception $e)
        {
        $error = "<p class='bad-mes'>You did something(s) wrong: ".$e->getMessage()."</p>";
	    $error .= "<p>You need to go back and correct the error!</p>";
		$error .= "<a href='/profile.php?edit'>Edit Profile</a>";
		
		return $error; 
        }
    }

}

$update_prof = new Inpage();
$update_prof->content = get_update_prof_mes();
$update_prof->display("Updating Profile....");
//get the post

// then connect to the database

// then query the database using: UPDATE people SET age = 7, date = "2006-06-02 16:21:00", height = 1.22 WHERE name = "Peggy"

//then see if it works and then display the appropriate message e.g it has been updated. and the provide a link to view the new profile
//remember that this section is for updating the profile information only.


/**   This is for updationg the profile picture.   **/

//this should store the picture in the mysql database

//and then this should tell the user that it has updated the picture and then provide a link for the user to view the new profile

//and then the user should be able to view the new profile: so put a link for the user to view the new profile

//remember to update show_image.php to display by querying a database and then echoing the image to the browser.


?>