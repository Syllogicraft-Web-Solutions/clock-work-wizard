<?php
     defined('BASEPATH') OR exit('No direct script access allowed');
     
     $username = get_username($page['id']);
     $user_data = $page['user_data'];
     do_action('users.edit_profile.before_content');
     // echo "<pre>";
     // var_dump($user_data);
     // exit();
?>

<form class="enroll-form w3-theme-l3 " method="post" onsubmit="if (confirm('Confirm Action: Update')) return true; else return false;">
	<div class="w3-container">
		<h2>Edit Profile >> <small><?= $username ?></small></h2>
	</div>
	<div class="enroll-fields-container w3-container">
		<div class="fields w3-row-padding">
               <?php
                    foreach ($user_data as $key => $data) {

                         if (do_action('users.edit_profile.filter_meta_key.remove_meta', [$data->meta_key]) == 'remove')
                              continue; // if the current $data->meta_key is listed then it will exclude it from this current loop

                         if ($data->meta_key == "birthday")
                              generate_date_field(ucfirst(str_replace('_', ' ', $data->meta_key)), $data->meta_key, json_decode($data->meta_value));
                         else if ($data->meta_key == 'workphone' || $data->meta_key == 'cellphone' || $data->meta_key == 'homephone')
                              generate_numberfield(ucfirst(str_replace('_', ' ', $data->meta_key)), $data->meta_key, json_decode($data->meta_value));
                         else if ($data->meta_key == 'state')
                              generate_countryfield(ucfirst(str_replace('_', ' ', $data->meta_key)), $data->meta_key, json_decode($data->meta_value));
                         else if ($data->meta_key == 'user_role') {
                              if (get_user_role(get_current_user_id()) == 'admin')
                                   generate_textfield(ucfirst(str_replace('_', ' ', $data->meta_key)), $data->meta_key, json_decode($data->meta_value));
                         } else {
                              generate_textfield(ucfirst(str_replace('_', ' ', $data->meta_key)), $data->meta_key, json_decode($data->meta_value));
                         }
                    }
                    // generate_textfield('First Name', 'firstname', '');
               ?>
		</div>
		<div class="fields w3-right w3-inline-block" style="width: 30%; margin-top: 20px; margin-right: -10px;">
			<button id="register_submit" name="update_user" class="w3-button w3-theme-action w3-hover-theme" style="width: 100%;">Save</button>
		</div>
	</div>
</form>