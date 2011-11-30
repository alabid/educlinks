<?php
include_once "class_home.php";

function get_pass_form() {
  
$pass_form = <<<SOME
   <p class="good-mes">Change your password here!</p>

	<div id="change-pass-form">
 <form method="post" action="change_pass.php"> 
  <table>
    <tr>
      <td><label for="old_passwd">Old Password: </label></td>
      <td><input type="password" name="old_passwd" /></td>
    </tr>
    <tr>
      <td><label for="new_passwd">New Password: </label></td>
      <td><input type="password" name="new_passwd" /></td>
    </tr>
    <tr>
      <td><label for="new_passwd2">Repeat New Password: </label></td>
      <td><input type="password" name="new_passwd2" /></td>
    </tr>
  </table>
  <input type="submit" class="button" value="Change Password" />
  <br/><br/>
 </form>
</div>

SOME;

return $pass_form;

}

$change_pass_form = new Inpage();
$change_pass_form->content = get_pass_form();
$change_pass_form->display("Change Your Password");

?>