/**
 *Author: Daniel Alabi
 *This is a jQuery plugin to create a drop down menu from an array of sub menu
 *items and a link that you want the sub-menu to appear under.
 *
 *Example of Function Call:
 *
 *var arr_hor = {
        "family":"family.php",
        "happen": "happen.php",
         "reason": "reason.php"          
                };
                
        var this = $("ul li a[href='#home']");
        this.createDropDown(arr_hor);
        
 This automatically creates a drop down menu and inserts it under this:
 *the link you want the drop down items to be under.
 *
 *
 */

//finds the maximum height of elements in the set of matched elements
$.fn.maxHeight = function() {
    
      var max = 0;
  
      this.each(function() {
        max = Math.max( max, $(this).outerHeight() );
      });
  
      return max;
    };
    
    
 //finds the maximum width of elements in the set of matched elements  
     $.fn.maxWidth = function() {
        var max = 0;
        
        this.each(function() {
            max = Math.max(max, $(this).outerWidth());
            });
        return max;
        };   
 
 //creates a dropdown menu    
    $.fn.createDropDown = function(arr_hor) {
        var result;
        result = "<div class= 'dropdown'><ul>"
    
        $.each(arr_hor, function (text, href) {
            result += "<li><a href='" + href + "'>" + text + "</a></li>" ;
        });
        result += "</ul></div>";
        
        $(result).insertAfter(this);
        var dropdown = $(".dropdown");
        
        //document.write("this is the result: ", dropdown.html());
        
        //this's properties
        var this_right = this.outerWidth() + this.css("left");
        var this_bottom = this.outerHeight() + this.css("top");
        
        //dropdown's properties
        var num_links = dropdown.children().length;
        var dropdown_width =  $('.dropdown li').maxWidth();
        var dropdown_height = $(".dropdown li").maxHeight();
        var dropdown_top = this_bottom;
        var dropdown_left = this_right;

        
        css_rules = {
        "top":dropdown_top,
        "left":dropdown_left,
        "width":dropdown_width,
        "height":dropdown_height
      };
        
        dropdown.css(css_rules);
        return dropdown;
    }
$(document).ready(function() {  
        $("#top_nav_bar li a").hover (
             function() {
                
                $(this).addClass("hover");
            }, function() {
                $(this).removeClass("hover");
            }
        );
        

   
       
        var arr_hor = {
        "Profile":"profile.php",
        "Sign Out": "home.php?logout",          
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
	
			$('#top_nav_bar li a[href="'+pagename+'"]').addClass(
			    "current"
			);




});