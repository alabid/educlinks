<?php
include "educlinks_fns.php";//normal include file at the top

$searchterm = $_GET["search"];

$is_advanced = $_GET["is_adv"];


get_header("Welcome to educlinks.com >> Search page");

$is_advanced ? get_search_results($searchterm, $_GET["type"]): get_search_results($searchterm);
?>


<?php

get_footer();

?>

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