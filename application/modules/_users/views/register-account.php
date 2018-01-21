<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	if (isset($page['error_register'])) {
?>
			<input type="hidden" id="error_message" value='<?= json_encode($page['error_register']) ?>'>
<?php
	}
?>


<section class="">
	
	<div class="hero-shot full-height full-width w3-display-container" style="">

		<form id="register-account" class="login-form w3-theme-l3 w3-display-middle w3-display-container" method="post">
			<div class="w3-container w3-theme">
				<h3><i class="fa fa-user-plus fa-5" aria-hidden="true">&nbsp;</i>Sign Up</h3>
			</div>

			<div class="enroll-fields-container w3-container">
				<p id="message_container" style="display: none"></p>
				<label>Nickname</label>
				<input class="w3-input w3-border-theme" type="text" value="<?php if (isset($page['submitted_post']['user_nickname'])) echo $page['submitted_post']['user_nickname']; ?>" name="user_nickname" required>
				<br>
				<!-- <label>Last Name</label>
				<input class="w3-input w3-border-theme" type="text" name="last_name" required>
				<br>
				<label>First Name</label>
				<input class="w3-input w3-border-theme" type="text" name="first_name" required>
				<br> -->
				<label>Email</label>
				<input class="w3-input w3-border-theme" type="email" value="<?php if (isset($page['submitted_post']['user_email'])) echo $page['submitted_post']['user_email']; ?>" name="user_email" required>
				<br>
				<label>Username</label>
				<input class="w3-input w3-border-theme" type="text" value="<?php if (isset($page['submitted_post']['user_login'])) echo $page['submitted_post']['user_login']; ?>" name="user_login" required>
				<br>
				<label>Password</label>
				<input id="password" class="w3-input w3-border-theme" type="password" name="user_password" required>
				<br>
				<label>Confirm Password</label>
				<input id="confirm_password" class="w3-input w3-border-theme" type="password" name="confirm_password" required>
				<br>
			</div>
			<div class="fields w3-right w3-inline-block" style="width: 50%;">
				<button  id="register_submit" name="register" value="register" class="w3-button w3-theme-action w3-hover-theme" style="width: 100%;">Sign up</button>
			</div>
		</form>
	</div>
	
</section>
<script>
	
	jQuery(document).ready(function() {
		var error = jQuery('#error_message');
		if (error.length > 0) {
			err = JSON.parse(error.val());
			console.log(err);
			icon = '<i class="fa fa-exclamation" aria-hidden="true"></i> &nbsp; &nbsp;';
			mess = '';
			jQuery('#message_container').css({'color': '#E74C3C', 'margin': '0 auto 20px 0'});
			for (var i = 0; i < err.length; i++) {
				mess += '<p>' + icon + err[i] + '</p>';
			}
			jQuery('#message_container').html(mess);
			jQuery('#message_container').fadeIn();
		}
	});

</script>

<script>
	var pw = jQuery('#password');
	var c_pw = jQuery('#confirm_password');


	jQuery(document).on("submit", "#register-account", function(e){
		if (! check_password_match()) {
		    e.preventDefault();
		    return false;
		}
	});

	function check_password_match() {
		if (pw.val() == c_pw.val()) {
			pw.addClass('w3-border-theme');
			c_pw.addClass('w3-border-theme');
			return true;
		} else {
			pw.removeClass('w3-border-theme');
			c_pw.removeClass('w3-border-theme');
			pw.css('border-color', 'red');
			c_pw.css('border-color', 'red');
			pw.focus();
			return false;
		}
	}

</script>