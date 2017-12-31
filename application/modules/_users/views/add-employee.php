<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>


<form class="enroll-form w3-theme-l3 " method="post" action="<?= base_url() . $page['module_name'] ?>_users/add_employee">
	<div class="w3-container w3-padding">
		<h2>Add Employee</h2>
	</div>
	<div class="enroll-fields-container w3-container">
		<div class="fields w3-row-padding">
			<div class="w3-margin">
				<label>Last Name</label>
				<input class="w3-input w3-border-theme" type="text" name="last_name">
			</div>
			<div class="w3-margin">
				<label>First Name</label>
				<input class="w3-input w3-border-theme" type="text" name="first_name">
			</div>
			<div class="w3-margin">
				<label>Middle Name</label>
				<input class="w3-input w3-border-theme" type="text" name="middle_name">
			</div>
		</div>
		<div class="fields w3-row-padding">
			<div class="w3-margin">
				<label>Username</label>
				<input class="w3-input w3-border-theme" type="text" name="username">
			</div>
			<div class="w3-margin">
				<label>Password</label>
				<input class="w3-input w3-border-theme" type="password" name="password">
			</div>
			<div class="w3-margin">
				<label>Email</label>
				<input class="w3-input w3-border-theme" type="email" name="email">
			</div>
		</div>
		<div class="fields w3-right w3-inline-block" style="width: 30%; margin-top: 20px; margin-right: -10px;">
			<button id="register_submit" class="w3-button w3-theme-action w3-hover-theme" style="width: 100%;">Save</button>
		</div>
	</div>
</form>