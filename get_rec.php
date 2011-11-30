<?php
include_once "class_home.php";
include_once "db_fns.php";

function display_recommended_urls($urls) {
	$count = 0;
	
    $display .= "<table>\n";
    $display .= "<tr>\n";
    $display .= "<th>Recommendations</th>\n";
    $display .= "</tr>\n";
	
	foreach ($urls as $url) {
	    $display .= "<tr class='s".($count%2)."'>";
		$display .= "<td><a target='_blank' href='$url'>$url</a></td>";
		
		//close of <tr/>
		$display .= "<tr/>";
		$count++;	
	}
	
	$display .= "</table>\n";	
     
	return $display; 	
}

function recommend_urls($username, $popularity=0) {
  	$conn = db_connect();
	
	$query = "select resource from resources
	              where username in
	                    (select distinct(b2.username)
						from resources b1, resources b2
						where b1.username = '$username'
						and b1.username != b2.username
						and b1.resource = b2.resource)
				  and resource not in
				        (select resource
						from resources
						where username = '$username')
				  group by resource	
				  having count(resource) > $popularity";
				  
	$result = $conn->query($query);
	if (!$result)
	    throw new Exception("Could not make recommendations.");
	if ($result->num_rows == 0)
	   throw new Exception("Could not find any bookmarks/resources to recommend");
	   
	$urls = array();
	
	for ($i=0; $i < $result->num_rows; $i++) {
	   $row = $result->fetch_row();
	   $urls[$i] = $row[0];	
	}
	
	return $urls;
}

function get_rec() {
 $username = $_SESSION['username'];
 
 $error = "";
 
   try {
     $urls = recommend_urls($username);	
     $url_display = display_recommended_urls($urls);
   } catch (Exception $e) {
	  $error = $e->getMessage(); 
   }
   
  $error = ($error ? "<p class='good-mes'>".$error."</p>": $error);
  
$get_rec = <<<SOME
  <p class="good-mes">Get recommendations here!</p>
  
  <div>{$error}</div>
  
  <div id="recommendations">
    {$url_display}
  </div>
SOME;
 
  return $get_rec;
}


$get_rec = new Inpage();
$get_rec->content = get_rec();
$get_rec->display("Get Recommendations here.");

?>