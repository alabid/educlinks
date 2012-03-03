
<?php
/**
This is the login page/home page for edulinks.com.
Handle with care + caution
*/


include_once "output_fns.php";//normal include file at the top

get_header("Welcome to educlinks.com >> Create Educational Links");

get_frontpage_content();
?>


<?php

get_footer();

?>
<script type="text/javascript">
        $("#top_nav_bar li a").hover (
             function() {
                
                $(this).addClass("hover");
            }, function() {
                $(this).removeClass("hover");
            }
        );
        
    </script>
    <script type= "text/javascript">
        
        var arr_hor = {
        "Profile":"profile.php",
        "Sign Out": "logout.php",          
                };
                
                      
        var action_on = $("#top_nav_bar ul li a[href='account.php']");
        var dropdown = action_on.createDropDown(arr_hor);
        
        
         
        $("ul li a[href='account.php']").hover(
            function() {
            
                dropdown.fadeIn("slow");
                },
            function() {
                dropdown.css("display", "none");
            }
        );
        
       dropdown.mouseover (
            function () {
                dropdown.css("display", "block");
                }
               
        );
        
		var pages_out = [
						"login.php", 
						 "register.php", 
						 "about.php", 
						 "contact.php"
		];
				var pages_in = [
						 "home.php", 
                         "discuss.php", 
						"about.php", 
						 "profile.php",
						 "logout.php",
						 "account.php"
					];
						
					
					var all_pages = pages_in.concat(pages_out);
					
			
			var path = location.pathname;
			var pagename = path.substring(path.lastIndexOf("/")+1, path.length);
				
			//unfinished.. can be done later
			var fake = "login.php"; 
	
			$('#top_nav_bar li a[href="'+fake+'"]').addClass(
			    "current"
			);
					
 </script>
 <script type="text/javascript">
	
	var some = $("#messagebody div.mes div.pers");
	
	some.each(function() {
	    $(this).append("<span class='invisible'><img width='16' height='16' title='Advisors' src='arrow.png'/></span>");
	});
	
	$(".invisible").css("display", "none");
	some.each (function() {
		$(this).hover(function() {
	         $(this).find(".invisible").show();
	       }, function() {
		$(this).find(".invisible").hide();
		   });
	});
	
	some.each(function(){
		    $(this).toggle(function() {
			   $(this, ".toggle").next().slideUp("fast");
                    }, function() {
                        $(this, ".toggle").next().slideDown("fast");
			});
		});
	</script>
   <script type="text/javascript">
function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}

$("#loginform1").submit(function() {
			
		$("#ajax_loader").ajaxStart(function() {
			$(this).show("slow");
		}).ajaxStop(function() {
			$(this).hide("slow");
		}).ajaxError(function(a, b, e) {
			throw e;
		});
		
		 $.post("ajax_login.php",{username:$('#username').val(),password:$('#password').val()} ,function(data)
        {

          if (trim(data) == "yes") //if correct login detail
          {
               document.location = "home.php";
			   
          }
          else
          {    
		      $("#big_error").show("slow");
		      $("#big_error #error-mes").html(data);
			  $("#username").focus();
          }
       });
       return false;//not to post the  form physically

});

		
		// show a simple loading indicator
		
	
		
				
</script>

<script type="text/javascript">
    $("div#select_searchtype").append("<span class='invisible'><img width='10' height='10' title='Advisors' src='arrow.png'/></span>");
	
	$("div#select_searchtype").click (function() {
		$("#bottom_searchform #search_types").css("display", "block");
	});
	
	$("#bottom_searchform #search_types li").click(function() {
		$("#bottom_searchform #type").val($(this).text());
		$("div#select_searchtype").text($(this).text());
		$("#bottom_searchform #search_types").css("display", "none");
		$("div#select_searchtype").append("<span class='invisible'><img width='10' height='10' title='Advisors' src='arrow.png'/></span>");
		});
</script>