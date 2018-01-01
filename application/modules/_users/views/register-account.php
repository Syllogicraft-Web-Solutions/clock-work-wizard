<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>


<section class="">
	
	<div class="hero-shot full-height full-width w3-display-container" style="">

		<form class="login-form w3-theme-l3 w3-display-middle w3-display-container" method="post">
			<div class="w3-container w3-theme">
				<h3><i class="fa fa-user-plus fa-5" aria-hidden="true">&nbsp;</i>Sign Up</h3>
			</div>

			<div class="enroll-fields-container w3-container">
				<p id="message_container" style="display: none"></p>
				<label>Username</label>
				<input class="w3-input w3-border-theme" type="text" name="user_login" required>
				<br>
				<label>Password</label>
				<input class="w3-input w3-border-theme" type="password" name="user_password" required>
				<br>
				<label>Nickname</label>
				<input class="w3-input w3-border-theme" type="text" name="user_nickname" required>
				<br>
				<label>Email</label>
				<input class="w3-input w3-border-theme" type="email" name="user_email" required>
				<br>
			</div>
			<div class="fields w3-right w3-inline-block" style="width: 30%;">
				<button id="register_submit" class="w3-button w3-theme-action w3-hover-theme" style="width: 100%;">Sign up</button>
			</div>
		</form>
	</div>
	
</section>