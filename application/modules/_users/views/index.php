<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="w3-container">
	<h2>Users</h2>
	<section class="w3-container w3-padding">

		<div class="user-display-buttons-links">
			<?php
				if (is_logged_in()) {
					if (get_user_role(get_current_user_id()) == 'admin' || get_user_role(get_current_user_id()) == 'manager') {
			?>
						<a class="w3-button w3-theme-action w3-hover-theme" href="<?= base_url('_users/add_user') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
			<?php 	} 
				}
			?>
			<a class="w3-button w3-theme-action w3-hover-theme" href="<?= base_url('_users/edit_profile/' . get_current_user_id()) ?>"><i class="fa fa-edit" aria-hidden="true"></i> Edit Profile</a>
			<a class="w3-button w3-theme-action w3-hover-theme" href="<?= base_url('_users/edit_account/' . get_current_user_id()) ?>"><i class="fa fa-cog" aria-hidden="true"></i>  Account Settings</a>
			<?php 
				do_action('users.display_buttons_links');
			?>
		</div>
		<div class="users-content w3-margin-top">
			<?php
				do_action('users.index.do_content');
			?>
		</div>

	</section>
</div>