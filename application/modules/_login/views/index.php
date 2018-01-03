<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	if (isset($_GET['ref']) != '')
		$url = base_url() . $page['module_name'] . '?ref=' . urlencode($_GET['ref']);
	else 
		$url = base_url() . $page['module_name'];
	
	if (isset($page['login_status'])) {
		if ($page['login_status']['code'] == 'invalid_acc') {
?>
			<input type="hidden" id="error_message" value="<?= $page['login_status']['message'] ?>">
<?php
		}
	}
?>

<header>

</header>

<section class="">
	
	<div class="hero-shot full-height full-width w3-display-container" style="">

		<form class="login-form w3-theme-l3 w3-display-middle w3-display-container" method="post" action="<?= $url ?>">
			<div class="w3-container w3-theme">
				<h3><i class="fa fa-power-off fa-5" aria-hidden="true">&nbsp;</i>Login</h3>
			</div>

			<div class="login-fields-container w3-container">
				<p id="message_container" style="display: none"></p>
				<label>Username</label>
				<input class="w3-input w3-border-theme" type="text" name="username">
				<br>
				<label>Password</label>
				<input class="w3-input w3-border-theme" type="password" name="password">
				<br>
			</div>
			<div class="w3-center w3-margin-bottom w3-right w3-block">
				<button class="w3-button w3-right w3-half w3-ripple w3-theme-d1 w3-hover-theme w3-theme-action" name="login" value="login">Login</button> 
			</div>
		</form>
	</div>

</section>
<div class="w3-container"></div>

<script>
	
	jQuery(document).ready(function() {
		var error = jQuery('#error_message');
		if (error.length > 0) {
			icon = '<i class="fa fa-exclamation" aria-hidden="true"></i> &nbsp; &nbsp;';
			jQuery('#message_container').css({'color': '#E74C3C', 'margin': '0 auto 20px 0'});
			jQuery('#message_container').html(icon + error.val());
			jQuery('#message_container').fadeIn();
		}
	});


</script>