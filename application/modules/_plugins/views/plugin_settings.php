<?php
	$plugin = $page['plugin'];
	$plugin_content = $page['plugin_content'];
?>

<section>
	
	<div class="w3-container w3-padding">
		<h2>Settings for <?php echo $plugin; ?></h2>
	</div>
	<div class="enroll-fields-container w3-container">
		<?= $plugin_content ?>
	</div>

</section>
