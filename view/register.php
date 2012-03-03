<?php
include "educlinks_fns.php";//normal include file at the top
?>

<?php
get_header("Welcome to educlinks.com >> Register now and here!!");

?>
<script type="text/javascript">
  $(document).ready(function() {
  $("#signupForm").validate({
    rules: {
      firstname: "required", 
	  lastname: "required",   // simple rule, converted to {required: true}
      username: {
				required: true,
				minlength: 6
			},
			password: {
				required: true,
				minlength: 8,
				password: true
			},
			confirm_password: {
				required: true,
				minlength: 8,
				equalTo: "#password",
				password: true
			},
			email: {
				required: true,
				email: true
			},
			gender: {
        selectNone: true
      },
	  usertype: {
		selectNone: true  
	  },
      agree: "required"
    },
    messages: {
			firstname: "Please enter your firstname",
			lastname: "Please enter your lastname",
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 6 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 8 characters long"
			},
			confirm_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 8 characters long",
				equalTo: "Please enter the same password as above"
			},
			email: "Please enter a valid email address",
			agree: "Please accept our policy"
    }
  });
  $("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});
	
	$("form#signupForm table tr select#usertype").change(function() {
         var selected = this.selectedIndex;
         var value_selected = this.options[selected].value;

         if (value_selected == "prospie"|| value_selected == "student" ){
	         $("form#signupForm table tr#school").css("visibility", "visible");
	   }else {
		    $("form#signupForm table tr#school").css("visibility", "hidden");
		 }
    });
});
jQuery.validator.addMethod(
  "selectNone",
  function(value, element) {
    if (element.value == "none")
    {
      return false;
    }
    else return true;
  },
  "Please select an option."
);

jQuery.validator.addMethod(
  "school", 
  function(value, element) {
	if (element.value == "" || (/\d/.test(element.value)))
	   return false;
	else return true;  
  },
  "Pls. enter a correct school name."
);

jQuery.validator.addMethod(
  "password",
  function(value, element) {
	  if (/\d|\s/.test(element.value)){
	     return true;
	  }
      else return false; 
	  },
	  "Password must have at least one digit and character"
);


  </script>


<?php
get_init_content();
?>
<div id="prelude">
    <div id="welcome-mes">
        <p>Welcome to <span class="website">edulinks.com</span></p>
        <p id="signup">Sign Up Here</p>
        <p id= "marked">All fields marked * are required</p>
    </div>  
</div>
<div id="display_errors">
</div>
<div id="personal_info">
   <p id="personal_infoheader">Personal Information</p>
   <form id="signupForm" name="signupform" method="post" onsubmit="javascript: Recaptcha.reload();" >
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
			<td><input name="confirm_password" id="confirm_password" type="password" /></td>
		</tr>
		<tr>
			<td><label for="email">*Email: </label></td>
			<td><input name="email" id="email" type="text" /></td>
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
          <td><input name="school"  id="school" type="text"/></td>
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
			<input value="agreed" type="checkbox" class="checkbox" id="agree" name="agree" />
            <label for="agree">I certify that I am over 13 and agree to the edulinks.com Privacy Policy and Terms of Use</label>
			
		</p>
		
		<p>
			<input class="button" type="submit" value="Sign Up"/>
		</p>


</form>
</div>
<?php
get_close_content();
?>
<script type="text/javascript">
function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}


$("#signupForm").submit(function() {
		 
		var agreed = $("#agree").is(":checked");
		
		var agreed_result = "";
		
		if (agreed) agreed_result = "true";
		else agreed_result = "false";

	   
		var carry_on = {
			firstname: $("#firstname").val(),
			lastname: $("#lastname").val(),
			username: $("#username").val(),
			email: $("#email").val(),
			school: $("input#school").val(),
			usertype: $("#usertype").val(),
			gender: $("#gender").val(),
			password: $("#password").val(),
			confirm_password: $("#confirm_password").val(),
			recaptcha_response_field: $('input[name="recaptcha_response_field"]').val(),
			recaptcha_challenge_field: $('input[name="recaptcha_challenge_field"]').val(),
			agree: agreed_result
			};
	    
		 
		 $.post("ajax_register.php",carry_on ,function(data)
        {
	
		
          if(trim(data) ==="yes") //if correct login detail
          {
               document.location = "home.php";
			   
          }
          else
          {    
		      $("#display_errors").html(data);
			  $("html").animate({ scrollTop: 20 }, "slow");
          }
       });
       return false;//not to post the  form physically

});

		
		// show a simple loading indicator
		
	
		
				
</script>

<?php
get_footer();

?>