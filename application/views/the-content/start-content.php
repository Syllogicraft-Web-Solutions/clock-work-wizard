<?php
	
	do_action('body.before_the_content');
	if ($with_sidebar) {
?>
		<div id="the-content-with-sidebar" style="margin-left: <?= $options['width'] ?>">
<?php 
		do_action('body.the_content');
	} else {
?>
		<div>
<?php
		do_action('body.the_content');
	}