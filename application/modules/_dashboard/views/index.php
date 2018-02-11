<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	// var_dump($page);
?>

<header>

</header>

<section class="">
	
<?php
	do_action('clocker.clock');
	do_action('clocker.display_buttons');
?>

</section>

<div id="overlay"></div>
<div id="modal" class="w3-theme-l4"></div>

<div class="w3-container"></div>
