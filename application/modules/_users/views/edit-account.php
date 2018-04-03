<?php
     defined('BASEPATH') OR exit('No direct script access allowed');
     $user_data = (array) $page['user_data']->result()[0];
?>
<form class="enroll-form w3-theme-l3 " method="post">
	<div class="w3-container">
		<h2>Edit Account</h2>
	</div>
	<div class="enroll-fields-container w3-container">
		<div class="fields w3-row-padding">
               <h4>Login details</h4>
               <?php
                    generate_textfield('Nickname', 'user_nickname', $user_data['user_nickname'], true);
                    generate_textfield('Username', 'user_login', $user_data['user_login'], true);
                    generate_passwordfield('New Password', 'user_password', '', true);
                    generate_passwordfield('Confirm New password', 'confirm_password', '', true);
                    generate_emailfield('Email', 'user_email', $user_data['user_email'], true);     
               ?>
			<div class="w3-margin">
				<input id="send_email" class="w3-check" type="checkbox" name="send_email">
				<label for="send_email">Send account changes details to this email?</label>
			</div>
		</div>
		<div class="fields w3-right w3-inline-block" style="width: 30%; margin-top: 20px; margin-right: -10px;">
			<button id="register_submit" name="update_account" class="w3-button w3-theme-action w3-hover-theme" style="width: 100%;">Save</button>
		</div>
	</div>
</form>