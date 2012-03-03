<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">

<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
    <style type="text/css">
         #message {
            width: 420px;
         }
         .stylishtext {
            font-family: verdana, Helvetica;
            color: #ffffff;
            background: repeat-x url("menu-dark.jpg")  #0000ff;
            width: inherit;
            font-size: 1.2em;
            text-align: center;
            height: 2em;
            margin-bottom: 0;
            margin-top: auto;
            padding-top: 0;
            padding-bottom: 0;
            -moz-border-radius:.6em;
           -moz-border-radius:.6em;
           -khtml-border-radius: .6em;
           -webkit-border-radius: .6em;
           border-radius: .6em;
           border-radius: .6em;
         }
         #messagebody {
            color: black;
            background-color: white;
            font-family: verdana, Helvetica;
         }
         #messagebody span img {
            vertical-align: text-bottom;
         }
         #messagebody ul {
            list-style: url("list.png");
	    font-size: 0.7em;
            margin-top: 0;
            margin-bottom:0;
            padding-top: 1em;
         }
         #messagebody  div.mes ul:hover{
            background-color: #F8E0E0;
         }
         #messagebody div.mes .toggle{
            border: solid 2px;
            }
         #messagebody div.mes div.pers{
            position: relative;
            top:0px;
            left:0px;
	    padding:0.1em;
            cursor: pointer;
            background: repeat-x url("menu-dark.jpg")  #0000ff;
			 -moz-border-radius-topleft:.5em;
			-moz-border-radius-topright:.5em;
			-khtml-border-radius: .5em;
			-webkit-border-radius: .5em;
			border-top-right-radius: .5em;
			border-top-left-radius: .5em;
         }
         #messagebody div.mes  {
            margin: 1em;
	    padding: 0;
         }
    </style>
</head>
<body>
    <div id="message">
        <p class="stylishtext">Create Educational Links</p>
        <div id="messagebody">
            <div class="prospie mes">
                <div class="pers"><span><img width="20" height="20" title="Prospies" src="prospie.png"/></span><span>Prospective Student: Learn more about colleges</span></div>
               <div class="toggle"> <ul>
                    <li>Make Study Groups</li>
                    <li>Discuss with College Students, Alumni, and Advisors</li>
                    <li>Get linked to useful Resources/Information</li>
                </ul>
                </div>
            </div>
            <div class="student mes">
                <div class="pers"><span><img width="20" height="20" title="Students" src="student.png"/></span><span>College Student: Enjoy your college Life</span></div>
                <div class="toggle">
                <ul>
                    <li>Make Study Groups</li>
                    <li>Discuss with Prospective Students, Alumni, and Advisors</li>
                    <li>Get linked to useful Resources/Information</li>
                </ul>
                </div>
            </div>
            <div class="alumni mes">
                <div class="pers"><span><img width="20" height="20" title="Alumni" src="alumni.png"/></span><span>Alumni: Connect with fellow Alumni and impact on your Alma mater</span></div>
                <div class="toggle">
                <ul>
                    <li>Make Groups with fellow Alumni</li>
                    <li>Discuss with fellow Alumni and Students</li>
                    <li>Get linked to useful Resources/Information</li>
                </ul>
                </div>
            </div>
            <div class="advisor mes">
                <div class="pers"><span><img width="20" height="20" title="Advisors" src="advisor.png"/></span><span>Advisors: Your Gateway to Better Organization</span></div>
                <div class="toggle">
                <ul>
                    <li>Organize your advisees into groups and be more efficient</li>
                    <li>Discuss with College Students, Alumni, and prospective students</li>
                    <li>Talk to your advisees more often</li>
                    <li>Quickly refer your advisees to useful resources/links/blogs</li>
                </ul>
                </div>
            </div>
        </div>
    </div>
    I am testing 1 ,2, 3,,..
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
</body>
</html>