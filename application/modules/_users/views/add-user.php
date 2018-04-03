<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>


<form class="enroll-form w3-theme-l3 " method="post">
	<div class="w3-container">
		<h2>Add User</h2>
	</div>
	<div class="enroll-fields-container w3-container">
		<div class="fields w3-row-padding">
			<div class="w3-margin">
				<label for="nickname">Nickname</label>
				<input id="nickname" class="w3-input w3-border-theme" type="text" name="nickname" value="<?= isset($_POST['nickname']) ? $_POST['nickname'] : '' ?>">
			</div>
			<div class="w3-margin">
				<label for="lastname">Last Name</label>
				<input id="lastname" class="w3-input w3-border-theme" type="text" name="last_name" value="<?= isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>">
			</div>
			<div class="w3-margin">
				<label for="firstname">First Name</label>
				<input id="firstname" class="w3-input w3-border-theme" type="text" name="first_name" value="<?= isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>">
			</div>
			<div class="w3-margin">
				<label for="middlename">Middle Name</label>
				<input id="middlename" class="w3-input w3-border-theme" type="text" name="middle_name" value="<?= isset($_POST['middle_name']) ? $_POST['middle_name'] : '' ?>">
			</div>
		</div>
		<div class="fields w3-row-padding">
			<h4>Login details</h4>
			<div class="w3-margin">
				<label for="username">Username</label>
				<input id="username" class="w3-input w3-border-theme" required type="text" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>">
			</div>
			<div class="w3-margin">
				<label for="password">Password</label>
				<input id="password" class="w3-input w3-border-theme" required type="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>">
			</div>
			<div class="w3-margin">
				<label for="email">Email</label>
				<input id="email" class="w3-input w3-border-theme" required type="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
			</div>
			<div class="w3-margin">
				<input id="send_email" class="w3-check" type="checkbox" name="send_email">
				<label for="send_email">Send account details to this user?</label>
			</div>
		</div>
		<div class="fields w3-right w3-inline-block" style="width: 30%; margin-top: 20px; margin-right: -10px;">
			<button id="register_submit" name="add_user" class="w3-button w3-theme-action w3-hover-theme" style="width: 100%;">Save</button>
		</div>
	</div>
</form>