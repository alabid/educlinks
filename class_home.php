<?php


class Inpage {
    public $username;
	public $usertype;	
    public $content;
	
    public function __construct() {
		session_start();
	   $this->username = $_SESSION['username'];   
	   $this->usertype = $_SESSION['usertype'];
	}
	
	public function display($whatever) {
		
		if ($this->username && $this->usertype) {
			include_once "educlinks_fns.php";
			get_header("Edulinks.com >>> ".$whatever);
	
			get_init_content();
			echo "&nbsp;";
			
			display_sidebar($this->username, $this->usertype);
			display_recognition($this->username, $this->usertype);
			
            echo "<div id='userstuff' style='border-width: thin;border-style:solid;border-color:#cccccc;margin-left: 200px;-moz-border-radius:.5em;-khtml-border-radius: .5em;-webkit-border-radius: .5em;border-bottom-radius: .5em;'>";
			echo $this->content; 
			echo "</div>";
			
			get_close_content();
			get_footer();
			
		}
		else {
		   header("Location: login.php");
		}
	}

   
}

?>
