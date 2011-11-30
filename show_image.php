<?php
include "db_fns.php";

function output_anonymous() {
	header("Content-type: image/jpeg");
	$file_a = fopen("/images/avatar.jpg", "rb");
	
	$file = fread($file_a, 99999);
	
	echo $file;
}

/*** some basic sanity checks ***/
function output_image() {
	
	if (isset($_GET['name']))
		{
		/*** assign the image id ***/
		$name = $_GET['name'];
		try     {
			/*** connect to the database ***/
			$conn = db_connect();
			
			/*** The sql statement ***/
			$query = "select * from user_images where user_or_group='$name'";
	
			$result = $conn->query($query); 
			if (!$result) 
			   throw new Exception("Could not retrieve image from the database");
			
			$row = $result->fetch_assoc();
			/*** check we have a single image and type ***/
			if($row)
				{
				//echo "this is something";
				/*** set the headers and display the image ***/
			header("Content-type: ".$row['image_type']);
	
				/*** output the image ***/
				echo $row['image'];
				return true;
				}
			else
				{
				return false;
				}
			}
		catch(Exception $e)
			{
			  
			     return false;
			}
		 }
	  else
			{
				
			return false;
			}
}
/**  If the image is not in the correct place, the output the anonymous one  **/
  /** $is_image_ok = output_image();
  I used to put that line. But since it is too stubborn to display, I will just display a random/anonymous file until I get back to school and 
  fix it
  **/
  
       output_anonymous();
 
?>