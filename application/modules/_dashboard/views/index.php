<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	// ob_start();
	?>
	<div class="widgets-container stage ">
		<?php
		do_action('display_widgets_dashboard');
		// return  ob_get_clean();
		?>
	</div>
	<?php
?>
